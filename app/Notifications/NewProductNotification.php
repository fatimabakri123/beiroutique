<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NewProductNotification extends Notification
{
    use Queueable;

    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

   public function toDatabase($notifiable)
{
    return [
        'type' => 'product',
        'title' => 'New Product Added',
        'message' => 'A new product "' . $this->product->product_name . '" is now available.',
        'product_id' => $this->product->product_id,
        'image' => $this->product->image_url,
        'url' => route('product.show', $this->product->product_id),
    ];
}


}