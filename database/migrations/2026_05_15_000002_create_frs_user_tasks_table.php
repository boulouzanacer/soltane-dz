<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('frs_user_tasks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_frs_user');
            $table->string('titre', 255);
            $table->text('description')->nullable();
            $table->string('statut', 20)->default('todo');
            $table->date('due_date')->nullable();
            $table->timestamps();

            $table->foreign('id_frs_user')->references('id')->on('frs_users')->onDelete('cascade');
            $table->index(['id_frs_user', 'statut']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('frs_user_tasks');
    }
};

