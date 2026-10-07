<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerLoyalty;
use App\Models\LoyaltySetting;
use App\Models\orders;
use Illuminate\Support\Facades\DB;
use App\Notifications\LoyaltyUnlockedNotification;

class LoyaltyService
{
    public static function updateCustomerLoyalty(Customer $customer, $shopId, $orderAmount)
    {
        $loyaltySetting = LoyaltySetting::where('shop_id', $shopId)->first();
        if (!$loyaltySetting) return null;

        
        $customerLoyalty = CustomerLoyalty::firstOrCreate(
            [
                'customer_id' => $customer->customer_id,
                'shop_id' => $shopId
            ],
            [
                'orders_count' => 0,
                'total_spent' => 0,
                'reward_available' => false,
                'reward_used' => false,
                'lifetime_orders' => 0,
                'lifetime_spent' => 0
            ]
        );

        
        if ($customerLoyalty->orders_count == 0) {
            
            $ordersCount = $customer->orders()
                ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.product_id')
                ->where('products.shop_id', $shopId)
                ->where('orders.customer_id', $customer->customer_id)
                ->distinct('orders.order_id')
                ->count();

            $totalSpent = $customer->orders()
                ->join('order_items', 'orders.order_id', '=', 'order_items.order_id')
                ->join('products', 'order_items.product_id', '=', 'products.product_id')
                ->where('products.shop_id', $shopId)
                ->where('orders.customer_id', $customer->customer_id)
                ->sum(DB::raw('order_items.quantity * order_items.price_at_purchase'));

            $customerLoyalty->update([
                'orders_count' => $ordersCount,
                'total_spent' => $totalSpent,
                'lifetime_orders' => $ordersCount,
                'lifetime_spent' => $totalSpent
            ]);
        }

        
        if ($customerLoyalty->reward_used) {
            $customerLoyalty->update([
                'orders_count' => 0,
                'total_spent' => 0,
                'reward_available' => false,
                'reward_used' => false,
                'last_reset_at' => now()
            ]);
            return $customerLoyalty;
        }

       
        if ($orderAmount > 0) {
            $customerLoyalty->increment('orders_count', 1);
            $customerLoyalty->increment('total_spent', $orderAmount);
            $customerLoyalty->increment('lifetime_orders', 1);
            $customerLoyalty->increment('lifetime_spent', $orderAmount);
        }

             if (!$customerLoyalty->reward_available && 
        $customerLoyalty->orders_count >= $loyaltySetting->min_orders && 
        $customerLoyalty->total_spent >= $loyaltySetting->min_revenue) {
        
        $customerLoyalty->update(['reward_available' => true]);
        
   
        $customer->notify(new LoyaltyUnlockedNotification(
            $loyaltySetting->discount_percentage,
            $shopId
        ));
        
        $customer->notifications()->create([
            'id' => \Illuminate\Support\Str::uuid()->toString(),
            'type' => 'App\Notifications\LoyaltyUnlockedNotification',
            'notifiable_type' => 'App\Models\Customer',
            'notifiable_id' => $customer->customer_id,
            'data' => json_encode([
                'type' => 'loyalty',
                'title' => '🎉 Loyalty Reward Unlocked!',
                'message' => "You've earned a {$loyaltySetting->discount_percentage}% discount on your next order!",
                'shop_id' => $shopId,
                'discount_percentage' => $loyaltySetting->discount_percentage,
                'url' => route('shop.products', $shopId)
            ]),
            'created_at' => now(),
            'updated_at' => now(),
            'read_at' => null
        ]);
        
        \Log::info('Loyalty notification sent to customer: ' . $customer->customer_id);
    
    return $customerLoyalty;
}
    }
    
    public static function getCustomerDiscount(Customer $customer, $shopId)
    {
        $customerLoyalty = CustomerLoyalty::where([
        'customer_id' => $customer->customer_id,  
        'shop_id' => $shopId,
        'reward_available' => true,
        'reward_used' => false
    ])->first();


        if (!$customerLoyalty) return 0;

        $loyaltySetting = LoyaltySetting::where('shop_id', $shopId)->first();
        return $loyaltySetting ? $loyaltySetting->discount_percentage : 0;
    }

    public static function markRewardAsUsed(Customer $customer, $shopId)
    {
        CustomerLoyalty::where([
            'customer_id' => $customer->customer_id,
            'shop_id' => $shopId
        ])->update([
            'reward_used' => true,
            'reward_used_at' => now(),
            'reward_available' => false
        ]);
    }
  

    public static function getCustomerProgress(Customer $customer, $shopId)
    {
        $customerLoyalty = CustomerLoyalty::where([
            'customer_id' => $customer->customer_id,
            'shop_id' => $shopId
        ])->first();
        
        if (!$customerLoyalty) return null;
        
        $loyaltySetting = LoyaltySetting::where('shop_id', $shopId)->first();
        
        return [
            'current_orders' => $customerLoyalty->orders_count,
            'current_spent' => $customerLoyalty->total_spent,
            'min_orders' => $loyaltySetting->min_orders ?? 5,
            'min_revenue' => $loyaltySetting->min_revenue ?? 200,
            'discount_percentage' => $loyaltySetting->discount_percentage ?? 10,
            'reward_available' => $customerLoyalty->reward_available,
            'reward_used' => $customerLoyalty->reward_used
        ];
    }
}