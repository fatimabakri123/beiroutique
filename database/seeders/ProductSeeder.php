<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\products;
use App\Models\Shop;
use App\Models\categories;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $shop = Shop::first();         // get first shop (from ShopSeeder)
        $categories = categories::all(); // get all categories (from CategorySeeder)

        if ($shop && $categories->count() > 0) {
            $products = [
                // Existing ones
                [
                    'product_name'   => 'Wireless Headphones',
                    'description'    => 'High-quality noise-cancelling headphones.',
                    'price'          => 120.99,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/earphone.jpg',
                    'sku'            => 'HD1001',
                    'barcode'        => '1234567890123',
                    'category_id'    => $categories->where('category_name', 'Cell Phone Accessories')->first()?->category_id,
                    'color'          => 'Black, White, Blue',
                ],
                [
                    'product_name'   => 'Running Shoes',
                    'description'    => 'Comfortable sports shoes for men and women.',
                    'price'          => 75.50,
                    'stock_quantity' => 100,
                    'image_url'      => 'image/shoes.jpg',
                    'sku'            => 'RS2002',
                    'barcode'        => '1234567890456',
                    'category_id'    => $categories->where('category_name', 'Shoes')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Leather Handbag',
                    'description'    => 'Elegant handbag with premium leather.',
                    'price'          => 180.00,
                    'stock_quantity' => 30,
                    'image_url'      => 'image/bags.jpg',
                    'sku'            => 'LH3003',
                    'barcode'        => '1234567890789',
                    'category_id'    => $categories->where('category_name', 'Bags & Luggage')->first()?->category_id,
                ],

                // --- Women Category ---
                [
                    'product_name'   => 'Floral Summer Pijama',
                    'description'    => 'Lightweight Pijama perfect for summer outings.',
                    'price'          => 49.99,
                    'stock_quantity' => 40,
                    'image_url'      => 'image/WomenPijama.jpg',
                    'sku'            => 'WD4001',
                    'barcode'        => '2234567890123',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Women Cut Shirt',
                    'description'    => 'Formal cut shirt suitable for office and events.',
                    'price'          => 89.90,
                    'stock_quantity' => 25,
                    'image_url'      => 'image/WomenCut.jpg',
                    'sku'            => 'WB4002',
                    'barcode'        => '2234567890456',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Women Colorful Shirt',
                    'description'    => 'Comfort-fit shirt for everyday wear.',
                    'price'          => 59.00,
                    'stock_quantity' => 60,
                    'image_url'      => 'image/WomenShirt.jpg',
                    'sku'            => 'WJ4003',
                    'barcode'        => '2234567890789',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],

                // --- Men Category ---
                [
                    'product_name'   => 'Men T-Shirt',
                    'description'    => 'Casual cotton T-shirt available in multiple colors.',
                    'price'          => 25.99,
                    'stock_quantity' => 80,
                    'image_url'      => 'image/MenShirt.jpg',
                    'sku'            => 'MT5001',
                    'barcode'        => '3234567890123',
                    'category_id'    => $categories->where('category_name', 'Men')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Men Formal Shirt',
                    'description'    => 'Slim fit shirt perfect for business wear.',
                    'price'          => 39.99,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/MenChemise.jpg',
                    'sku'            => 'MS5002',
                    'barcode'        => '3234567890456',
                    'category_id'    => $categories->where('category_name', 'Men')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Men Hoodie',
                    'description'    => 'Warm winter hoodie with stylish design.',
                    'price'          => 120.00,
                    'stock_quantity' => 20,
                    'image_url'      => 'image/MenHoodie.jpg',
                    'sku'            => 'MJ5003',
                    'barcode'        => '3234567890789',
                    'category_id'    => $categories->where('category_name', 'Men')->first()?->category_id,
                ],

                // --- Kids Category ---
                [
                    'product_name'   => 'Kids Skirt Set',
                    'description'    => 'Soft skirt set with cartoon print.',
                    'price'          => 15.99,
                    'stock_quantity' => 70,
                    'image_url'      => 'image/SkirtKids.jpg',
                    'sku'            => 'KT6001',
                    'barcode'        => '4234567890123',
                    'category_id'    => $categories->where('category_name', 'Kids')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Kids Blue Set',
                    'description'    => 'Comfortable and durable sneakers for kids.',
                    'price'          => 35.00,
                    'stock_quantity' => 40,
                    'image_url'      => 'image/SetKids.jpg',
                    'sku'            => 'KS6002',
                    'barcode'        => '4234567890456',
                    'category_id'    => $categories->where('category_name', 'Kids')->first()?->category_id,
                ],
                [
                    'product_name'   => 'Kids Pijamas',
                    'description'    => 'Purple pijama for kids.',
                    'price'          => 45.00,
                    'stock_quantity' => 30,
                    'image_url'      => 'image/TopKids.jpg',
                    'sku'            => 'KJ6003',
                    'barcode'        => '4234567890789',
                    'category_id'    => $categories->where('category_name', 'Kids')->first()?->category_id,
                ],
                [
                    'product_name'   => 'women dress',
                    'description'    => 'Colorful dress for women.',
                    'price'          => 20.00,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/WomenDress.jpg',
                    'sku'            => 'WT6004',
                    'barcode'        => '4234567890999',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],
                [
                    'product_name'   => 'women makeup',
                    'description'    => 'Makeup kit for women.',
                    'price'          => 20.00,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/Womenmakeup.jpg',
                    'sku'            => 'WT6005',
                    'barcode'        => '4234567890999',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],
                  [
                    'product_name'   => 'women makeup',
                    'description'    => 'Makeup kit for women.',
                    'price'          => 20.00,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/Womenmakeup.jpg',
                    'sku'            => 'WT6005',
                    'barcode'        => '4234567890999',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                  ],
                   [
                    'product_name'   => 'women accessories',
                    'description'    => 'accessories kit for women.',
                    'price'          => 20.00,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/WomenAccessories.jpg',
                    'sku'            => 'WT6006',
                    'barcode'        => '4234567890999',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                ],
                  [
                    'product_name'   => 'women makeup',
                    'description'    => 'Makeup kit for women.',
                    'price'          => 20.00,
                    'stock_quantity' => 50,
                    'image_url'      => 'image/Womenmakeup.jpg',
                    'sku'            => 'WT6005',
                    'barcode'        => '4234567890999',
                    'category_id'    => $categories->where('category_name', 'Women')->first()?->category_id,
                  ],

                 
            ];

            foreach ($products as $product) {
                if ($product['category_id']) {
                    products::firstOrCreate(
                        ['product_name' => $product['product_name']],
                        array_merge($product, ['shop_id' => $shop->shop_id])
                    );
                }
            }
        }
  
         products::where('product_id', 4)->update([
            'color' => json_encode(['red','blue','black']),
            'size'  => json_encode(['S','M','L','XL']),
        ]);
           products::where('product_id', 5)->update([
            'color' => json_encode(['red','blue','black']),
            'size'  => json_encode(['S','M','L','XL']),
        ]);
              products::where('product_id', 6)->update([
                'color' => json_encode(['red','blue','black']),
                'size'  => json_encode(['S','M','L','XL']),
          ]);
 products::where('product_id', 13)->update([
           'subcategory_id' => 1,
        ]);
    }
   
         
    }


