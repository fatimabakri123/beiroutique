<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class orders extends Model
{
    protected $primaryKey = 'order_id';
     protected $fillable = ['customer_id','total_amount','order_status','payment_method_id','delivery_method_id','shipping_address','size','color','comment','full_name','phone'];

    public function customer() { return $this->belongsTo(Customer::class, 'customer_id'); }
    public function items() { return $this->hasMany(OrderItem::class, 'order_id'); }
    public function paymentMethod() { return $this->belongsTo(PaymentMethod::class, 'payment_method_id'); }
    public function deliveryMethod() { return $this->belongsTo(DeliveryMethod::class, 'delivery_method_id'); }
    public function reports() {
    return $this->hasMany(ReportIssue::class,'order_id','order_id');
}

}
