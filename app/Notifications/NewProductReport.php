<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewProductReport extends Notification
{
    use Queueable;

    public $report;
    public $product;

    public function __construct($report)
    {
        $this->report = $report;
        $this->product = $report->product; // relation to fetch product
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'product_report',
            'report_id' => $this->report->id,
            'product_id' => $this->product->product_id,
            'product_name' => $this->product->product_name,
           
            'product_image' => $this->product->image_url ? asset('storage/' . $this->product->image_url) : null,
            'order_id' => $this->report->order_id,
            'issue_type' => $this->report->issue_type,
            'description' => $this->report->description,
            'customer_id' => $this->report->customer_id,
            'message' => 'New issue reported for your product',
        ];
    }
}