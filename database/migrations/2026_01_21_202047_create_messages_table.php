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
      Schema::create('messages', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('conversation_id');
    $table->unsignedBigInteger('sender_id');
    $table->text('message')->nullable();
    $table->string('type')->default('text'); // text | file | voice
    $table->string('file_path')->nullable();
    $table->boolean('is_seen')->default(false);
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('messages');
    }
};
