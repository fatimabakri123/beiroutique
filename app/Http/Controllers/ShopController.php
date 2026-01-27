<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\products;
use App\Models\Shop;
use App\Models\LoyaltySetting;
use Auth;
use Carbon\Carbon;

class ShopController extends Controller
{
    
    public function updateShop(Request $request)
    {
        $shopOwner = Auth::user()->shopOwner;
        $shop = Shop::where('owner_id', $shopOwner->owner_id)->first();

        if (!$shop) {
            return response()->json(['success' => false, 'message' => 'Shop not found.']);
        }

        $shop->shop_name = $request->shop_name;
        $shop->description = $request->description;
        $shop->contact_email = $request->contact_email;
        $shop->contact_phone = $request->contact_phone;

        // If logo uploaded
        if ($request->hasFile('logo_url')) {
            $file = $request->file('logo_url');
            $path = $file->store('logos', 'public');
            $shop->logo_url = 'storage/' . $path;
        }

        $shop->save();

        return response()->json([
            'success' => true,
            'shop' => $shop
        ]);
    }

    
   public function applySale(Request $request)
{
    $user = auth()->user();

    // Get the shop owner (your table uses owner_id, NOT user_id)
    // Correct: use the relation from logged-in user
$shopOwner = $user->shopOwner;

if (!$shopOwner) {
    return response()->json(['success' => false, 'message' => 'Shop owner not found.'], 403);
}

    if (!$shopOwner) {
        return response()->json(['success' => false, 'message' => 'Shop owner not found.'], 403);
    }

    $shop = \App\Models\Shop::where('owner_id', $shopOwner->owner_id)->first();

    if (!$shop) {
        return response()->json(['success' => false, 'message' => 'Shop not found.'], 404);
    }

    $validated = $request->validate([
        'product_id' => 'required|integer',
        'discount_value' => 'required|numeric|min:0.01'
    ]);

   $product = \App\Models\products::where('shop_id', $shop->shop_id)
            ->where('product_id', $validated['product_id'])
            ->first();


    if (!$product) {
        return response()->json(['success' => false, 'message' => 'Product not found.'], 404);
    }

    if ($validated['discount_value'] >= $product->price) {
        return response()->json(['success' => false, 'message' => 'Discount must be lower than price.'], 422);
    }

    $product->update([
        'is_on_sale' => true,
        'discount_value' => $validated['discount_value']
    ]);

    return response()->json(['success' => true, 'message' => 'Product successfully put on sale!']);
}

public function toggleSale(Request $request)
{
    $user = auth()->user();

    // 1) User → ShopOwner
    $shopOwner = $user->shopOwner;

    if (!$shopOwner) {
        return response()->json([
            'success' => false,
            'message' => 'You are not registered as a shop owner.'
        ], 403);
    }

    // 2) ShopOwner → Shop
    $shop = Shop::where('owner_id', $shopOwner->owner_id)->first();

    if (!$shop) {
        return response()->json([
            'success' => false,
            'message' => 'Shop not found for this owner.'
        ], 404);
    }

    // 3) Find product that belongs to THIS shop
    $product = products::where('product_id', $request->product_id)
        ->where('shop_id', $shop->shop_id)
        ->first();

    if (!$product) {
        return response()->json([
            'success' => false,
            'message' => 'Product does not belong to your shop.'
        ], 404);
    }

    // 4) Toggle sale
    if ($request->is_on_sale) {
        if (!$product->discount_value) {
            return response()->json([
                'success' => false,
                'message' => 'Set a sale price first.'
            ]);
        }

        $product->is_on_sale = 1;
    } else {
        $product->is_on_sale = 0;
        $product->discount_value = null;
    }

    $product->save();

    return response()->json([
        'success' => true,
        'message' => $request->is_on_sale ? 'Sale activated' : 'Sale removed'
    ]);
}
public function products(Shop $shop)
{
    $products = $shop->products()->paginate(12); // ✅ paginate

    return view('shop.products', compact('shop', 'products'));
}



public function stats()
{
    $shop = auth()->user()->shopOwner->shops->first();


$today = Carbon::today();

// Today's Revenue
$todayRevenue = DB::table('orders')
    ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
    ->join('products', 'order_items.product_id', '=', 'products.product_id')
    ->where('products.shop_id', $shop->shop_id)
    ->whereDate('orders.created_at', today())
    ->sum(DB::raw('order_items.quantity * order_items.price_at_purchase'));

// Orders Today
$todayOrders = DB::table('orders')
    ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
    ->join('products', 'order_items.product_id', '=', 'products.product_id')
    ->where('products.shop_id', $shop->shop_id)
    ->whereDate('orders.created_at', today())
    ->distinct()
    ->count('orders.order_id');

// Pending Orders
$pendingOrders = DB::table('orders')
    ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
    ->join('products', 'order_items.product_id', '=', 'products.product_id')
    ->where('products.shop_id', $shop->shop_id)
    ->where('orders.order_status', 'pending')
    ->distinct()
    ->count('orders.order_id');

    $totalProducts = $shop->products()->count();

    $totalOrders = DB::table('orders')
        ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.product_id')
        ->where('products.shop_id', $shop->shop_id)
        ->distinct()
        ->count('orders.order_id');

    $totalRevenue = DB::table('orders')
        ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.product_id')
        ->where('products.shop_id', $shop->shop_id)
        ->sum(DB::raw('order_items.quantity * order_items.price_at_purchase'));

    $lowStock = $shop->products()->where('stock_quantity', '<=', 5)->count();

    // Monthly Revenue
   $monthly = DB::table('orders')
    ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
    ->join('products', 'order_items.product_id', '=', 'products.product_id')
    ->where('products.shop_id', $shop->shop_id)
    ->selectRaw("
        DATE_FORMAT(orders.created_at, '%Y-%m') as month_key,
        DATE_FORMAT(orders.created_at, '%b %Y') as month_label,
        SUM(order_items.quantity * order_items.price_at_purchase) as revenue
    ")
    ->groupBy('month_key', 'month_label')
    ->orderBy('month_key')
    ->get();

    // Top products
$topProducts = DB::table('order_items')
->join('products', 'order_items.product_id', '=', 'products.product_id')
->select(
'products.product_name',
DB::raw('SUM(order_items.quantity) as total_sold')
)
->groupBy('products.product_id', 'products.product_name')
->orderByDesc('total_sold')
->limit(5)
->get();


$topProductLabels = $topProducts->pluck('product_name')->toArray();
$topProductData = $topProducts->pluck('total_sold')->toArray();
    // Last 7 days
    $daily = DB::table('orders')
        ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
        ->join('products', 'order_items.product_id', '=', 'products.product_id')
        ->where('products.shop_id', $shop->shop_id)
        ->where('orders.created_at', '>=', now()->subDays(7))
        ->selectRaw("
            DATE(orders.created_at) as day,
            COUNT(DISTINCT orders.order_id) as orders,
            SUM(order_items.quantity * order_items.price_at_purchase) as revenue
        ")
        ->groupBy('day')
        ->orderBy('day')
        ->get();

        $products = $shop->products; // get all products for the low-stock table

        // Customer distribution by city


// Get all orders for this shop
$orders = DB::table('orders')
    ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
    ->join('products', 'order_items.product_id', '=', 'products.product_id')
    ->where('products.shop_id', $shop->shop_id)
    ->select('orders.shipping_address')
    ->distinct()
    ->get();

/// Extract cities safely and remove empty/unknown
$cities = $orders->map(function($order) {
    if (empty($order->shipping_address)) return null; // skip
    preg_match('/City:\s*(.+?)(\n|$)/', $order->shipping_address, $matches);
    return $matches[1] ?? null; // null if city not found
})->filter(); // remove nulls

// Count customers per city
$cityCounts = $cities->countBy();

// Convert to arrays for Chart.js
$cityLabels = $cityCounts->keys()->all();
$cityData   = $cityCounts->values()->all();



    return view('shop_owner.statistics', [
        'shop' => $shop,
        'totalProducts' => $totalProducts,
        'totalOrders' => $totalOrders,
        'totalRevenue' => $totalRevenue,
        'lowStock' => $lowStock,

'monthlyLabels' => $monthly->pluck('month_label'),
'monthlyRevenue' => $monthly->pluck('revenue'),

'topProductLabels' => $topProductLabels,
'topProductData' => $topProductData,

        'dailyLabels' => $daily->pluck('day')->values(),
        'dailyOrders' => $daily->pluck('orders')->values(),
        'dailyRevenue' => $daily->pluck('revenue')->values(),
        'products' => $products,
     'cityLabels' => $cityLabels,
'cityData' => $cityData,
'todayRevenue' => $todayRevenue,
'todayOrders' => $todayOrders,
'pendingOrders' => $pendingOrders,
    ]);
}

public function editProfile()
{
    $shopOwner = auth()->user()->shopOwner;

    if (!$shopOwner || $shopOwner->shops->isEmpty()) {
        return redirect()->route('shop.dashboard')
            ->with('error', 'No shop found for your account.');
    }

    $shop = $shopOwner->shops->first();

    return view('shop_owner.edit-profile', compact('shop'));
}

public function updateProfile(Request $request)
{
    $shop = auth()->user()->shopOwner->shops->first();

    $request->validate([
        'shop_name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'contact_phone' => 'nullable|string|max:20',
        'contact_email' => 'required|email|max:255',
        'address' => 'nullable|string|max:500',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $data = $request->only(['shop_name','description','contact_phone','contact_email','address']);

    // Handle logo upload
    if ($request->hasFile('logo')) {
        $path = $request->file('logo')->store('shop_logos', 'public');
        $data['logo_url'] = $path;
    }

    $shop->update($data);

     return redirect()
        ->back()
        ->with('success', 'Profile updated successfully!');
}

// Show edit product page
public function editProduct(products $product)
{
    $shop = auth()->user()->shopOwner->shops->first();

    // Make sure the product belongs to this shop
    if ($product->shop_id !== $shop->shop_id) {
        abort(403, 'Unauthorized');
    }

    // Use your new blade name: stock.blade.php
    return view('shop_owner.stock', compact('product'));
}
// Update stock
public function updateProductStock(Request $request, products $product)
{
    $shop = auth()->user()->shopOwner->shops->first();

    // Check product belongs to this shop
    if ($product->shop_id !== $shop->shop_id) {
        abort(403, 'Unauthorized');
    }

    $request->validate([
        'stock_quantity' => 'required|integer|min:0'
    ]);

    $product->update([
        'stock_quantity' => $request->stock_quantity
    ]);
return redirect()->route('shop_owner.statistics')->with('success', 'Stock updated!');}



public function updateLoyalty(Request $request)
{
$shop = auth()->user()->shopOwner->shops->first();

$loyalty = LoyaltySetting::updateOrCreate(
['shop_id' => $shop->shop_id],
[
'min_orders' => $request->min_orders ?? 5,
'min_revenue' => $request->min_revenue ?? 200,
'discount_percentage' => $request->discount_percentage ?? 10,
]
);


return response()->json([
'success' => true,
'message' => 'Loyalty settings updated successfully'
]);
}

public function dashboard()
{
$shop = auth()->user()->shopOwner->shops->first();


// Fetch loyalty settings or create default if none exists
$loyalty = $shop->loyalty ?? new LoyaltySetting([
    'min_orders' => 5,
    'min_revenue' => 200,
    'discount_percentage' => 10
]);

return view('shop_owner.dashboard', compact('shop', 'loyalty'));
}
}