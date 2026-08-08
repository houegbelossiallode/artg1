<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('diffusions_evenements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->constrained('evenements');
            $table->string('plateforme');
            $table->string('lien_reunion');
            $table->date('date_ouverture');
            $table->date('date_fermeture');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diffusions_evenements');
    }
};