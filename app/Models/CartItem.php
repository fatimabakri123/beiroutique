<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $primaryKey = 'cart_item_id';
    protected $fillable = ['cart_id','product_id','quantity','color','size'];

    public function cart() { return $this->belongsTo(carts::class); }
    public function product() { return $this->belongsTo(products::class, 'product_id'); }
}
