<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Customer;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Find the user with role 'customer'
        $user = User::where('role', 'customer')->first();

        if ($user) {
            Customer::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'username'     => 'fatima123',      // choose any username
                    'phone_number' => '123456789',
                    'address'      => 'Beirut, Lebanon',
                ]
            );
        }
    }
}
