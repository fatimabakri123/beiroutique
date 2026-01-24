<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Admin;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        // Get the user with role 'admin' (from users table)
        $adminUser = User::where('role', 'admin')->first();

        if ($adminUser) {
            // Only insert what exists in admins table
            Admin::firstOrCreate([
                'user_id' => $adminUser->id,
            ], [
                'username' => 'superadmin',
                'role' => 'super_admin',
            ]);
        }
    }
}

