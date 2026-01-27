<?php

namespace App\Services;

class AIClassifierService
{
    public function classify(string $question): array
    {
        $q = strtolower($question);

        $result = [
            'intent' => 'general_chat',
            'entities' => []
        ];

        // -------- Orders --------
        if (str_contains($q, 'order') || str_contains($q, 'طلب')) {
            $result['intent'] = 'order_status';
            return $result;
        }

        // -------- Products --------
        $productWords = ['bag','chemise','shirt','dress','sneaker','قميص','شنطة','bird','crochet'];

        foreach ($productWords as $word) {
            if (str_contains($q, $word)) {
                $result['intent'] = 'product_search';
                $result['entities']['product'] = $word;
            }
        }

        // Colors
        $colors = ['black','white','red','blue','pink','beige','أسود','أبيض'];
        foreach ($colors as $color) {
            if (str_contains($q, $color)) {
                $result['entities']['color'] = $color;
            }
        }
        // داخل AIClassifierService::classify
$orderStatusWords = ['status','track','وين','وصل','shipment','delivery'];
// Detect order number if user wrote e.g., "#22" or "order 22"



foreach ($orderStatusWords as $w) {
    if (str_contains($q, $w)) {
        $result['intent'] = 'order_status';
        if (preg_match('/\b#?(\d+)\b/', $question, $matches)) {
    $result['order_id'] = (int) $matches[1]; // add order_id to the result
}
        return $result;
    }
}



        // Sizes
        if (preg_match('/\b(xs|s|m|l|xl)\b/i', $q, $m)) {
            $result['entities']['size'] = strtoupper($m[1]);
        }

        // Price
        if (preg_match('/(\d+)\s?\$/', $q, $m)) {
            $result['entities']['price'] = $m[1];
        }

        return $result;
    }
}
