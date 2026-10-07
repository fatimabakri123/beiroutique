<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class LoyaltyUnlockedNotification extends Notification
{
    use Queueable;

    private $percentage;
    private $shopId;

    public function __construct($percentage, $shopId)
    {
        $this->percentage = $percentage;
        $this->shopId = $shopId;
    }

    public function via($notifiable)
    {
        return ['database', 'mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('🎉 Loyalty Reward Unlocked!')
            ->line("Congratulations! You've unlocked a {$this->percentage}% discount on your next order!")
            ->line('This discount will be automatically applied to your next purchase.')
            ->action('Shop Now', url('/shop/' . $this->shopId))
            ->line('Thank you for being a loyal customer!');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'loyalty',
            'title' => '🎉 Loyalty Reward Unlocked!',
            'message' => "You've earned a {$this->percentage}% discount on your next order!",
            'shop_id' => $this->shopId,
            'discount_percentage' => $this->percentage
        ];
    }
}