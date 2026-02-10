<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\orders as Order;

class OrderStatusChanged extends Notification
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail', 'database']; // Email + DB notification
    }

   public function toMail($notifiable)
{
    $name = $notifiable->name ?? 'Customer';

    return (new MailMessage)
        ->subject("Your Order #{$this->order->order_id} Status Updated")
        ->greeting("Hello {$name},")
        ->line("The status of your order #{$this->order->order_id} has been updated to:")
        ->line("**{$this->order->order_status}**")
        ->action('View Your Order', url(route('customer.orders', $this->order->order_id)))
        ->line('Thank you for shopping with us!');
}

    public function toDatabase($notifiable)
    {
        return [
            'order_id' => $this->order->order_id,
            'status' => $this->order->order_status,
            'message' => "Your order #{$this->order->order_id} status has been updated to {$this->order->order_status}"
        ];
    }
}
