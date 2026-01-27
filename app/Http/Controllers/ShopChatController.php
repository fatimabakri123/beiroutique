<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use Illuminate\Support\Facades\Auth;

class ShopChatController extends Controller
{
    // List all chats for this shop owner
    public function index()
    {
        $shopId = Auth::id();
        $chats = Chat::where('user_one_id', $shopId)
                     ->orWhere('user_two_id', $shopId)
                     ->with('messages') // eager load messages
                     ->get();

        return view('shop.chats', compact('chats'));
    }

    // Show single chat
    public function show(Chat $chat)
    {
        $shopId = Auth::id();

        // Only allow access if shop owner is part of chat
        if ($chat->user_one_id != $shopId && $chat->user_two_id != $shopId) {
            abort(403);
        }

        return view('shop.chat', compact('chat'));
    }
}
