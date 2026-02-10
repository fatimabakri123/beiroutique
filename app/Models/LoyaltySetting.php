<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoyaltySetting extends Model
{
    protected $table = 'loyalty_settings'; // optional if you follow Laravel naming conventions
    protected $fillable = [
        'shop_id',
        'min_orders',
        'min_revenue',
        'discount_percentage',
    ];

    // Relationship to Shop
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }
}