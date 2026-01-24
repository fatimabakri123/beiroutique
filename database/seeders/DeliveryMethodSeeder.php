<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\deliveryMethod;

class DeliveryMethodSeeder extends Seeder
{
    public function run(): void
    {
        // List of delivery methods
        $methods = [
            ['method_name' => 'Standard Shipping', 'cost' => 5.00, 'estimated_time' => '3-5 days', 'is_active' => true],
            ['method_name' => 'Express Shipping', 'cost' => 15.00, 'estimated_time' => '1-2 days', 'is_active' => true],
            ['method_name' => 'Free Pickup', 'cost' => 0.00, 'estimated_time' => 'Same day', 'is_active' => true],
        ];

        // Insert into database if not exists
        foreach ($methods as $method) {
            deliveryMethod::firstOrCreate(
                ['method_name' => $method['method_name']], // prevent duplicates
                $method
            );
        }
    }
}
