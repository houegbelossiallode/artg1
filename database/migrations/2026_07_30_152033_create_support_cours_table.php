<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('support_cours', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cours_id')->constrained('cours');
            $table->string('titre');
            $table->text('description')->nullable();
            $table->string('fichier');
            $table->string('type');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('support_cours');
    }
};