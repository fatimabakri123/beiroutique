<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Super Admin User
        User::firstOrCreate(
             ['email' => 'admin@beiroutique.com'],
            [
            'name' => 'Super Admin',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Shop Owner User
        User::firstOrCreate(
             ['email' => 'owner@beiroutique.com'],
            [
            'name' => 'Shop Owner',
            'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'shop_owner',
        ]);

        // Customer User
        User::firstOrCreate(
            ['email' => 'customer@beiroutique.com'],
            [
            'name' => 'Fatima Customer',
           'password' => \Illuminate\Support\Facades\Hash::make('password123'),
            'role' => 'customer',
        ]);
    }
}
