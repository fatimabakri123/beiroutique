<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerLoyalty extends Model
{
    protected $fillable = [
        'customer_id',  // CHANGED: user_id → customer_id
        'shop_id',
        'orders_count',
        'total_spent',
        'reward_available',
        'reward_used',
        'reward_used_at',
        'last_reset_at',
        'lifetime_orders',
        'lifetime_spent'
    ];

    // CHANGED: belongsTo Customer, not User
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}