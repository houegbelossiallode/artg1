<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('oeuvres', function (Blueprint $table) {
            $table->id();
            $table->foreignId('talent_id')->constrained('talents');
            $table->string('nom');
            $table->string('description')->nullable();
            $table->string('type');
            $table->string('fichier');
            $table->string('image')->nullable();
            $table->date('date_publication');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('oeuvres');
    }
};