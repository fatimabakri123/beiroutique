<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Testimonial;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        // Testimonial 1
        Testimonial::create([
            'name' => 'Sarah Khalil',
            'occupation' => 'Fashion Blogger',
            'message' => 'Absolutely love the quality of the products!',
            'image_url' => 'image/FashionDesigner.jpg',
            'is_featured' => true,
        ]);

        // Testimonial 2
        Testimonial::create([
            'name' => 'Ahmad Darwish',
            'occupation' => 'Sales Manager',
            'message' => 'Fast delivery and amazing service!',
            'image_url' => 'image/SalesManager.jpg',
            'is_featured' => true,
        ]);

        // Testimonial 3
        Testimonial::create([
            'name' => 'Jad Habboush',
            'occupation' => 'Designer',
            'message' => 'I always recommend this store to my friends.',
            'image_url' => 'image/designer.jpg',
            'is_featured' => false,
        ]);
    }
}
