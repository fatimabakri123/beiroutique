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
    // Take only the first image if multiple exist
    $firstImage = null;

    if ($this->product->images && $this->product->images->count() > 0) {
        $firstImage = $this->product->images->first()->image_path;
    }

    // Fallback to single image_url
    if (!$firstImage && !empty($this->product->image_url)) {
        $firstImage = $this->product->image_url;
    }

    return [
        'type' => 'product',
        'title' => 'New Product Added',
        'message' => 'A new product "' . $this->product->product_name . '" is now available.',
        'product_id' => $this->product->product_id,
        'image' => $firstImage, // single image
        'url' => route('product.show', $this->product->product_id),
    ];
}




}