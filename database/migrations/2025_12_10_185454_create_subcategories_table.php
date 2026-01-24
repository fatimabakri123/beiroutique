<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('subcategories', function (Blueprint $table) {
            $table->id('subcategory_id');
            $table->unsignedBigInteger('category_id');   // FK
            $table->string('subcategory_name')->unique();
            $table->text('description')->nullable();
            $table->string('image')->nullable();         // optional image
            $table->timestamps();

            // Foreign key
            $table->foreign('category_id')
                  ->references('category_id')
                  ->on('categories')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('subcategories');
    }
};
