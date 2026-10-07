<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Models\products as Product;
use App\Models\carts as Cart;
use App\Models\Customer;
use App\Models\Shop;
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

        $shops = Shop::all();
        return view('customer.cart', compact('cart', 'shops'));
    }

    // ================= ADD TO CART =================
    public function add(Request $request, $productId)
    {
        $user = auth()->user();
        if (!$user) {
            return redirect()->route('login', [
                'redirect' => url()->previous()
            ])->with('error', 'Please login first.');
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

        $cartItem = CartItem::where('cart_id', $cart->cart_id)
            ->where('product_id', $product->product_id)
            ->where('color', $selectedColor)
            ->where('size', $selectedSize)
            ->first();

        if ($cartItem) {
            $cartItem->increment('quantity');
        } else {
            CartItem::create([
                'cart_id'    => $cart->cart_id,
                'product_id'=> $product->product_id,
                'color'     => $selectedColor,
                'size'      => $selectedSize,
                'quantity'  => 1
            ]);
        }

        return redirect()->route('customer.cart')->with('success', 'Product added to cart!');
    }

    // ================= CART ACTIONS =================
    public function updateQuantity(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->quantity = $request->input('quantity', $item->quantity);
        $item->color = $request->input('color', $item->color);
        $item->size = $request->input('size', $item->size);
        $item->save();

        return redirect()->back()->with('success', 'Cart updated!');
    }

    public function increment($itemId)
    {
        CartItem::findOrFail($itemId)->increment('quantity');
        return back();
    }

    public function decrement($itemId)
    {
        $item = CartItem::findOrFail($itemId);
        if ($item->quantity <= 1) {
            $item->delete();
        } else {
            $item->decrement('quantity');
        }
        return back();
    }

    public function updateOptions(Request $request, $itemId)
    {
        $item = CartItem::findOrFail($itemId);
        $item->update([
            'color' => $request->selected_color,
            'size'  => $request->selected_size
        ]);
        return back()->with('success', 'Options updated!');
    }

    public function remove($itemId)
    {
        CartItem::findOrFail($itemId)->delete();
        return redirect()->route('customer.cart')->with('success', 'Item removed!');
    }

    // ================= CHECKOUT =================
    public function checkout()
    {
        $user = auth()->user();
        if (!$user || !$user->customer) {
            return redirect()->route('customer.cart')->with('error', 'Customer not found.');
        }

        $customer = $user->customer;
        $cart = $customer->cart()->first();
        if (!$cart) {
            return redirect()->route('customer.cart')->with('error', 'Your cart is empty.');
        }

        $cartItems = $cart->items()->with('product.shop')->get();
        $paymentMethods = PaymentMethod::all();
        $deliveryMethods = DeliveryMethod::all();

        $loyaltyDiscount = 0;
        $ordersCount = 0;
        $loyaltySetting = null;

        if ($cartItems->count() > 0) {
            $shop = $cartItems->first()->product->shop;
            $loyaltySetting = $shop?->loyalty;

            if ($shop && $loyaltySetting) {
                $ordersCount = Orders::where('customer_id', $customer->customer_id)
                    ->whereHas('items.product', function ($q) use ($shop) {
                        $q->where('shop_id', $shop->shop_id);
                    })
                    ->count();

                if ($ordersCount > 0 && $ordersCount % $loyaltySetting->min_orders == 0) {
                    $loyaltyDiscount = $loyaltySetting->discount_percentage;
                }
            }
        }

        return view('customer.checkout', compact(
            'cartItems',
            'paymentMethods',
            'deliveryMethods',
            'loyaltyDiscount',
            'ordersCount',
            'loyaltySetting'
        ));
    }

    // ================= SUBMIT ORDER =================
    public function submitCheckout(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'phone' => 'required',
            'address' => 'required',
            'payment_method_id' => 'required|exists:payment_methods,payment_method_id',
            'delivery_method_id' => 'required|exists:delivery_methods,delivery_method_id',
            'subtotal' => 'required|numeric',
            'loyalty_discount_percent' => 'required|numeric',
            'loyalty_discount_amount' => 'required|numeric',
            'delivery_cost' => 'required|numeric',
            'final_total' => 'required|numeric',
        ]);

        $customer = auth()->user()->customer;
        $cart = $customer->cart()->first();
        $cartItems = $cart->items()->with('product')->get();

        $shop = $cartItems->first()->product->shop;
        $loyaltySetting = $shop?->loyalty;

        $ordersCount = Orders::where('customer_id', $customer->customer_id)
            ->whereHas('items.product', function ($q) use ($shop) {
                $q->where('shop_id', $shop->shop_id);
            })
            ->count();

        $loyaltyDiscount = 0;
        if ($loyaltySetting && $ordersCount > 0 && $ordersCount % $loyaltySetting->min_orders == 0) {
            $loyaltyDiscount = $loyaltySetting->discount_percentage;
        }

        if ($request->loyalty_discount_percent != $loyaltyDiscount) {
            return back()->with('error', 'Invalid loyalty discount.');
        }

        $order = Orders::create([
            'customer_id' => $customer->customer_id,
            'full_name' => $request->full_name,
            'phone' => $request->phone,
            'shipping_address' => $request->address,
            'total_amount' => $request->final_total,
            'order_status' => 'Pending',
            'payment_method_id' => $request->payment_method_id,
            'delivery_method_id' => $request->delivery_method_id,
            'subtotal' => $request->subtotal,
            'loyalty_discount_percent' => $loyaltyDiscount,
            'loyalty_discount_amount' => $request->loyalty_discount_amount,
            'delivery_cost' => $request->delivery_cost,
        ]);

        foreach ($cartItems as $item) {
            $product = $item->product;
            $unitPrice = $product->is_on_sale ? $product->discount_value : $product->price;

            OrderItem::create([
                'order_id' => $order->order_id,
                'product_id' => $item->product_id,
                'quantity' => $item->quantity,
                'price_at_purchase' => $unitPrice,
                'color' => $item->color,
                'size' => $item->size,
            ]);

            $product->decrement('stock_quantity', $item->quantity);
        }

        $cart->items()->delete();

        return redirect()->route('customer.orders')->with('success', 'Order placed successfully!');
    }
}
