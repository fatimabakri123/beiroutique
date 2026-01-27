<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
   
    public function send(Request $request)
    {
        $request->validate([
            'chat_id' => 'required|exists:chats,id',
            'message' => 'required|string',
        ]);

        $msg = Message::create([
            'chat_id' => $request->chat_id,
            'sender_id' => Auth::id(),
            'message' => $request->message,
        ]);

        return response()->json($msg);
    }

    // جلب الرسائل
    public function fetch($chatId)
    {
        $messages = Message::where('chat_id', $chatId)
                    ->orderBy('created_at', 'asc')
                    ->with('sender') // للحصول على معلومات المرسل
                    ->get();

        return response()->json($messages);
    }
}
