<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('disponibilites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours');
            $table->foreignId('professeur_id')->constrained('users');
            $table->string('statut');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disponibilites');
    }
};