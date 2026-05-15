<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frs_users', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_frs');
            $table->string('nom');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('role', 20)->default('user');
            $table->tinyInteger('actif')->default(1);
            $table->timestamps();

            $table->foreign('id_frs')->references('id')->on('frs');
            $table->index(['id_frs', 'role']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frs_users');
    }
};

