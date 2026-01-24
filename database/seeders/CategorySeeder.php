<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\categories; // <- import your model

class CategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['category_name' => 'Women', 'description' => 'Women fashion products', 'image' => 'women.jpg'],
            ['category_name' => 'Men', 'description' => 'Men fashion products', 'image' => 'men.jpg'],
            ['category_name' => 'Kids', 'description' => 'Kids fashion products', 'image' => 'kids.jpg'],
            ['category_name' => 'Accessories', 'description' => 'Fashion accessories', 'image' => 'accessories.jpg'],
            ['category_name' => 'Shoes', 'description' => 'All kinds of shoes', 'image' => 'shoes.jpg'],
            ['category_name' => 'Home & Kitchen', 'description' => 'Home and kitchen products', 'image' => 'home.jpg'],
            ['category_name' => 'Beauty', 'description' => 'Beauty and personal care products', 'image' => 'beauty.jpg'],
            ['category_name' => 'Sports', 'description' => 'Sports products and equipment', 'image' => 'sports.jpg'],
            ['category_name' => 'Bags & Luggage', 'description' => 'Bags, luggage, and travel accessories', 'image' => 'bags.jpg'],
            ['category_name' => 'Cell Phone Accessories', 'description' => 'Phone cases, chargers, and accessories', 'image' => 'cellphone.jpg'],
            ['category_name' => 'Stationary', 'description' => 'Stationary and office supplies', 'image' => 'stationary.jpg'],
        ];

        foreach ($categories as $data) {
            categories::updateOrCreate(
                ['category_name' => $data['category_name']], // find by name
                ['description' => $data['description'], 'image' => $data['image']] // update/insert
            );
        }
    }
}
