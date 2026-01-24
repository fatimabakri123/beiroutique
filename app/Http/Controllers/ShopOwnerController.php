<?php

namespace App\Http\Controllers;

use App\Models\ShopOwner;
use App\Models\Shop;

use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\categories;
use App\Models\orders as Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Notifications\NewProductNotification;
use App\Notifications\SaleAppliedNotification;
use Illuminate\Support\Facades\Notification;
use App\Models\Subcategory;


class ShopOwnerController extends Controller
{
    public function dashboard()
    {
      $user = auth()->user();

    // Get the shop owner linked to the logged-in user
    $shopOwner = ShopOwner::where('user_id', $user->id)->first();

    // Get all shops of this owner
    $shops = $shopOwner ? $shopOwner->shops : collect();
    $shop = $shops->first(); // first shop for dashboard stats

    // Get products for the first shop
    $products = $shop ? $shop->products : collect();

    // Get all order items related to this shop's products
    $shopProductIds = $products->pluck('product_id');
    $orderItems = \App\Models\OrderItem::whereIn('product_id', $shopProductIds)->get();

    // Get orders related to these order items
   

// Get unique order IDs from order items
$orderIds = $orderItems->pluck('order_id')->unique();

// Fetch orders with customers

$orderIds = $orderItems->pluck('order_id')->unique();

$shopProductIds = $products->pluck('product_id');

$orders = \App\Models\orders::with(['customer.user', 'items'])
    ->whereHas('items', function($q) use ($shopProductIds) {
        $q->whereIn('product_id', $shopProductIds);
    })
    ->get()
    ->map(function($order) use ($shopProductIds) {
        $order->customer_name = $order->customer->user->name ?? 'N/A';
        // sum only items belonging to this shop
        $order->total_amount = $order->items
            ->whereIn('product_id', $shopProductIds)
            ->sum(function($item) {
                return $item->quantity * $item->price_at_purchase;
            });
        return $order;
    });

//// Get all categories for sidebar filters
    $categories = categories::all();
    $subcategories = \App\Models\Subcategory::all();


    // ---- START: Statistics ----
    $totalProducts = $products->count();
    $totalOrders = $orders->count();
    $totalRevenue = $orderItems->sum(function($item) {
        return $item->quantity * $item->price_at_purchase;
    });
    $lowStock = $products->where('stock_quantity', '<=', 5)->count();

    // Monthly revenue for charts
    $monthlyRevenue = $shopProductIds->isNotEmpty()
        ? \App\Models\OrderItem::selectRaw('MONTH(created_at) as month, SUM(quantity * price_at_purchase) as revenue')
            ->whereIn('product_id', $shopProductIds)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
        : collect();

    // Top-selling products
    $topProducts = $shopProductIds->isNotEmpty()
        ? \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->whereIn('product_id', $shopProductIds)
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get()
        : collect();
    // ---- END: Statistics ----

    return view('shop_owner.dashboard', compact(
        'user', 'shopOwner', 'shops', 'shop', 'products', 'orders', 'categories', 'subcategories',   
        'totalProducts', 'totalOrders', 'totalRevenue', 'lowStock',
        'monthlyRevenue', 'topProducts'
    ));
}
  public function updateShop(Request $request)
{
    $user = auth()->user();
    $shopOwner = ShopOwner::where('user_id', $user->id)->first();

    // FIXED shop relation
    $shop = $shopOwner->shops()->first();

    // Update fields
    $shop->shop_name = $request->shop_name;
    $shop->description = $request->description;
    $shop->contact_email = $request->contact_email;
    $shop->contact_phone = $request->contact_phone;

    // Handle logo upload
   if ($request->hasFile('logo_url')) {
    // Store the file in storage/app/public/shops
    $path = $request->file('logo_url')->store('shops', 'public');

    // Save the relative path to DB
    $shop->logo_url = $path; // e.g., "shops/logo123.jpg"
}


    $shop->save();

    return response()->json(['success' => true]);
}


public function statistics()
{
    $user = auth()->user();
    $shopOwner = ShopOwner::where('user_id', $user->id)->first();
    $shop = $shopOwner ? $shopOwner->shops->first() : null;

    if (!$shop) {
        return redirect()->back()->with('error', 'No shop found.');
    }

    $products = $shop->products;
    $shopProductIds = $products->pluck('product_id');

    $orderItems = \App\Models\OrderItem::whereIn('product_id', $shopProductIds)->get();

    $orders = $orderItems->pluck('order_id')->unique()->map(function($id){
        return \App\Models\orders::find($id);
    })->filter();

    // Statistics
    $totalProducts = $products->count();
    $totalOrders = $orders->count();
    $totalRevenue = $orderItems->sum(function($item){
        return $item->quantity * $item->price_at_purchase;
    });
    $lowStock = $products->where('stock_quantity', '<=', 5)->count();

    // Monthly revenue
    $monthlyRevenue = $shopProductIds->isNotEmpty()
        ? \App\Models\OrderItem::selectRaw('MONTH(created_at) as month, SUM(quantity * price_at_purchase) as revenue')
            ->whereIn('product_id', $shopProductIds)
            ->groupBy('month')
            ->orderBy('month')
            ->get()
        : collect();

    // Top-selling products
    $topProducts = $shopProductIds->isNotEmpty()
        ? \App\Models\OrderItem::selectRaw('product_id, SUM(quantity) as total_sold')
            ->whereIn('product_id', $shopProductIds)
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get()
        : collect();

    return view('shop_owner.statistics', compact(
        'shop', 'products', 'orders', 
        'totalProducts', 'totalOrders', 'totalRevenue', 'lowStock',
        'monthlyRevenue', 'topProducts'
    ));
}



public function showOrder($orderId)
{
    $user = auth()->user();

    $shopOwner = ShopOwner::where('user_id', $user->id)->first();
    $shop = $shopOwner->shops()->first();

    $order = Order::with(['customer.user', 'items.product','reports.product', 'reports.customer'])
        ->where('order_id', $orderId)
        ->firstOrFail();

    $shopProductIds = $shop->products->pluck('product_id');

    $items = $order->items->whereIn('product_id', $shopProductIds);

    if ($items->isEmpty()) {
        abort(403);
    }

    $total = $items->sum(fn($i) => $i->quantity * $i->price_at_purchase);

    return view('shop_owner.order_details', [
        'order' => $order,
        'items' => $items,
        'total' => $total
    ]);
}

public function updateOrderStatus(Request $request, $orderId)
{
    $request->validate([
        'order_status' => 'required|in:pending,processing,shipped,delivered'
    ]);

    $user = auth()->user();
    $shopOwner = ShopOwner::where('user_id', $user->id)->first();
    $shop = $shopOwner->shops()->first();

    $order = Order::with('items')->where('order_id', $orderId)->firstOrFail();

    // Check that at least one item belongs to this shop
    $shopProductIds = $shop->products->pluck('product_id');
    $hasAccess = $order->items->whereIn('product_id', $shopProductIds)->isNotEmpty();
    if (!$hasAccess) abort(403);

    // Update status
    $order->order_status = $request->order_status;
    $order->save();

    return redirect()->route('shop.orders.show', $order->order_id)
                     ->with('success', 'Order status updated successfully.');
}
}