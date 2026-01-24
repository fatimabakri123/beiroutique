<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Message;

class Conversation extends Model
{
    protected $fillable = [
        'admin_id',
        'shopowner_id',
        // add other fields like 'last_message', 'status', etc. if needed
    ];
public function shop()
    {
        return $this->belongsTo(Shop::class, 'created_by', 'shop_id');
        // Or adjust the foreign key depending on your table structure
    }

    public function users() {
        return $this->belongsToMany(User::class);
    }

    public function messages() {
        return $this->hasMany(Message::class);
    }
}
