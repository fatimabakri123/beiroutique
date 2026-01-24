<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subcategory extends Model
{
    protected $primaryKey = 'subcategory_id';

    protected $fillable = [
        'category_id',
        'subcategory_name',
        'description',
        'image'
    ];

    public function category()
    {
        return $this->belongsTo(categories::class, 'category_id');
    }

    public function products()
    {
        return $this->hasMany(products::class, 'subcategory_id','subcategory_id');
    }
}
