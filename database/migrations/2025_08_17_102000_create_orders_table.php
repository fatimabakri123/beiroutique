<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('order_id'); // PK

            // Foreign keys
            $table->unsignedBigInteger('customer_id');
            $table->unsignedBigInteger('payment_method_id');
            $table->unsignedBigInteger('delivery_method_id');

            // Order details
            $table->dateTime('order_date')->useCurrent();
            $table->decimal('total_amount', 10, 2)->default(0);
            $table->enum('order_status', [
                'Pending',
                'Processing',
                'Shipped',
                'Delivered',
                'Cancelled'
            ])->default('Pending');
            $table->string('shipping_address');

            $table->timestamps();

            // Foreign key constraints
            $table->foreign('customer_id')
                ->references('customer_id')
                ->on('customers')
                ->onDelete('cascade');

            /*$table->foreign('payment_method_id')
                ->references('payment_method_id')
                ->on('payment_methods')
                ->onDelete('cascade');*/

            $table->foreign('delivery_method_id')
                ->references('delivery_method_id')
                ->on('delivery_methods')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
