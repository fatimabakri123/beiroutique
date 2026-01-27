<?php

namespace App\Http\Controllers;

use App\Models\products as Product;
use App\Models\Shop;

class SaleController extends Controller
{    public function index()
    {
        // المنتجات اللي عليها Sale
        $saleProducts = Product::where('is_on_sale', 1)->get();

        // المتاجر اللي عندها منتجات Sale
        $shopsOnSale = Shop::whereHas('products', function ($q) {
            $q->where('is_on_sale', 1);
        })->get();

        return view('sale.index', compact('saleProducts', 'shopsOnSale'));
    }
}
