<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ProductOnSaleNotification extends Notification
{
    use Queueable;

    public $shop;
    public $product;

    public function __construct($shop, $product)
    {
        $this->shop = $shop;
        $this->product = $product;
    }

    
    public function via($notifiable)
    {
        return ['mail', 'database'];
    }

    // 📧 Email
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🔥 New Sale Available!')
            ->greeting('Hello!')
            ->line("{$this->shop->shop_name} has a new sale 🎉")
            ->line("Product: {$this->product->product_name}")
            ->line("Sale Price: {$this->product->discount_value}$")
            ->action('View Product', url('/sale'))
            ->line('Don’t miss it!');
    }

    // 🔔 Database Notification
    public function toDatabase($notifiable)
    {
        return [
            'shop_name' => $this->shop->shop_name,
            'product_name' => $this->product->product_name,
            'discount' => $this->product->discount_value,
            'shop_id' => $this->shop->shop_id,
            'product_id' => $this->product->product_id,
        ];
    }
}
