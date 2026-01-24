<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class paymentMethod extends Model
{
    protected $primaryKey = 'payment_method_id';
     protected $fillable = ['method_name','is_active'];

    public function orders() { return $this->hasMany(orders::class); }
}
