<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class SaleAppliedNotification extends Notification
{
    use Queueable;

    private $shopName;
    private $percentage;

    public function __construct($shopName, $percentage)
    {
        $this->shopName = $shopName;
        $this->percentage = $percentage;
    }

    public function via($notifiable)
    {
        // If $notifiable is a Customer model, send only database notification
        if ($notifiable instanceof \App\Models\Customer) {
            return ['database'];
        }

        // Otherwise (like email route), send via mail
        return ['mail'];
    }

    // For database notifications
    public function toDatabase($notifiable)
    {
        return [
            'type' => 'sale',
            'title' => '🔥 Big Sale!',
            'message' => "{$this->shopName} is offering {$this->percentage}% off on ALL products!",
            'url' => route('index'),
        ];
    }

    // For email notifications
 public function toMail($notifiable)
{
    return (new MailMessage)
                ->subject('🔥 Sale Alert from ' . $this->shopName)
                ->view('emails.sale_applied', [
                    
                    'shopName' => $this->shopName,
                    'percentage' => $this->percentage,
                ])
                ->line("Don't miss out on the amazing {$this->percentage}% discount on all products at {$this->shopName}!")
                ->action('Shop Now', url('/'));
}

}
