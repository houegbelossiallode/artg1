<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('disciplines', function (Blueprint $table) {
            $table->id();
            $table->string('libelle');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });

        DB::table('disciplines')->insert([
            ['libelle' => 'Chant & Polyphonie', 'actif' => 'OUI'],
            ['libelle' => 'Percussions & Balafon', 'actif' => 'OUI'],
            ['libelle' => 'Instruments à Cordes', 'actif' => 'OUI'],
            ['libelle' => 'Création Numérique Audio', 'actif' => 'OUI'],
            ['libelle' => 'Autre', 'actif' => 'OUI'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('disciplines');
    }
};
