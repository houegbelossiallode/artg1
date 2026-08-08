<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_evenement_id')->nullable()->constrained('categorie_evenements');
            $table->string('titre');
            $table->boolean('gratuit')->default(false);
            $table->string('description')->nullable();
            $table->date('date_debut');
            $table->date('date_fin');
            $table->time('heure');
            $table->string('lieu');
            $table->integer('capacite');
            $table->string('photo')->nullable();
            $table->decimal('prix', 12, 2)->nullable();
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evenements');
    }
};