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

    try {
        // Send to Python AI
        $response = Http::attach(
            'image', fopen($image->getRealPath(), 'r'), $image->getClientOriginalName()
        )->post('http://127.0.0.1:8000/search'); // <--- Zid /search iza el Python endpoint hek

        if ($response->failed()) {
            return response()->json(['error' => 'Python Service Down'], 500);
        }

        $data = $response->json();
        
        // Debugging: uncomment the line below to see what Python returns in the browser console
        // return $data;

        $productIds = $data['product_ids'] ?? [];

        // 2. IMPORTANT: If empty, return empty collection, NOT ALL products
        if (empty($productIds)) {
            $products = collect(); 
        } else {
            // Fetch products and maintain AI's ranking order
            $products = products::whereIn('product_id', $productIds)
                ->orderByRaw("FIELD(product_id, " . implode(',', $productIds) . ")")
                ->get();
        }

        // Return the partial view for AJAX or a full view
        if ($request->ajax()) {
            return view('partials.search-results', compact('products'))->render();
        }

        return view('search.result2', compact('products'));

    } catch (\Exception $e) {
        return response()->json(['error' => $e->getMessage()], 500);
    }
}
}

