<?php

namespace App\Services;

use App\Models\products as Product;
use Illuminate\Support\Facades\Schema;


class ProductAIService
{
  public function handle(array $data)
{
    
    $query = Product::query();
    $entities = $data['entities'] ?? [];

    if (!empty($entities['product'])) {
        $query->where('product_name', 'LIKE', '%' . $entities['product'] . '%');
    }

    if (!empty($entities['color']) && Schema::hasColumn('products', 'color')) {
        $query->where('color', $entities['color']);
    }

    if (!empty($entities['size']) && Schema::hasColumn('products', 'size')) {
        $query->where('size', $entities['size']);
    }

    if (!empty($entities['price'])) {
        $query->where('price', '<=', $entities['price']);
    }

    $products = $query->limit(10)->get();

    if ($products->isEmpty()) {
        return response()->json([
            'answer' => 'ما لقيت منتجات بهالمواصفات 😕'
        ]);
    }

    $reply = "لقيتلك هالمنتجات 👇<br>";
    foreach ($products as $p) {
        $reply .= "- {$p->product_name} ({$p->price}$)<br>";
    }

    return response()->json(['answer' => $reply]);
}


}
