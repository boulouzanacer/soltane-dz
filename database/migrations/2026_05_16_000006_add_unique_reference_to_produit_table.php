<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        try {
            Schema::table('produit', function (Blueprint $table) {
                $table->unique(['id_frs', 'reference'], 'produit_id_frs_reference_unique');
            });
        } catch (Throwable) {
        }
    }

    public function down(): void
    {
        try {
            Schema::table('produit', function (Blueprint $table) {
                $table->dropUnique('produit_id_frs_reference_unique');
            });
        } catch (Throwable) {
        }
    }
};
