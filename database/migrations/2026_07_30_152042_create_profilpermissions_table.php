<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('profilpermissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('profil_id')->constrained('profils');
            $table->foreignId('sousmenu_id')->constrained('sousmenus');
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('profilpermissions');
    }
};