<?php


// app/Notifications/AdminMessage.php
namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class AdminMessage extends Notification
{
    public function __construct(
        public string $title,
        public string $message
    ) {}

    public function via($notifiable)
    {
        return ['database']; // save in DB
    }

    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->title,
            'message' => $this->message,
        ];
    }
}
