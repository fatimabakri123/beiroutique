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
       Schema::create('reports_issue', function (Blueprint $table) {
    $table->id();

    $table->foreignId('customer_id')
          ->constrained('customers')
          ->onDelete('cascade');

    $table->foreignId('order_id')
          ->constrained()
          ->onDelete('cascade');

    $table->foreignId('product_id')
          ->constrained()
          ->onDelete('cascade');

    $table->string('issue_type');
    $table->text('description');
    $table->string('image')->nullable();

    $table->enum('status', ['Pending', 'In Review', 'Resolved'])
          ->default('Pending');

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports_issue');
    }
};
