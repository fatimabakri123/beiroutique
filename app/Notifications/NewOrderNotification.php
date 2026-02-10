<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    public $order;
    public $product;

    public function __construct($order, $product)
    {
        $this->order = $order;
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database']; 
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'new_order',
            'order_id' => $this->order->order_id,
            'product_id' => $this->product->product_id,
            'product_name' => $this->product->product_name,
            'product_image' => $this->product->image_url ? asset('storage/' . $this->product->image_url) : null,
            'message' => 'A new order has been placed for your product.',
        ];
    }
}
