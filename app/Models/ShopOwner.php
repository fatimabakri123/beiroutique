<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable; 

class ShopOwner extends Model
{
     use HasFactory, Notifiable;
    protected $table = 'shop_owners';

    protected $primaryKey = 'owner_id';
    protected $fillable = ['user_id','phone_number'];

    public function user() { return $this->belongsTo(User::class); }
    public function shops() { return $this->hasMany(Shop::class,'owner_id'); }
}
