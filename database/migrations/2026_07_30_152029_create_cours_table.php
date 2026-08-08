<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_cours_id')->constrained('categorie_cours');
            $table->foreignId('user_id')->constrained('users');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->date('date_cours');
            $table->time('heure_debut');
            $table->time('heure_fin');
            $table->integer('duree');
            $table->decimal('tarif', 12, 2);
            $table->foreignId('mode_id')->constrained('modes');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cours');
    }
};