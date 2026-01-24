<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class carts extends Model
{
    protected $fillable = ['customer_id'];

    public function customer() { return $this->belongsTo(Customer::class, 'customer_id'); }
    public function items() { return $this->hasMany(CartItem::class, 'cart_id','cart_id'); }
}
