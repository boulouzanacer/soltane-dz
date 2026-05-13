<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frais_livraison', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_frs');
            $table->unsignedInteger('id_wilaya');
            $table->decimal('frais', 10, 2)->default(0);
            $table->timestamps();

            $table->foreign('id_frs')->references('id')->on('frs')->onDelete('cascade');
            $table->foreign('id_wilaya')->references('ID_WILAYA')->on('wilaya')->onDelete('cascade');
            $table->unique(['id_frs', 'id_wilaya']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frais_livraison');
    }
};

