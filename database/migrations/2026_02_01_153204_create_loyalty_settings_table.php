<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('loyalty_settings', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('shop_id');

            $table->integer('min_orders')->default(5);
            $table->decimal('min_revenue', 10, 2)->default(200);
            $table->integer('discount_percentage')->default(10);

            $table->timestamps();

            // ✅ Correct FK
            $table->foreign('shop_id')
                  ->references('shop_id')
                  ->on('shops')
                  ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('loyalty_settings');
    }
};