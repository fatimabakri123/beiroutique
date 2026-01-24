<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products as Product;
use App\Models\categories as Category;
use App\Models\Shop;

class SearchController extends Controller
{
 public function index(Request $request)
{
    $q = $request->query('q');

    // Search products by:
    // 1. product name
    // 2. category name
    // 3. shop name
    $products = Product::where('product_name', 'like', "%{$q}%")
        ->orWhereHas('category', fn($cat) => $cat->where('category_name', 'like', "%{$q}%"))
        ->orWhereHas('shop', fn($shop) => $shop->where('shop_name', 'like', "%{$q}%"))
        ->get();

    // Optional: also get matching categories and shops for filters
    $categories = Category::where('category_name', 'like', "%{$q}%")->get();
    $shops = Shop::where('shop_name', 'like', "%{$q}%")->get();

    return view('search.result2', compact('products','categories','shops','q'));
}


 public function search(Request $request)
{
    $query = trim($request->q);

    // split keywords
    $keywords = explode(' ', $query);

    $products = Product::where(function ($q) use ($keywords) {
        foreach ($keywords as $word) {
            $q->where('product_name', 'like', "%$word%")
              ->orWhere('description', 'like', "%$word%")
              ->orWhere('sku', 'like', "%$word%");
        }
    })
    ->orWhereHas('category', function ($cat) use ($keywords) {
        foreach ($keywords as $word) {
            $cat->where('category_name', 'like', "%$word%");
        }
    })
    ->orWhereHas('shop', function ($shop) use ($keywords) {
        foreach ($keywords as $word) {
            $shop->where('shop_name', 'like', "%$word%");
        }
    })
    ->get();

    return view('search.result2', compact('products', 'query'));
}

}





