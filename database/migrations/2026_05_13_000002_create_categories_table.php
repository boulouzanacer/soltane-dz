<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_frs');
            $table->string('nom', 100);
            $table->string('slug', 120);
            $table->timestamps();

            $table->foreign('id_frs')->references('id')->on('frs')->onDelete('cascade');
            $table->unique(['id_frs', 'slug']);
            $table->unique(['id_frs', 'nom']);
        });

        $rows = DB::table('produit')
            ->select(['id_frs', 'categorie'])
            ->whereNull('deleted_at')
            ->distinct()
            ->get();

        foreach ($rows as $r) {
            $name = trim((string) ($r->categorie ?? ''));
            $frsId = (int) ($r->id_frs ?? 0);
            if ($frsId <= 0 || $name === '') {
                continue;
            }

            $slug = Str::slug($name);
            if ($slug === '') {
                $slug = Str::slug('categorie-'.$name);
            }

            DB::table('categories')->updateOrInsert(
                ['id_frs' => $frsId, 'nom' => $name],
                ['slug' => $slug, 'created_at' => now(), 'updated_at' => now()]
            );
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};

