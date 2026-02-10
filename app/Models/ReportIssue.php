<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class ReportIssue extends Model
{
      protected $table = 'reports_issue'; 
    protected $fillable = [
        'customer_id',
        'order_id',
        'product_id',
        'issue_type',
        'description',
        'image',
        'status'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function order()
    {
        return $this->belongsTo(orders::class,'order_id');
    }

    public function product()
    {
        return $this->belongsTo(products::class,'product_id','product_id');
    }
}
