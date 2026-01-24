<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        // Get all conversations created by this admin
        $conversations = Conversation::where('created_by', auth()->id())
            ->with('creator') // eager load the creator
            ->get();

        return view('admin.chat', compact('conversations'));
    }

    public function show($conversationId)
    {
        $conversation = Conversation::with('messages.sender')->findOrFail($conversationId);
        $messages = $conversation->messages()->latest()->get();

        return view('admin.chat.show', compact('conversation', 'messages'));
    }
}
