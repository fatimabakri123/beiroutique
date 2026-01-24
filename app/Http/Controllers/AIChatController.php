<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Models\products as Product;

class AIChatController extends Controller
{
    public function ask(Request $request)
    {
        $question = trim($request->question);

        if (!$question) {
            return response()->json([
                'answer' => 'Please type a question.',
                'products' => []
            ]);
        }

        // 🔍 Search products smartly (multiple matches)
        $products = Product::where('product_name', 'LIKE', "%$question%")
            ->orWhere('description', 'LIKE', "%$question%")
            ->get();

        if ($products->isEmpty()) {
            return response()->json([
                'answer' => 'Sorry, I could not find this product.',
                'products' => []
            ]);
        }

        // 🧠 Build context for AI using all found products
        $context = "";
        foreach ($products as $p) {
            $context .= "
Product Name: {$p->product_name}
Price: {$p->price}
Colors: {$p->color}
Sizes: {$p->size}
Description: {$p->description}
Image: " . ($p->image_url ? url('storage/' . $p->image_url) : 'N/A') . "
---
";
        }

        // 🤖 AI Request
        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . env('DEEPSEEK_API_KEY'),
            'Content-Type' => 'application/json',
        ])->post('https://api.deepseek.com/chat/completions', [
            'model' => 'deepseek-chat',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => "You are an assistant for an online shop. Answer ONLY using the provided product info. Suggest the best product that matches the user's question. Reply in the same language as the user."
                ],
                [
                    'role' => 'user',
                    'content' => "Product Info:\n$context\n\nUser Question:\n$question"
                ],
            ],
        ]);

        $answer = $response->successful()
            ? ($response['choices'][0]['message']['content'] ?? 'AI service unavailable.')
            : 'AI service unavailable.';

        // 🔄 Return AI answer + all matching products
        return response()->json([
            'answer' => $answer,
            'products' => $products->map(fn($p) => [
                'name' => $p->product_name,
                'price' => $p->price,
                'colors' => $p->color,
                'sizes' => $p->size,
                'description' => $p->description,
                'image' => $p->image_url ? url('storage/' . $p->image_url) : null
            ])
        ]);
    }
}
