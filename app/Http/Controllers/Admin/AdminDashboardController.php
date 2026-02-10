<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
       
        $customerCount = Customer::count();
        $shopCount = Shop::count();
        $productCount = products::count();
        $orderCount = orders::count();

        
        $totalRevenue = OrderItem::whereHas('order', function($q) {
                $q->where('order_status', 'delivered');
            })
            ->sum(DB::raw('price_at_purchase * quantity'));

        
        $salesData = [];
        $salesLabels = [];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $nextDate = Carbon::now()->subDays($i - 1);
            
            $dailyRevenue = OrderItem::whereHas('order', function($q) use ($date, $nextDate) {
                    $q->where('order_status', 'delivered')
                      ->whereBetween('created_at', [$date, $nextDate]);
                })
                ->sum(DB::raw('price_at_purchase * quantity'));
            
            $salesLabels[] = $date->format('d M');
            $salesData[] = $dailyRevenue;
        }

        $topProducts = products::with('shop')
            ->select([
                'products.*',
                DB::raw('(SELECT COALESCE(SUM(order_items.quantity), 0) 
                          FROM order_items 
                          INNER JOIN orders ON order_items.order_id = orders.order_id 
                          WHERE order_items.product_id = products.product_id 
                          AND orders.order_status = "delivered") as sold_qty'),
                DB::raw('(SELECT COALESCE(SUM(order_items.price_at_purchase * order_items.quantity), 0) 
                          FROM order_items 
                          INNER JOIN orders ON order_items.order_id = orders.order_id 
                          WHERE order_items.product_id = products.product_id 
                          AND orders.order_status = "delivered") as total_revenue')
            ])
            ->orderByDesc('sold_qty')
            ->limit(5)
            ->get();

       
        $topShops = Shop::select([
                'shops.*',
                DB::raw('(SELECT COUNT(DISTINCT o.order_id) 
                          FROM orders o
                          INNER JOIN order_items oi ON o.order_id = oi.order_id
                          INNER JOIN products p ON oi.product_id = p.product_id
                          WHERE p.shop_id = shops.shop_id 
                          AND o.order_status = "delivered") as total_orders'),
                DB::raw('(SELECT COALESCE(SUM(oi.price_at_purchase * oi.quantity), 0) 
                          FROM order_items oi
                          INNER JOIN orders o ON oi.order_id = o.order_id
                          INNER JOIN products p ON oi.product_id = p.product_id
                          WHERE p.shop_id = shops.shop_id 
                          AND o.order_status = "delivered") as total_revenue'),
                DB::raw('(SELECT COALESCE(SUM(oi.quantity), 0) 
                          FROM order_items oi
                          INNER JOIN orders o ON oi.order_id = o.order_id
                          INNER JOIN products p ON oi.product_id = p.product_id
                          WHERE p.shop_id = shops.shop_id 
                          AND o.order_status = "delivered") as total_items_sold')
            ])
            ->having('total_revenue', '>', 0)
            ->orderByDesc('total_revenue')
            ->limit(5)
            ->get();

   
        $orderStats = orders::select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->pluck('count', 'order_status')
            ->toArray();

        $topCustomers = Customer::select([
                'customers.*',
                DB::raw('COUNT(DISTINCT orders.order_id) as total_orders'),
                DB::raw('COALESCE(SUM(order_items.price_at_purchase * order_items.quantity), 0) as total_spent')
            ])
            ->leftJoin('orders', 'customers.customer_id', '=', 'orders.customer_id')
            ->leftJoin('order_items', 'orders.order_id', '=', 'order_items.order_id')
            ->where('orders.order_status', 'delivered')
            ->groupBy('customers.customer_id')
            ->orderByDesc('total_spent')
            ->limit(5)
            ->get();


        $monthlyData = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();
            
            $monthlyData[$month->format('M Y')] = [
                'revenue' => OrderItem::whereHas('order', function($q) use ($start, $end) {
                        $q->where('order_status', 'delivered')
                          ->whereBetween('created_at', [$start, $end]);
                    })->sum(DB::raw('price_at_purchase * quantity')),
                'orders' => orders::whereBetween('created_at', [$start, $end])->count()
            ];
        }

        return view('admin.dashboard', compact(
            'customerCount',
            'shopCount',
            'productCount',
            'orderCount',
            'totalRevenue',
            'salesLabels',
            'salesData',
            'topProducts',
            'topShops',
            'orderStats',
            'topCustomers',
            'monthlyData'
        ));
    }
}