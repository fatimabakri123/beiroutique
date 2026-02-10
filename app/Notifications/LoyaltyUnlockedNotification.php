<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\DatabaseMessage;

class LoyaltyUnlockedNotification extends Notification
{
    use Queueable;

    protected $discount;

    public function __construct($discount)
    {
        $this->discount = $discount;
    }

    
    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'message' => "🎉 You unlocked a {$this->discount}% loyalty discount!",
            'discount' => $this->discount,
            'type' => 'loyalty'
        ];
    }
}
