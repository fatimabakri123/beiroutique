<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WhishlistItem extends Model
{
    
    protected $primaryKey = 'wishlist_item_id';
       protected $table = 'wishlist_items'; 
     protected $fillable = ['wishlist_id','product_id'];

    public function wishlist() { return $this->belongsTo(Whishlist::class); }
    public function product()
{
    return $this->belongsTo(products::class, 'product_id', 'product_id');
}

}
