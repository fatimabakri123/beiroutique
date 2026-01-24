<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    protected $primaryKey = 'shop_id';
    protected $fillable = ['owner_id','shop_name','description','logo_url','contact_email','contact_phone','address'];

    public function owner() { return $this->belongsTo(ShopOwner::class,'owner_id'); }
    public function products() { return $this->hasMany(products::class,'shop_id','shop_id')
    ; }
   
}
