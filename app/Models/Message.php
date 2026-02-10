<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $table = 'messages'; // اسم جدول الرسائل

    protected $fillable = [
        'chat_id',
        'sender_id',
        'message',
    ];

    // علاقة مع المستخدم المرسل
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    // علاقة مع المحادثة
    public function chat()
    {
        return $this->belongsTo(Chat::class, 'chat_id');
    }
}
