<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropSubcategoriesTable extends Migration
{
   public function up(): void
{
    // 1️⃣ Drop FK from products table
    Schema::table('products', function (Blueprint $table) {
        $table->dropForeign(['subcategory_id']);
        $table->dropColumn('subcategory_id');
    });

    // 2️⃣ Now drop subcategories table
    Schema::dropIfExists('subcategories');
}

    public function down(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id('subcategory_id');
            $table->unsignedBigInteger('category_id');
            $table->string('subcategory_name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();

            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }
}
