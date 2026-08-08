<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sousmenus', function (Blueprint $table) {
            $table->id();
            $table->foreignId('menu_id')->constrained('menus');
            $table->string('libelle');
            $table->string('url');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sousmenus');
    }
};