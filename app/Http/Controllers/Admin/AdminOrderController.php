<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\orders as Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller {
   public function index(Request $request){
    $shopId = $request->shop_id;
    $status = $request->status;

    $ordersQuery = Order::with([
        'customer.user',   // make sure to eager load user
        'items.product.shop'
    ])->latest();

    // Filter by shop
    if($shopId) {
        $ordersQuery->whereHas('items.product.shop', function($q) use ($shopId) {
            $q->where('shop_id', $shopId);
        });
    }

    // Filter by status
    if($status) {
        $ordersQuery->where('order_status', $status);
    }

    $orders = $ordersQuery->paginate(8)->appends($request->all()); // Keep filters in pagination links

    return view('admin.orders.index', compact('orders'));
}


    public function show(Order $order){
        return view('admin.orders.show', ['order'=>$order->load('items.product','customer')]);
    }
    public function updateStatus(Request $r, Order $order){
        $r->validate(['status'=>'required|string']);
        $order->order_status = $r->status;
        $order->save();
        return redirect()->back()->with('success','Status updated');
    }
    public function destroy(Order $order){
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success','Deleted');
    }
}
