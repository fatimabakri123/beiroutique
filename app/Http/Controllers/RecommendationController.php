<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\products as Product;

class RecommendationController extends Controller
{
    public function chat(Request $request)
    {
        $text = strtolower($request->question);

        // جلب history
        $history = $request->session()->get('ai_chat_history', []);

        // حفظ السؤال الجديد
        $history[] = ['question' => $text];

        // NLP بسيط لتحليل السؤال
        preg_match('/(\d+)/', $text, $matches);
        $budget = $matches[1] ?? null;

        // تحليل النوع، الجنس، المناسبة
        $type = null;
        $gender = null;
        $occasion = null;

        if(str_contains($text,'gift')) $type = 'gift';
        if(str_contains($text,'tshirt') || str_contains($text,'chemise')) $type = 'clothes';
        if(str_contains($text,'her') || str_contains($text,'female')) $gender = 'female';
        if(str_contains($text,'his') || str_contains($text,'male')) $gender = 'male';
        if(str_contains($text,'birthday')) $occasion = 'birthday';
        if(str_contains($text,'wedding')) $occasion = 'wedding';

        // بناء query ذكي
        $query = Product::where('stock_quantity','>',0);
        if($budget) $query->where('price','<=',$budget);
       

        $products = $query->inRandomOrder()->limit(5)->get(['product_name','price','image_url']);

        // Fallback AI / DeepSeek
        if($products->isEmpty()){
            // إرسال السؤال + history إلى DeepSeek API أو أي نموذج AI
            // مثال: $products = DeepSeek::recommend($text, $history);
            $products = [
                ['product_name'=>'AI Suggested 1','price'=>20,'image_url'=>'default1.jpg'],
                ['product_name'=>'AI Suggested 2','price'=>35,'image_url'=>'default2.jpg'],
            ];
        }

        // حفظ الرد بالhistory
        $history[] = ['answer'=>$products->toArray()];
        $request->session()->put('ai_chat_history',$history);

        return response()->json($products);
    }
}
