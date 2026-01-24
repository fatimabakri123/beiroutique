<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Shop;
use App\Models\ShopOwner;

class ShopSeeder extends Seeder
{
    public function run(): void
    {
        $owner = ShopOwner::first(); // get the first shop owner

        if ($owner) {
            Shop::firstOrCreate(
                ['shop_name' => 'Tech Haven'], // unique check
                [
                    'owner_id' => $owner->owner_id,
                    'description' => 'Your one-stop shop for electronics and gadgets.',
                    'logo_url' => 'logos/tech_haven.png',
                    'contact_email' => 'techhaven@example.com',
                    'contact_phone' => '70011111',
                    'address' => 'Beirut Downtown',
                    'is_active' => true,
                ]
            );
        }
    }
}
