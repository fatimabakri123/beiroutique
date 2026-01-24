<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\products;

class ProductSearchController extends Controller
{
    public function searchByImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|max:5120',
        ]);

        $image = $request->file('image');

        // Send image to Python AI service
        $response = Http::attach(
            'image', fopen($image->getRealPath(), 'r')
        )->post('http://127.0.0.1:8000/search');

        $productIds = $response->json()['product_ids'] ?? [];

        $products = products::whereIn('product_id', $productIds)->get();

        return view('partials.search-results', compact('products'))->render();
    }
}

