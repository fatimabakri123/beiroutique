<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ShopOwner;

class ShopOwnerSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::where('role', 'shop_owner')->first();

        if ($user) {
            ShopOwner::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'username'     => 'shopowner1', // pick a username
                    'phone_number' => '70012345',
                ]
            );
        }
    }
}
