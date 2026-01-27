<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;



class OrderAIService
{
    public function handle($orderId = null)
    {
        // Make sure the user is logged in
        $user = Auth::user();
        if (!$user) {
            return response()->json([
                'answer' => 'سجّل دخولك لتشوفي طلباتك 🔐'
            ]);
        }

        // Get orders through the relation with customer
        $ordersQuery = $user->customer->orders()->latest();

        // If the user specified an order ID, filter by it
        if ($orderId) {
            $ordersQuery->where('order_id', $orderId);
        }

        $orders = $ordersQuery->get();

        if ($orders->isEmpty()) {
            if ($orderId) {
                return response()->json([
                    'answer' => "ما لقيت طلب بالرقم #$orderId 🛑"
                ]);
            }
            return response()->json([
                'answer' => 'ما عندك طلبات لحد هلّق 🛒'
            ]);
        }

        $reply = '';
        foreach ($orders as $order) {
            $reply .= "Order #{$order->order_id} | Status: {$order->order_status} | Total: {$order->total_amount}$<br>";
        }

        return response()->json(['answer' => $reply]);
    }


    // تابع يشرح حالة الطلب بشكل ذكي
    private function explainStatus(string $status): string
    {
        $status = strtolower($status); // normalize

        return match ($status) {
            'Pending' => 'قيد المعالجة ⏳',
            'Processing' => 'قيد التجهيز 🛠️',
            'shipped' => 'تم الشحن 🚚',
            'Delivered' => 'تم التسليم ✅',
            'cancelled' => 'ملغي ❌',
            default => 'حالة غير معروفة 🤔',
        };
    }
}
