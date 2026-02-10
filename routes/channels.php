<?php

use Illuminate\Support\Facades\Broadcast;
use App\Models\Chat;

// Authorization لكل قناة private
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $chat = Chat::find($conversationId);

    if (!$chat) return false;

    return $user->id === $chat->user_one_id
        || $user->id === $chat->user_two_id;
});
