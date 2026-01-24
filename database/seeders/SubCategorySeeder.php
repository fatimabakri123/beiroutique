<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Subcategory;
use App\Models\categories as Category;

class SubCategorySeeder extends Seeder
{
    public function run()
    {
        $women = Category::where('category_name', 'Women')->first();
        $men = Category::where('category_name', 'Men')->first();
        $kids = Category::where('category_name', 'Kids')->first();
        $accessories = Category::where('category_name', 'Accessories')->first();
        $shoes = Category::where('category_name', 'Shoes')->first();

        $subcategories = [
            // Women
            ['name' => 'Dresses', 'cat' => $women],
            ['name' => 'Tops', 'cat' => $women],
            ['name' => 'Jeans', 'cat' => $women],
            ['name' => 'Skirts', 'cat' => $women],

            // Men
            ['name' => 'Shirts', 'cat' => $men],
            ['name' => 'Trousers', 'cat' => $men],
            ['name' => 'Jackets', 'cat' => $men],

            // Kids
            ['name' => 'Toys', 'cat' => $kids],
            ['name' => 'Clothing', 'cat' => $kids],

            // Accessories
            ['name' => 'Jewelry', 'cat' => $accessories],
            ['name' => 'Belts', 'cat' => $accessories],
            ['name' => 'Hats', 'cat' => $accessories],

            // Shoes
            ['name' => 'Sneakers', 'cat' => $shoes],
            ['name' => 'Heels', 'cat' => $shoes],
            ['name' => 'Boots', 'cat' => $shoes],
        ];

        foreach ($subcategories as $sub) {
            if ($sub['cat']) {
                Subcategory::updateOrCreate(
                    ['subcategory_name' => $sub['name']],
                    ['category_id' => $sub['cat']->category_id]
                );
            }
        }
    }
}
