<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\products as Product;
use App\Models\carts as Cart;
use App\Models\Customer;
use App\Models\orders as Orders;
use App\Models\OrderItem;
use App\Models\PaymentMethod;
use App\Models\DeliveryMethod;
use Illuminate\Support\Facades\Auth;

class CartsController extends Controller
{
    public function index()
    {
        $customer = Auth::user()->customer ?? null;
        $cart = $customer
            ? Cart::with('items.product')->where('customer_id', $customer->customer_id)->first()
            : null;

        return view('customer.cart', compact('cart'));
    }

    // Add product to cart (update existing if same product)
    public function add(Request $request, $productId)
{
    $user = auth()->user();
    if (!$user) {
        return redirect()->back()->with('error', 'Please login first.');
    }

    $customer = Customer::where('user_id', $user->id)->first();
    if (!$customer) {
        return redirect()->back()->with('error', 'Customer profile not found.');
    }

    $product = Product::findOrFail($productId);

    $selectedColor = $request->selected_color ?: null;
    $selectedSize  = $request->selected_size ?: null;

    if ($product->color && !$selectedColor) {
        return redirect()->back()->with('error', 'Please choose a color.');
    }

    if ($product->size && !$selectedSize) {
        return redirect()->back()->with('error', 'Please choose a size.');
    }

    $cart = Cart::firstOrCreate([
        'customer_id' => $customer->customer_id
    ]);

    // ✅ Check for existing item with same product + same color + same size
    $cartItem = CartItem::where('cart_id', $cart->cart_id)
        ->where('product_id', $product->product_id)
        ->where('color', $selectedColor)
        ->where('size', $selectedSize)
        ->first();

    if ($cartItem) {
        // Same combination exists → just increment quantity
        $cartItem->increment('quantity');
    } else {
        // Different combination → create new row
        CartItem::create([
            'cart_id'    => $cart->cart_id,
            'product_id' => $product->product_id,
            'color'      => $selectedColor,
            'size'       => $selectedSize,
            'quantity'   => 1
        ]);
    }

    return redirect()->route('customer.cart')->with('success', 'Product added/updated in cart!');
}


    // Update quantity manually
  public function updateQuantity(Request $request, $itemId)
{
    $item = CartItem::findOrFail($itemId);

    $item->quantity = $request->input('quantity', $item->quantity);
    $item->color = $request->input('color', $item->color);
    $item->size = $request->input('size', $item->size);

    $item->save();

    return redirect()->back()->with('success', 'Cart item updated!');
}


    // Increment quantity by 1
    public function increment($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->increment('quantity');
        return redirect()->back();
    }

    // Decrement quantity by 1 (auto delete if 0)
    public function decrement($itemId)
    {
        $item = CartItem::findOrFail($itemId);

        if ($item->quantity <= 1) {
            $item->delete();
        } else {
            $item->decrement('quantity');
        }

        return redirect()->back();
    }

    // Update color/size manually
    public function updateOptions(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);

        $item->update([
            'color' => $request->selected_color,
            'size'  => $request->selected_size
        ]);

        return redirect()->back()->with('success', 'Item options updated!');
    }

    // Remove item completely
    public function remove($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->delete();

        return redirect()->route('customer.cart')->with('success', 'Item removed from cart.');
    }

    // Checkout page
    public function checkout()
    {
        $user = auth()->user();
        if (!$user || !$user->customer) {
            return redirect()->route('customer.cart')->with('error', 'Customer profile not found.');
        }

        $cart = $user->customer->cart()->first();
        if (!$cart) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->items()->with('product')->get();
        $paymentMethods = PaymentMethod::all();
        $deliveryMethods = DeliveryMethod::all();

        return view('customer.checkout', compact('cartItems', 'paymentMethods', 'deliveryMethods'));
    }

    // Submit checkout
    public function submitCheckout(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone'     => 'required',
            'address'   => 'required',
        ]);

        $customer = auth()->user()->customer;
        $cart = $customer->cart()->first();

        if (!$cart || $cart->items()->count() === 0) {
            return back()->with('error', 'Your cart is empty');
        }

        $cartItems = $cart->items()->with('product')->get();

        $totalAmount = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        $order = Orders::create([
            'customer_id'       => $customer->customer_id,
            'full_name'         => $request->full_name,
            'phone'             => $request->phone,
            'shipping_address'  => $request->address,
            'total_amount'      => $totalAmount,
            'order_status'      => 'Pending',
            'payment_method_id' => 1,
            'delivery_method_id'=> 1,
        ]);

        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id'           => $order->order_id,
                'product_id'         => $item->product_id,
                'quantity'           => $item->quantity,
                'price_at_purchase'  => $item->product->price,
                'color'              => $item->color,
                'size'               => $item->size,
            ]);
        }

        // Clear cart
        $cart->items()->delete();

        return redirect()->route('customer.orders')->with('success', 'Order placed successfully!');
    }
}
