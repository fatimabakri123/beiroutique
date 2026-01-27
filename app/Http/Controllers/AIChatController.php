<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AIClassifierService;
use App\Services\ProductAIService;
use App\Services\OrderAIService;
use App\Services\GeneralAIService;

class AiChatController extends Controller
{
    public function chat(Request $request)
{
    $question = $request->question;

    $data = app(AIClassifierService::class)->classify($question);

    switch ($data['intent']) {
        case 'product_search':
            return app(ProductAIService::class)->handle($data);

        case 'order_status':
             $orderId = $data['order_id'] ?? null;
            return app(OrderAIService::class)->handle();

        default:
            return app(GeneralAIService::class)->handle($question);
    }
}
}