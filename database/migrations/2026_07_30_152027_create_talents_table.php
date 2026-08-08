<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('talents', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom');
            $table->string('photo');
            $table->text('biographie')->nullable();
            $table->foreignId('categorie_talent_id')->constrained('categorie_talents');
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('telephone')->nullable();
            $table->string('email')->nullable();
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('talents');
    }
};