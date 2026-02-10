<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\products as Product;
use App\Models\Subcategory;
use App\Models\categories as Category;
use App\Models\Shop;

class SearchController extends Controller
{
    /* =============================
        MAIN SEARCH ENTRY
    ============================= */
    public function search(Request $request)
    {
       $query = trim(preg_replace('/\s+/', ' ', $request->q));

        $subcategoryId = $request->subcategory_id ?? null;
        $shopId        = $request->shop_id ?? null;

        $products = collect();

        /* =============================
           IMAGE SEARCH (FLASK AI)
        ============================= */
        if ($request->hasFile('image')) {
            return $this->imageSearch($request, $subcategoryId, $shopId);
        }

        /* =============================
           TEXT SEARCH
        ============================= */
        if (!empty($query)) {
            $products = $this->textSearch($query, $subcategoryId, $shopId);
        }

        return view('search.result2', compact('products'));
    }

    /* =============================
        IMAGE SEARCH
    ============================= */
    private function imageSearch($request, $subcategoryId, $shopId)
    {
        try {
            $response = Http::timeout(120)
                ->attach(
                    'image',
                    fopen($request->file('image')->getRealPath(), 'r'),
                    $request->file('image')->getClientOriginalName()
                )
                ->post('http://127.0.0.1:5050/search/image');

            if ($response->successful()) {
                $productIds = $response->json()['product_ids'] ?? [];

                if (!empty($productIds)) {

                    $query = Product::whereIn('product_id', $productIds);

                    // filter shop
                    if ($shopId) {
                        $query->where('shop_id', $shopId);
                    }

                    // auto detect most common subcategory
                    if (!$subcategoryId) {
                        $subcategoryId = Product::whereIn('product_id', $productIds)
                            ->select('subcategory_id')
                            ->groupBy('subcategory_id')
                            ->orderByRaw('COUNT(*) DESC')
                            ->pluck('subcategory_id')
                            ->first();
                    }

                    if ($subcategoryId) {
                        $query->where('subcategory_id', $subcategoryId);
                    }

                    $products = $query
                        ->orderByRaw("FIELD(product_id," . implode(',', $productIds) . ")")
                        ->get();

                    return view('search.result2', compact('products'));
                }
            }
        } catch (\Exception $e) {
            \Log::error('Flask API failed: ' . $e->getMessage());
        }

        return view('search.result2', ['products' => collect()]);
    }

    /* =============================
        TEXT SEARCH
    ============================= */
   private function textSearch($query, $subcategoryId, $shopId)
{
    // detect shop
    $shop = Shop::whereRaw(
        "REPLACE(LOWER(shop_name),' ','') LIKE ?",
        ['%' . str_replace(' ', '', strtolower($query)) . '%']
    )->first();

    if ($shop) {
        return Product::where('shop_id', $shop->shop_id)->get();
    }

    // detect subcategory
    $subcategory = Subcategory::where('subcategory_name', 'like', "%$query%")->first();
    if ($subcategory) {
        return Product::where('subcategory_id', $subcategory->subcategory_id)->get();
    }

    // detect category
    $category = Category::where('category_name', 'like', "%$query%")->first();
    if ($category) {
        return Product::where('category_id', $category->category_id)->get();
    }

    // fallback: keyword search
    $keywords = explode(' ', $query);

    return Product::where(function ($q) use ($keywords) {
        foreach ($keywords as $word) {
            $q->orWhere('product_name', 'like', "%$word%")
              ->orWhere('description', 'like', "%$word%");
        }
    })->get();
}

}
