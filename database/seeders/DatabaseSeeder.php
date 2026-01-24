<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       User::firstOrCreate(
    ['email' => 'test@example.com'], // check this
    ['name' => 'Test User', 'password' => bcrypt('password')] // values to fill if not exists
);


        $this->call(CategorySeeder::class);
       // $this->call(ProductSeeder::class);
       $this->call(UserSeeder::class);
       $this->call( AdminSeeder::class);
       //$this->call(CustomerSeeder::class);
       $this->call( ShopOwnerSeeder::class);
       $this->call(PaymentMethodSeeder::class);
       $this->call(DeliveryMethodSeeder::class);
       $this->call(ShopSeeder::class);
       $this->call(ProductSeeder::class);
       $this->call(TestimonialSeeder::class);
         $this->call(SubCategorySeeder::class);





    }
}
