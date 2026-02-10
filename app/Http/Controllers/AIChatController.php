<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class AIChatController extends Controller
{
    // Function to handle FAQ question
    public function faq(Request $request)
    {
        // Validate request
        $request->validate([
            'question' => 'required|string|max:1000',
        ]);

        $question = $request->input('question');

        try {
            // DeepSeek API endpoint
            $apiUrl = 'https://api.deepseek.com/v1/chat/completions'; // Replace if your host is different
            $apiKey = env('DEEPSEEK_API_KEY'); // Store your key in .env

            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $apiKey,
                'Content-Type' => 'application/json',
            ])->post($apiUrl, [
                'model' => 'deepseek-chat', // The model name
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant for website FAQs.',
                    ],
                    [
                        'role' => 'user',
                        'content' => $question,
                    ],
                ],
            ]);

            if ($response->successful()) {
                $answer = $response['choices'][0]['message']['content'] ?? 'No answer available.';
                return response()->json(['answer' => $answer]);
            } else {
                return response()->json(['answer' => 'Failed to get answer.'], 500);
            }

        } catch (\Exception $e) {
            return response()->json(['answer' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
