<?php

namespace App\Services;

use App\Models\products as Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Support\Facades\DB;

class RecommendationService {

    public function forProduct(Product $product) {
        $list = collect();
        
        // 1. نفس الـ Subcategory أولاً (الأكثر صلة)
        if ($product->subcategory_id) {
            $list = $list->merge(
                Product::where('subcategory_id', $product->subcategory_id)
                    ->where('product_id', '!=', $product->product_id)
                    ->inRandomOrder()
                    ->limit(4)
                    ->get()
            );
        }

        // 2. نفس الـ Category ثانياً
        $list = $list->merge(
            Product::where('category_id', $product->category_id)
                ->where('product_id', '!=', $product->product_id)
                ->where(function($query) use ($product) {
                    if ($product->subcategory_id) {
                        $query->where('subcategory_id', '!=', $product->subcategory_id)
                              ->orWhereNull('subcategory_id');
                    }
                })
                ->inRandomOrder()
                ->limit(3)
                ->get()
        );

        // 3. Cross-selling بناءً على بيانات الطلبات السابقة
        $crossSellProducts = $this->getCrossSellProducts($product);
        if ($crossSellProducts->isNotEmpty()) {
            $list = $list->merge($crossSellProducts);
        }

        // 4. منتجات من نفس المحل
        $list = $list->merge(
            Product::where('shop_id', $product->shop_id)
                ->where('product_id', '!=', $product->product_id)
                ->inRandomOrder()
                ->limit(2)
                ->get()
        );

        // 5. منتجات مشابهة في السعر (±20%) - التصحيح هنا
        $priceRangeMin = $product->price * 0.8;
        $priceRangeMax = $product->price * 1.2; // تم التصحيح
        
        $list = $list->merge(
            Product::whereBetween('price', [$priceRangeMin, $priceRangeMax])
                ->where('product_id', '!=', $product->product_id)
                ->where('category_id', $product->category_id)
                ->inRandomOrder()
                ->limit(2)
                ->get()
        );

        
        if ($list->count() < 8) {
            $list = $list->merge(
                Product::where('product_id', '!=', $product->product_id)
                   
                    ->limit(8 - $list->count())
                    ->get()
        );
        }

        return $list->unique('product_id')->take(8);
    }

    /**
     * الحصول على منتجات يتم شراؤها معاً (Cross-selling)
     */
    private function getCrossSellProducts(Product $product) {
        // طريقة 1: من خلال بيانات الطلبات
        $crossSell = DB::table('order_items as oi1')
            ->join('order_items as oi2', 'oi1.order_id', '=', 'oi2.order_id')
            ->join('products as p', 'oi2.product_id', '=', 'p.product_id')
            ->where('oi1.product_id', $product->product_id)
            ->where('oi2.product_id', '!=', $product->product_id)
            ->where('p.category_id', '!=', $product->category_id) // منتجات من فئات مختلفة
            ->select('p.*', DB::raw('COUNT(*) as bought_together'))
            ->groupBy('p.product_id')
            ->orderByDesc('bought_together')
            ->limit(3)
            ->get();

        if ($crossSell->isNotEmpty()) {
            return Product::hydrate($crossSell->toArray());
        }

        // طريقة 2: Cross-selling بناءً على العلاقات بين الفئات
        return $this->getCategoryBasedCrossSell($product);
    }

    /**
     * Cross-selling بناءً على العلاقات بين الفئات
     */
    private function getCategoryBasedCrossSell(Product $product) {
        $category = $product->category;
        
        if (!$category) {
            return collect();
        }
        
        $categoryName = strtolower($category->category_name);
        
        // تعريف العلاقات بين الفئات
        $categoryRelations = [
            'dress' => ['bags', 'shoes', 'jewelry', 'perfume', 'accessories'],
            'dresses' => ['bags', 'shoes', 'jewelry', 'perfume', 'accessories'],
            'shirt' => ['pants', 'belt', 'shoes', 'jacket'],
            'shirts' => ['pants', 'belt', 'shoes', 'jacket'],
            'pants' => ['shirt', 'belt', 'shoes', 'jacket'],
            'jeans' => ['shirt', 'belt', 'shoes', 'jacket'],
            'shoes' => ['socks', 'shoe care', 'insoles', 'shoe polish'],
            'bags' => ['wallet', 'purse', 'accessories', 'organizers'],
            'makeup' => ['skincare', 'brushes', 'perfume', 'mirror'],
            'skincare' => ['makeup', 'tools', 'sunscreen', 'serum'],
            'electronics' => ['accessories', 'cases', 'cables', 'chargers'],
            'phone' => ['case', 'charger', 'headphones', 'screen protector'],
            'laptop' => ['bag', 'mouse', 'keyboard', 'cooling pad'],
        ];

        if (isset($categoryRelations[$categoryName])) {
            $relatedCategories = Category::whereIn('category_name', $categoryRelations[$categoryName])
                ->pluck('category_id');
            
            if ($relatedCategories->isNotEmpty()) {
                return Product::whereIn('category_id', $relatedCategories)
                    ->where('product_id', '!=', $product->product_id)
                    ->inRandomOrder()
                    ->limit(3)
                    ->get();
            }
        }

        // إذا مافي علاقات محددة، نرجع منتجات من فئات مختلفة بنفس المحل
        return Product::where('shop_id', $product->shop_id)
            ->where('category_id', '!=', $product->category_id)
            ->inRandomOrder()
            ->limit(2)
            ->get();
    }

    /**
     * طريقة بديلة: استخدام خوارزمية TF-IDF للكلمات المفتاحية
     */
    public function getSimilarByKeywords(Product $product) {
        // استخراج الكلمات المفتاحية من اسم ووصف المنتج
        $keywords = $this->extractKeywords($product);
        
        if (empty($keywords)) {
            return collect();
        }
        
        $similarProducts = Product::where('product_id', '!=', $product->product_id)
            ->where(function($query) use ($keywords) {
                foreach ($keywords as $keyword) {
                    $query->orWhere('product_name', 'like', "%{$keyword}%")
                          ->orWhere('description', 'like', "%{$keyword}%");
                }
            })
            ->limit(4)
            ->get();
            
        return $similarProducts;
    }

    private function extractKeywords(Product $product) {
        $text = $product->product_name . ' ' . ($product->description ?? '');
        
        // إزالة الكلمات الشائعة
        $stopWords = ['the', 'and', 'for', 'with', 'this', 'that', 'from', 'your', 'our', 'you', 'are'];
        $words = str_word_count(strtolower($text), 1);
        
        $keywords = array_diff($words, $stopWords);
        $keywords = array_slice(array_unique($keywords), 0, 5); // أول 5 كلمات مفتاحية
        
        return $keywords;
    }
}