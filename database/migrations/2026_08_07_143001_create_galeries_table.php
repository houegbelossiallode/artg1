<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('galeries', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('url_media');
            $table->string('miniature')->nullable();
            $table->foreignId('categorie_galerie_id')->constrained('categorie_galeries')->onDelete('cascade');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('galeries');
    }
};
