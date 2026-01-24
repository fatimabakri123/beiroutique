<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ShopOwner;
use Illuminate\Http\Request;
use App\Models\Shop;
class AdminShopOwnerController extends Controller {
    public function index(){
   $owners = ShopOwner::with('user', 'shops', 'shops.products')
                   ->withCount('shops')
                   ->orderBy('created_at', 'desc')

                  ->paginate(10); 


        return view('admin.shopowners.index', compact('owners'));
    }
public function show($shopownerId)
{
    // Get the shop owner with all their shops and products + order items + orders
    $owner = ShopOwner::with('shops.products.orderItems.order')->findOrFail($shopownerId);

    // Calculate total orders per shop
    foreach ($owner->shops as $shop) {
        $shop->orders_count = $shop->products->sum(function($product) {
            return $product->orderItems->count();
        });
    }

    // Pass owner to the view
    return view('admin.shopowners.show', compact('owner'));
}



    public function destroy($shopownerId){
        $owner = ShopOwner::findOrFail($shopownerId);
        $owner->delete();
        return redirect()->route('admin.shopowners.index')->with('success','Deleted');
    }
    public function toggleStatus($id)
{
    $owner = ShopOwner::findOrFail($id);
    $owner->status = $owner->status === 'active' ? 'suspended' : 'active';
    $owner->save();

    return back()->with('success', 'Shop owner status updated');
}

}
