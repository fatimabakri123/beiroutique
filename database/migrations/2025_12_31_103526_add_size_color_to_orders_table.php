<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
public function up()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->string('size')->nullable();   // to store multiple sizes
        $table->string('color')->nullable();  // to store multiple colors
        $table->text('comment')->nullable();  // to store customer comment
    });
}

public function down()
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn(['size', 'color', 'comment']);
    });
}

};
