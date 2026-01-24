<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SaleAppliedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $shop;
    public $product;
    public $percentage;

    public function __construct($shop, $product = null, $percentage = null)
    {
        $this->shop = $shop;
        $this->product = $product;
        $this->percentage = $percentage;
    }

    public function build()
    {
        return $this
            ->subject('🔥 Sale Alert from ' . $this->shop->shop_name)
            ->view('emails.sale_applied');
    }
}
