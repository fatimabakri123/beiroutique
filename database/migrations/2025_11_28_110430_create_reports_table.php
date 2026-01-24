<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
  public function up(){
    Schema::create('reports', function (Blueprint $table){
        $table->id();
        $table->string('type'); // product/shop/order/other
        $table->unsignedBigInteger('target_id')->nullable();
        $table->string('target_type')->nullable();
        $table->string('reporter_name')->nullable();
        $table->string('reporter_contact')->nullable();
        $table->text('description')->nullable();
        $table->string('status')->default('In Review');
        $table->timestamps();
    });
}

};
