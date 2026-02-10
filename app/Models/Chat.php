<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Chat extends Model
{
    protected $fillable = ['user_one_id','user_two_id'];

    // علاقة الرسائل
    public function messages() {
        return $this->hasMany(Message::class, 'conversation_id');
    }

    
}
