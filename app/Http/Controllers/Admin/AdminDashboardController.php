<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Models\Shop;
use App\Models\products;
use App\Models\orders;
use App\Models\OrderItem;
use Carbon\Carbon;
use DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // 1️⃣ Counts
        $customerCount = Customer::count();
        $shopCount = Shop::count();
        $productCount = products::count();
        $orderCount = orders::count();

        // 2️⃣ Sales Last 7 Days
       // 2️⃣ Sales per Shop
$salesLabels = [];
$salesData = [];

// Get all shops with their products and order items
$shops = Shop::with(['products.orderItems' => function($q){
    $q->whereHas('order', fn($q2) => $q2->where('order_status','delivered'));
}])->get();

foreach($shops as $shop){
    $totalSales = 0;

    foreach($shop->products as $product){
        foreach($product->orderItems as $item){
            // Use price at purchase * quantity
            $totalSales += $item->price_at_purchase * $item->quantity;
        }
    }

    $salesLabels[] = $shop->shop_name;
    $salesData[] = $totalSales;
}

        // 3️⃣ Top Selling Products (by quantity sold)
        $topProductsList = products::with('shop')
            ->select('products.*', DB::raw('(SELECT SUM(quantity) FROM order_items WHERE order_items.product_id = products.product_id) as sold_qty'))
            ->selectRaw('(SELECT SUM(price_at_purchase) FROM order_items WHERE order_items.product_id = products.product_id) as total_sales')
            ->orderByDesc('sold_qty')
            ->limit(5)
            ->get();

        // 4️⃣ Top Shops by revenue
        $topShopsList = Shop::withCount(['products as orders_count' => function($q){
                $q->join('order_items','products.product_id','=','order_items.product_id');
            }])
            ->with(['products' => function($q){
                $q->join('order_items','products.product_id','=','order_items.product_id')
                  ->select('products.shop_id', DB::raw('SUM(order_items.price_at_purchase) as total_revenue'))
                  ->groupBy('products.shop_id');
            }])
            ->get()
            ->map(function($shop){
                $shop->total_revenue = optional($shop->products->first())->total_revenue ?? 0;
                return $shop;
            })
            ->sortByDesc('total_revenue')
            ->take(5);

        return view('admin.dashboard', compact(
            'customerCount',
            'shopCount',
            'productCount',
            'orderCount',
            'salesLabels',
            'salesData',
            'topProductsList',
            'topShopsList'
        ));
    }
}
