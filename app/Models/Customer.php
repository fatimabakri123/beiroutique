<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\orders as Order;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use Notifiable;
    protected $guard = 'customer';
    protected $primaryKey = 'customer_id'; 
    protected $fillable = ['user_id','phone_number','address'];

    public function user() { return $this->belongsTo(User::class); }
    public function orders() { return $this->hasMany(Order::class, 'customer_id'); }
    public function cart() { return $this->hasOne(carts::class, 'customer_id'); }
    public function wishlist() { return $this->hasOne(Wishlist::class); }
    public function reviews() { return $this->hasMany(Review::class); }
      // Notifications relationship
    public function notifications()
    {
        return $this->morphMany(\Illuminate\Notifications\DatabaseNotification::class, 'notifiable');
    }

    public function isLoyal($shopId)
{
$loyalty = \App\Models\LoyaltySetting::where('shop_id', $shopId)->first();


if (!$loyalty) return false;


$orders = $this->orders()
->whereHas('items', function($q) use ($shopId) {
$q->where('shop_id', $shopId);
});


$totalOrders = $orders->count();
$totalRevenue = $orders->sum(\DB::raw('order_items.quantity * order_items.price_at_purchase'));


return $totalOrders >= $loyalty->min_orders && $totalRevenue >= $loyalty->min_revenue;

}
public function reports() {
    return $this->hasMany(ReportIssue::class);
}
}