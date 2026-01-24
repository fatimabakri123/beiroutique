<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products;
use App\Models\orders;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Auth;

class OrdersController extends Controller
{
    // Show order page
    public function show(products $product)
    {
        $paymentMethods = PaymentMethod::all();
        $deliveryMethods = DeliveryMethod::all();

        return view('orders.index', compact('product', 'paymentMethods', 'deliveryMethods'));
    }

    // Store order
 public function store(Request $request, products $product)
{
    $request->validate([
        'full_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'quantity' => 'required|integer|min:1|max:'.$product->stock_quantity,
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

    // 💰 Calculate total amount
    $totalAmount = $product->price * $request->quantity;

    // إذا اختار المستخدم "Cash on Delivery" زد 5$
    $paymentMethod = \App\Models\PaymentMethod::find($request->payment_method_id);
    if (strtolower($paymentMethod->method_name) === 'cash on delivery') {
        $totalAmount += 5;
    }

    // ✅ Combine address fields into ONE column
    $fullAddress = '';
    if ($request->city) {
        $fullAddress .= 'City: ' . $request->city . "\n";
    }
    $fullAddress .= 'Address: ' . $request->shipping_address . "\n";
    if ($request->additional_info) {
        $fullAddress .= 'More info: ' . $request->additional_info . "\n";
    }
    if ($request->latitude && $request->longitude) {
        $fullAddress .= 'Google Maps: https://www.google.com/maps?q=' 
               . $request->latitude . ',' . $request->longitude;
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
    ]);

    // 📦 Add product to order
    $order->items()->create([
        'product_id' => $product->product_id,
        'quantity' => $request->quantity,
        'price_at_purchase' => $product->price,
        'color' => $request->color ? implode(',', $request->color) : null,
        'size'  => $request->size ? implode(',', $request->size) : null,
    ]);

    // 🔻 Decrement product stock automatically
    $product->decrement('stock_quantity', $request->quantity);

    return redirect()
        ->route('customer.orders', $order->order_id)
        ->with('success', 'Order placed successfully!');
}


}
