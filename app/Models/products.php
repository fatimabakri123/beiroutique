<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

  public function reports() {
    return $this->hasMany(ReportIssue::class);
}


    public function orderItems() { return $this->hasMany(OrderItem::class, 'product_id'); }

    public function cartItems() { return $this->hasMany(CartItem::class); }
    public function wishlistItems() { return $this->hasMany(WishlistItem::class); }
    public function reviews() { return $this->hasMany(review::class, 'product_id'); }
     
}
