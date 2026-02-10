<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminShopController extends Controller {
    public function index(){
        $shops = Shop::with('owner')->withCount('products')->paginate(5);
        return view('admin.shops.index', compact('shops'));
    }
  public function show(Shop $shop)
{
    // Eager load owner.user
    $shop->load('owner.user');

    // Paginate products (5 per page)
    $products = $shop->products()->with(['category','subcategory'])->paginate(5);

    return view('admin.shops.show', compact('shop', 'products'));
}


    public function approve(Shop $shop){
        $shop->is_active = true;
        $shop->save();
        return redirect()->back()->with('success','Approved');
    }
    public function destroy(Shop $shop){
        $shop->delete();
        return redirect()->route('admin.shops.index')->with('success','Deleted');
    }
    public function toggleStatus($id)
{
    $item = Shop::findOrFail($id);
    $item->is_active = !$item->is_active; 
    $item->save();

    return back()->with('success', 'Status updated successfully!');
}

}
