<?php


namespace App\Exports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CustomersExport implements FromCollection, WithHeadings
{
    protected $shopId;

    public function __construct($shopId = null)
    {
        $this->shopId = $shopId;
    }

    public function collection()
    {
        // Get customers with optional shop filter
        $customers = Customer::with(['user','orders.items.product.shop'])
            ->when($this->shopId, function ($q) {
                $q->whereHas('orders.items', function ($qq) {
                    $qq->whereHas('product', function ($qqq) {
                        $qqq->where('shop_id', $this->shopId);
                    });
                });
            })
            ->get();

        // Map customers to match Blade table
        return $customers->map(function ($c) {
            // Flatten orders/items to get shop names
            $shops = $c->orders
                ->flatMap(fn($order) => $order->items)
                ->pluck('product.shop.shop_name')
                ->filter()
                ->unique()
                ->implode(', ');

            return [
                'ID' => $c->customer_id,
                'Name' => optional($c->user)->name . ' ' . optional($c->user)->last_name,
                'Email' => optional($c->user)->email,
                'Phone' => $c->phone_number,
                'Orders' => $c->orders->count(),
                'Shops' => $shops ?: 'N/A',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'Phone',
            'Orders',
            'Shops',
        ];
    }
}
