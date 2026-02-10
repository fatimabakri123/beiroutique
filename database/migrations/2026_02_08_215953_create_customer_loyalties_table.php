<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
public function up(): void
{
    Schema::create('customer_loyalties', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();
        $table->foreignId('shop_id')
              ->references('shop_id')
              ->on('shops')
              ->cascadeOnDelete();
        
        // Progress tracking (for the current cycle)
        $table->integer('orders_count')->default(0);
        $table->decimal('total_spent', 10, 2)->default(0);
        
        // Reward tracking
        $table->boolean('reward_available')->default(false);
        $table->boolean('reward_used')->default(false);
        $table->timestamp('reward_used_at')->nullable();
        $table->timestamp('last_reset_at')->nullable();
        
        // Statistics (for display only)
        $table->integer('lifetime_orders')->default(0);
        $table->decimal('lifetime_spent', 10, 2)->default(0);
        
        $table->timestamps();
        $table->unique(['user_id', 'shop_id']);
    });
}

    public function down(): void
    {
        Schema::dropIfExists('customer_loyalties');
    }
};