<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\products as Product;
use Illuminate\Http\Request;
use App\Models\Shop;
class SearchController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->query('q');

       
        $products = Product::where('product_name', 'like', "%{$q}%")->get();

      
        $customers = User::where('role', 'customer')
                         ->where('name', 'like', "%{$q}%")
                         ->get();
        $shop_owners = User::where('role', 'shop_owner')
                         ->where('name', 'like', "%{$q}%")
                         ->get();
        $shop=Shop::where('shop_name', 'like', "%{$q}%")->get();
        
        return view('admin.search.results', compact('products','customers','shop_owners','q','shop'));
    }
}
