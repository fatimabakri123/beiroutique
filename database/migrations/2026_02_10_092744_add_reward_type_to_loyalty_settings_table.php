<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loyalty_settings', function (Blueprint $table) {
            $table->enum('reward_type', ['one_time', 'recurring'])
                  ->default('one_time')
                  ->after('discount_percentage');
        });
    }

    public function down(): void
    {
        Schema::table('loyalty_settings', function (Blueprint $table) {
            $table->dropColumn('reward_type');
        });
    }
};