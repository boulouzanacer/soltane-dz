<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('frs', function (Blueprint $table) {
            $table->tinyInteger('enable_frais_livraison')->default(0)->after('show_prices_to_guests');
        });

        Schema::table('cmd1', function (Blueprint $table) {
            $table->decimal('sous_total', 10, 2)->default(0)->after('montant_total');
            $table->decimal('frais_livraison', 10, 2)->default(0)->after('sous_total');
        });
    }

    public function down(): void
    {
        Schema::table('cmd1', function (Blueprint $table) {
            $table->dropColumn(['sous_total', 'frais_livraison']);
        });

        Schema::table('frs', function (Blueprint $table) {
            $table->dropColumn('enable_frais_livraison');
        });
    }
};

