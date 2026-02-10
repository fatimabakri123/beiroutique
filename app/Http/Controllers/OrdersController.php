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
    $loyaltyDiscount = 0; // default is 0%

    $loyalty = LoyaltySetting::where('shop_id', $product->shop_id)->first();

    if ($loyalty) {
        // Count previous orders from this customer for this shop
        $ordersCount = $customer->orders()
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.shop_id', $product->shop_id)
            ->where('orders.customer_id', $customer->customer_id)
            ->distinct('orders.order_id')
            ->count();

        // Calculate total spent for this shop
        $totalSpent = $customer->orders()
            ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->join('products', 'order_items.product_id', '=', 'products.product_id')
            ->where('products.shop_id', $product->shop_id)
            ->where('orders.customer_id', $customer->customer_id)
            ->sum(DB::raw('order_items.quantity * order_items.price_at_purchase'));

        // Include current order in the calculation (optional)
        if (($ordersCount + 1) >= $loyalty->min_orders && ($totalSpent + $product->price) >= $loyalty->min_revenue) {
            $loyaltyDiscount = $loyalty->discount_percentage; // e.g., 10 for 10%
        }
    }

        return view('orders.index', compact('product', 'paymentMethods', 'deliveryMethods', 'loyaltyDiscount'));
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

    // 💰 Base total amount
  
$basePrice = $product->is_on_sale 
    ? $product->discount_value 
    : $product->price;

// 💰 Base total amount
$totalAmount = $basePrice * $request->quantity;


    // 🔹 Cash on Delivery surcharge
    $paymentMethod = \App\Models\PaymentMethod::find($request->payment_method_id);
    if (strtolower($paymentMethod->method_name) === 'cash on delivery') {
        $totalAmount += 5;
    }

    // ✅ Combine address fields into one column
    $fullAddress = '';
    if ($request->city) $fullAddress .= 'City: ' . $request->city . "\n";
    $fullAddress .= 'Address: ' . $request->shipping_address . "\n";
    if ($request->additional_info) $fullAddress .= 'More info: ' . $request->additional_info . "\n";
    if ($request->latitude && $request->longitude) {
        $fullAddress .= 'Google Maps: https://www.google.com/maps?q=' . $request->latitude . ',' . $request->longitude;
    }

    // 🔹 Loyalty Discount Calculation
    $shopId = $product->shop_id;
    $loyalty = \App\Models\LoyaltySetting::where('shop_id', $shopId)->first();
    $discountAmount = 0;

  // 🔹 Loyalty Discount Calculation BEFORE creating the order
$shopId = $product->shop_id;
$loyalty = LoyaltySetting::where('shop_id', $shopId)->first();
$discountAmount = 0;

if ($loyalty) {
    // Include current order in totals
    $ordersCount = $customer->orders()
        ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.product_id')
        ->where('products.shop_id', $shopId)
        ->where('orders.customer_id', $customer->customer_id)
        ->distinct('orders.order_id')
        ->count('orders.order_id') + 1; // include this order

    $totalSpent = $customer->orders()
        ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.product_id')
        ->where('products.shop_id', $shopId)
        ->where('orders.customer_id', $customer->customer_id)
        ->sum(DB::raw('order_items.quantity * order_items.price_at_purchase'));

    $totalSpent += $totalAmount; // include this order's total

    if ($ordersCount >= $loyalty->min_orders && $totalSpent >= $loyalty->min_revenue) {
        $discountAmount = ($totalAmount * $loyalty->discount_percentage) / 100;
        $totalAmount -= $discountAmount;
    }
}


    // 👤 Create the order
    $order = orders::create([
        'customer_id' => $customer->customer_id,
        'full_name' => $request->full_name,
        'phone' => $request->phone,
        'payment_method_id' => $request->payment_method_id,
        'delivery_method_id' => $request->delivery_method_id,
        'shipping_address' => $fullAddress,
        'order_status' => 'pending',
        'total_amount' => $totalAmount,
        'discount_applied' => $loyalty ? $loyalty->discount_percentage : 0,
        'discount_amount' => $discountAmount,
    ]);


  // 📦 Add product to order
    $order->items()->create([
        'product_id' => $product->product_id,
        'quantity' => $request->quantity,
        'price_at_purchase' => $basePrice,

        'color' => $request->color ? implode(',', $request->color) : null,
        'size'  => $request->size ? implode(',', $request->size) : null,
    ]);


  
$ownerUser = $product->shop->owner->user;
if ($ownerUser) {
    $ownerUser->notify(new \App\Notifications\NewOrderNotification($order, $product));
}



    // 🔻 Decrement product stock automatically
    $product->decrement('stock_quantity', $request->quantity);

    return redirect()
        ->route('customer.orders', $order->order_id)
        ->with('success', 'Order placed successfully!' . ($discountAmount ? " 🎉 Loyalty discount applied: \${$discountAmount}" : ''));
}


}