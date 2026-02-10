<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\ProductImage;

class products extends Model
{
     protected $primaryKey = 'product_id';
      protected $fillable = ['shop_id','category_id','product_name','description','price','stock_quantity','image_url','sku','barcode' , 'is_on_sale', 'discount_value','color','size','subcategory_id'];
       public function shop() { 
        return $this->belongsTo(Shop::class, 'shop_id'); 
    }

    public function category() { 
        return $this->belongsTo(categories::class, 'category_id'); 
    }
    public function subcategory()
{
    return $this->belongsTo(Subcategory::class, 'subcategory_id','');
}




    public function orderItems() { return $this->hasMany(OrderItem::class, 'product_id'); }

    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function wishlistItems() { return $this->hasMany(WishlistItem::class); }
    public function reviews() { return $this->hasMany(review::class, 'product_id'); }
     public function shop_owner()
{
    return $this->hasOneThrough(
        \App\Models\ShopOwner::class, // final model
        \App\Models\Shop::class,      // intermediate model
        'shop_id',                     // Foreign key on shops table
        'owner_id',                    // Foreign key on shop_owners table
        'shop_id',                     // Local key on products table
        'owner_id'                     // Local key on shops table
    );
}

public function images()
{
    return $this->hasMany(ProductImage::class, 'product_id');
}
  public function reports() {
    return $this->hasMany(ReportIssue::class);
}
  public function ownerUser()
{
    return $this->shop->owner->user();
}

}