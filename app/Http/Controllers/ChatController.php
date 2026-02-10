<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Chat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
   public function start($userId)
{
    $authUser = Auth::user();
    $otherUser = User::findOrFail($userId);

    // التأكد من الصلاحيات
    if (!$this->canChat($authUser, $otherUser)) {
        abort(403, 'You are not allowed to chat with this user');
    }

    $chat = Chat::firstOrCreate([
        'user_one_id' => min($authUser->id, $otherUser->id),
        'user_two_id' => max($authUser->id, $otherUser->id),
    ]);

    return view('chat.customer', [
        'chat' => $chat,
        'otherUser' => $otherUser, 
    ]);
}


    private function canChat($userA, $userB)
    {
        if ($userA->role === 'customer' && $userB->role === 'shop_owner') return true;
        if ($userA->role === 'shop_owner' && $userB->role === 'customer') return true;
        if ($userA->role === 'shop_owner' && $userB->role === 'admin') return true;
        if ($userA->role === 'admin' && $userB->role === 'shop_owner') return true;

        return false;
    }
}
