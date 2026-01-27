<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\products as Product;
use App\Models\categories as Category;
use App\Models\Shop;

class SearchController extends Controller
{
    public function search(Request $request)
{
    $query = trim($request->q);
    $products = collect();

    // ✅ IMAGE SEARCH ONLY
    if ($request->hasFile('image')) {

        try {
            $response = Http::timeout(120)
                ->attach(
                    'image',
                    fopen($request->file('image')->getRealPath(), 'r'),
                    $request->file('image')->getClientOriginalName()
                )
                ->post('http://localhost:5050/search/image');

            if ($response->successful()) {
                $productIds = $response->json()['product_ids'] ?? [];

                if (!empty($productIds)) {
                    $products = Product::whereIn('product_id', $productIds)
                        ->orderByRaw("FIELD(product_id," . implode(',', $productIds) . ")")
                        ->get();
                } else {
                    // ❌ لا نتائج مشابهة
                    $products = collect();
                }
            }

        } catch (\Exception $e) {
            \Log::error($e->getMessage());
            $products = collect();
        }


        
        return view('search.result2', compact('products'));
    }

    // ✅ TEXT SEARCH ONLY
    if (!empty($query)) {
        $keywords = explode(' ', $query);

        $products = Product::where(function ($q) use ($keywords) {
            foreach ($keywords as $word) {
                $q->where('product_name', 'like', "%$word%")
                  ->orWhere('description', 'like', "%$word%");
            }
        })->get();
    }

    return view('search.result2', compact('products'));
}

}