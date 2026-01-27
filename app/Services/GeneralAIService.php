<?php

namespace App\Services;

class GeneralAIService
{
    public function handle(string $question)
    {
        return response()->json([
            'answer' => 'سؤالك عام 🤖، AI رح يتطور قريبًا'
        ]);
    }
}


