<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();
            $table->string('name');                 // customer name
            $table->string('occupation')->nullable(); // optional city/country
            $table->string('image_url')->nullable();// path to avatar e.g. images/testimonials/user1.jpg
            $table->text('message');                // testimonial text
            $table->boolean('is_featured')->default(false); // show on homepage?
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};