<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\products as Product;
use App\Models\categories as Category;
use App\Models\Shop;
use Illuminate\Http\Request;

class AdminProductController extends Controller {
   public function index(Request $request)
{
    $query = Product::query()->with(['shop','category']);

    // Filter by category
    if ($request->category_id) {
        $query->where('category_id', $request->category_id);
    }

    // Filter by shop
    if ($request->shop_id) {
        $query->where('shop_id', $request->shop_id);
    }

    $products = $query->paginate(10)->withQueryString(); // keeps filters in pagination

    $categories = Category::all();
    $shops = Shop::all();

    return view('admin.products.index', compact('products', 'categories', 'shops'));
}

    public function pending(){
        $pending = Product::where('is_on_sale', false)->paginate(20);
        return view('admin.products.pending', compact('pending'));
    }
    public function show(Product $product){
        return view('admin.products.show', compact('product'));
    }
    public function approve(Product $product){
        $product->is_on_sale = true;
        $product->save();
        return redirect()->back()->with('success','Approved');
    }
    public function reject(Product $product){
        $product->delete();
        return redirect()->back()->with('success','Rejected');
    }
    public function destroy(Product $product){
        $product->delete();
        return redirect()->route('admin.products.index')->with('success','Removed');
    }
}
