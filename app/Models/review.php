<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class review extends Model
{
    protected $primaryKey = 'review_id';
     protected $fillable = ['customer_id','product_id','rating','comment','image'];

    public function customer() { return $this->belongsTo(Customer::class, 'customer_id'); }
    public function product() { return $this->belongsTo(products::class, 'product_id'); }
}
