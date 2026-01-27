<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\orders;
use App\Models\carts as Cart;
use App\Models\CartItem;
use App\Models\Customer;
use App\Models\whishlist;
use App\Models\review;
use App\Models\Notification;
use App\Models\products as Product;
use App\Models\Shop; 
use App\Models\User;

class CustomerController extends Controller
{
    // Dashboard Home
public function dashboard()
{
     $user = auth()->user();
        $customer = $user->customer;

    // Orders
  
    $orders = orders::where('customer_id', $customer->customer_id)->latest()->get();
    $ordersCount = $orders->count();
    


    // Wishlist
   $wishlist = Whishlist::where('customer_id', $customer->customer_id)
                            ->with('items.product')
                            ->first();
    $wishlistCount = $wishlist ? $wishlist->items->count() : 0;

   $customer = Customer::find(1);
$customerNotifications = Notification::where('notifiable_type', \App\Models\Customer::class)
    ->where('notifiable_id', 1)
    ->get();

$customer = auth()->user()->customer; 
$notifications = $customer ? $customer->notifications : collect();
$recentOrders = orders::where('customer_id', $customer->customer_id)->get();
 // null safe

 $shopOwner = User::where('role', 'shop_owner')->first();

    return view('customer.home', compact('user', 'ordersCount', 'orders', 'wishlistCount', 'notifications','shopOwner'));
}


    // Profile
    public function profile()
    {
        $user = Auth::user();
        $customer = auth()->user()->customer;

$ordersCount = $customer->orders()->count();
$deliveredCount = $customer->orders()->where('order_status', 'delivered')->count();
$pendingCount = $customer->orders()->where('order_status', 'pending')->count();



return view('customer.profile', compact('ordersCount', 'deliveredCount', 'pendingCount'));

        return view('customer.profile', compact('user'));
    }

 public function updateProfile(Request $request)
{
    $user = auth()->user();
    $customer = $user->customer; // get related customer

    // 1️⃣ Validate input
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'phone' => 'nullable|string|max:20',
        'address' => 'nullable|string|max:255',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // 2️⃣ Update user info
    $user->update($request->only(['name', 'email']));

    // 3️⃣ Update customer info if exists
    if ($customer) {
        $customer->phone_number = $request->phone_number;
        $customer->address = $request->address;
        $customer->save();
    }

    // 4️⃣ Handle profile image
    if ($request->hasFile('image')) {
        $imageName = 'user_' . $user->id . '.' . $request->image->extension();
        $request->image->storeAs('public/uploads/profile', $imageName);
        $user->profile_image = 'uploads/profile/' . $imageName;
        $user->save();
    }

    return back()->with('success', 'Profile updated successfully!');
}



    // Orders
  public function orders(Request $request)
{
    $user = Auth::user();
    $customer = $user->customer;

    $query = orders::where('customer_id', $customer->customer_id)
        ->with(['items.product.shop'])
        ->orderBy('created_at', 'desc');
    // Filter by shop if selected
    if ($request->shop_id && $request->shop_id != 'all') {
        $query->whereHas('items.product.shop', function($q) use ($request) {
            $q->where('shop_id', $request->shop_id);
        });
    }

    // Filter by status if selected
    if ($request->status && $request->status != 'all') {
        $query->where('order_status', $request->status);
    }

    $orders = $query->paginate(5)->withQueryString();
    $shops = Shop::all();

    // List of possible statuses
    $statuses = ['pending', 'processing', 'delivered', 'cancelled'];

    return view('customer.orders', compact('orders', 'shops', 'statuses'));
}

    // Cart
public function cart(Request $request)
{
    $user = auth()->user();
    if (!$user) {
        return redirect()->route('login');
    }

    // Get customer
    $customer = Customer::where('user_id', $user->id)->first();
    if (!$customer) {
        return view('customer.cart')->with('cartItems', []);
    }

    // Get the cart
    $cart = Cart::where('customer_id', $customer->customer_id)->first();
    if (!$cart) {
        return view('customer.cart')->with('cartItems', []);
    }

    // Start query for cart items
    $query = CartItem::with('product')
        ->where('cart_id', $cart->cart_id);

    // Filter by Shop if selected
    if ($request->shop_id && $request->shop_id != 'all') {
        $query->whereHas('product', function($q) use ($request) {
            $q->where('shop_id', $request->shop_id);
        });
    }

    // Search by product name if provided
    if ($request->search) {
        $search = $request->search;
        $query->whereHas('product', function($q) use ($search) {
            $q->where('product_name', 'like', "%$search%");
        });
    }

    $cartItems = $query->get();
    $shops = Shop::all();

    return view('customer.cart', compact('cartItems', 'shops'));
}




    // Wishlist
    public function wishlist()
    {
        $wishlist = whishlist::with('items.product')->where('customer_id', Auth::id())->first();
        return view('customer.wishlist', compact('wishlist'));
    }

    // Reviews
   public function reviews()
{
    $customerId = auth()->user()->customer->customer_id;

    $reviews = Review::where('customer_id', $customerId)
                     ->with('product')
                     ->get();

    return view('customer.reviews', compact('reviews'));
}

public function updatePassword(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:6|confirmed',
    ]);

    $user = auth()->user();

    // Check current password
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Current password is incorrect']);
    }

    // Update password
    $user->password = Hash::make($request->new_password);
    $user->save();

    return back()->with('success', 'Password updated successfully');
}
    // Notifications
    //public function notifications()
    //{
    //    $notifications = Notification::where('customer_id', Auth::id())->latest()->get();
    //    return view('customer.notifications', compact('notifications'));
    //}
    public function notifications()
    {
        // Fetch notifications (replace with your logic)
    
    $notifications = auth()->user()
        ->customer
        ->notifications()
        ->latest()
        ->get();

    return view('customer.notifications', compact('notifications'));

    }

}
