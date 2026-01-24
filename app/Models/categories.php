<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\products;
use App\Models\Subcategory;

class categories extends Model
{
  protected $primaryKey = 'category_id';
  protected $fillable = ['category_name','description','image'];
  public function products() { return $this->hasMany(products::class, 'category_id'); }
  public function subcategories()
{
    return $this->hasMany(Subcategory::class, 'category_id');
}

}
