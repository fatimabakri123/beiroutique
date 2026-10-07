<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\orders;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use App\Models\Notification;
use App\Models\LoyaltySetting;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\LoyaltyUnlockedNotification;


class OrdersController extends Controller
{
    // Show order page
public function show(products $product)
{
    $paymentMethods = PaymentMethod::all();
    $deliveryMethods = DeliveryMethod::all();
    
    $customer = auth()->user()->customer;
    $loyaltyDiscount = 0;
    $isRewardAvailable = false;

    if ($customer) {
        $loyaltyDiscount = \App\Services\LoyaltyService::getCustomerDiscount(
            $customer, 
            $product->shop_id
        );
        $isRewardAvailable = ($loyaltyDiscount > 0);
    }

    return view('orders.index', compact(
        'product', 
        'paymentMethods', 
        'deliveryMethods', 
        'loyaltyDiscount',
        'isRewardAvailable'
    ));
}

    // Store order
public function store(Request $request, products $product)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'quantity' => 'required|integer|min:1|max:' . $product->stock_quantity,
        'color' => 'nullable|array',
        'size' => 'nullable|array',
        'payment_method_id' => 'required|exists:payment_methods,payment_method_id',
        'delivery_method_id' => 'required|exists:delivery_methods,delivery_method_id',
        'shipping_address' => 'required|string',
        'city' => 'nullable|string|max:100',
        'additional_info' => 'nullable|string',
        'latitude' => 'nullable|numeric',
        'longitude' => 'nullable|numeric',
    ]);

    $customer = auth()->user()->customer;
    $shopId = $product->shop_id;
    $quantity = $request->quantity;

    // =============== CALCULAR PREÇOS ===============

    // 1. Preço base (original)
    $originalPrice = $product->price;
    
    // 2. Verificar se está em sale
    $isOnSale = $product->is_on_sale;
    $salePrice = $isOnSale ? $product->discount_value : null;
    
    // 3. Preço unitário inicial (considerando sale se houver)
    $initialUnitPrice = $isOnSale ? $salePrice : $originalPrice;
    
    // 4. Subtotal base (sem descontos de loyalty ainda)
    $baseSubtotal = $initialUnitPrice * $quantity;
    
    // 5. Calcular desconto de sale (se aplicável)
    $saleDiscountAmount = 0;
    if ($isOnSale) {
        $saleDiscountAmount = ($originalPrice - $salePrice) * $quantity;
    }

    // =============== LOYALTY DISCOUNT ===============
    $loyaltyDiscount = \App\Services\LoyaltyService::getCustomerDiscount($customer, $shopId);
    $loyaltyApplied = false;
    $loyaltyDiscountAmount = 0;
    $finalUnitPrice = $initialUnitPrice;
    
    if ($loyaltyDiscount > 0) {
        // Aplicar loyalty discount ao preço unitário (depois do sale)
        $loyaltyDiscountAmount = ($baseSubtotal * $loyaltyDiscount) / 100;
        $finalUnitPrice = $initialUnitPrice - (($initialUnitPrice * $loyaltyDiscount) / 100);
        $loyaltyApplied = true;
        
        // Marcar recompensa como usada
        \App\Services\LoyaltyService::markRewardAsUsed($customer, $shopId);
    }

    // =============== CALCULAR TOTAIS ===============
    
    // Total do produto (depois de sale + loyalty)
    $productTotal = $finalUnitPrice * $quantity;
    
    // Custo de entrega
    $deliveryMethod = DeliveryMethod::find($request->delivery_method_id);
    $deliveryCost = $deliveryMethod->cost ?? 0;
    
    // TOTAL FINAL (SEM TAXA COD)
    $totalAmount = $productTotal + $deliveryCost;

    // =============== CRIAR ENDEREÇO ===============
    $address = $request->shipping_address;
    if ($request->city) {
        $address .= ', ' . $request->city;
    }
    if ($request->additional_info) {
        $address .= ' - ' . $request->additional_info;
    }

    // =============== CRIAR PEDIDO ===============
    $order = orders::create([
        'customer_id' => $customer->customer_id,
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'payment_method_id' => $request->payment_method_id,
        'delivery_method_id' => $request->delivery_method_id,
        'shipping_address' => $address,
        'order_status' => 'pending',
        
        // Totais
        'total_amount' => $totalAmount,
        'subtotal' => $originalPrice * $quantity, // Preço original total
        
        // Descontos
        'sale_discount_amount' => $saleDiscountAmount,
        'loyalty_discount' => $loyaltyDiscount,
        'loyalty_discount_amount' => $loyaltyDiscountAmount,
        
        // Custos adicionais (SEM COD FEE)
        'delivery_cost' => $deliveryCost,
        'cash_on_delivery_fee' => 0, // Zerado
        
        // Flags
        'loyalty_applied' => $loyaltyApplied,
        'is_on_sale' => $isOnSale,
    ]);

    // =============== ADICIONAR ITENS ===============
    $order->items()->create([
        'product_id' => $product->product_id,
        'quantity' => $quantity,
        
        // Informações de preço
        'price_at_purchase' => $finalUnitPrice, // Preço FINAL pago por unidade
        'original_price' => $originalPrice, // Preço original
        'sale_price' => $salePrice, // Preço de sale (se aplicável)
        'is_on_sale' => $isOnSale,
        
        // Detalhes de desconto
        'loyalty_discount_percentage' => $loyaltyDiscount,
        'loyalty_discount_amount' => $loyaltyDiscount > 0 ? ($loyaltyDiscountAmount / $quantity) : 0,
        
        'color' => $request->color ? implode(',', $request->color) : null,
        'size'  => $request->size ? implode(',', $request->size) : null,
    ]);

    // =============== ATUALIZAÇÕES ===============
    
    // Atualizar loyalty counters
    \App\Services\LoyaltyService::updateCustomerLoyalty(
        $customer, 
        $shopId, 
        $baseSubtotal
    );

    // Decrementar stock
    $product->decrement('stock_quantity', $quantity);

    // Notificar dono da loja
    $ownerUser = $product->shop->owner->user;
    if ($ownerUser) {
        $ownerUser->notify(new \App\Notifications\NewOrderNotification($order, $product));
    }

    // =============== MENSAGEM DE SUCESSO ===============
    $message = 'Order placed successfully! Total: $' . number_format($totalAmount, 2);
    
    if ($saleDiscountAmount > 0) {
        $message .= " | Sale discount: $" . number_format($saleDiscountAmount, 2);
    }
    
    if ($loyaltyDiscountAmount > 0) {
        $message .= " | Loyalty discount (" . $loyaltyDiscount . "%): $" . number_format($loyaltyDiscountAmount, 2);
    }
    
    if ($deliveryCost > 0) {
        $message .= " | Delivery: $" . number_format($deliveryCost, 2);
    }

    return redirect()
        ->route('customer.orders')
        ->with('success', $message);
}
}