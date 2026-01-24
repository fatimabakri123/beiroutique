<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\paymentMethod;

class PaymentMethodSeeder extends Seeder
{
    public function run(): void
    {
        // Example payment methods
        $methods = [
            ['method_name' => 'Cash on Delivery', 'is_active' => true],
            ['method_name' => 'Credit Card', 'is_active' => true],
            ['method_name' => 'PayPal', 'is_active' => true],
            ['method_name' => 'Bank Transfer', 'is_active' => false],
        ];

        foreach ($methods as $method) {
            // Avoid duplicates
            paymentMethod::firstOrCreate(['method_name' => $method['method_name']], $method);
        }
    }
}
