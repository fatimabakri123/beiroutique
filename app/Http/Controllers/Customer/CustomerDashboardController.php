<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\orders;
use App\Models\whishlist;
use App\Models\carts;

class CustomerDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $customer = $user->customer; // from relation in User model

        $orders = $customer->orders()->latest()->take(5)->get();
        $wishlist = $customer->wishlist;
        $cart = $customer->cart;
        $recentOrders = orders::where('customer_id', $customer->customer_id)->get();

        return view('customer.dashboard', compact('user', 'customer', 'orders', 'wishlist', 'cart', 'recentOrders'));
    }
}
