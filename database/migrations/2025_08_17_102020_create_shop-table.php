<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id('shop_id');
            $table->unsignedBigInteger('owner_id');
            $table->string('shop_name')->unique();
            $table->text('description')->nullable();
            $table->string('logo_url')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('contact_phone')->nullable();
            $table->string('address')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('creation_date')->useCurrent();
            $table->timestamps();

            $table->foreign('owner_id')->references('owner_id')->on('shop_owners')->onDelete('cascade');
        });
    }

    public function down(): void {
        Schema::dropIfExists('shops');
    }
};
