<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frs', function (Blueprint $table) {
            $table->tinyInteger('show_prices_to_guests')->default(1)->after('is_visible');
        });
    }

    public function down(): void
    {
        Schema::table('frs', function (Blueprint $table) {
            $table->dropColumn('show_prices_to_guests');
        });
    }
};

