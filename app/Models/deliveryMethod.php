<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class deliveryMethod extends Model
{
    protected $primaryKey = 'delivery_method_id';
    protected $fillable = ['method_name','cost','estimated_time','is_active'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
