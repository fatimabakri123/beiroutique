<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class whishlist extends Model

{
    protected $table = 'wishlists';
    protected $primaryKey = 'wishlist_id';
    protected $fillable = ['customer_id'];

    public function items()
    {
        return $this->hasMany(WhishlistItem::class, 'wishlist_id', 'wishlist_id');
    }
}