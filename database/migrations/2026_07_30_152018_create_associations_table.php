<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('logo');
            $table->longText('historique');
            $table->longText('mission');
            $table->longText('vision');
            $table->longText('description');
            $table->string('adresse');
            $table->string('telephone');
            $table->string('email');
            $table->string('facebook')->nullable();
            $table->string('youtube')->nullable();
            $table->string('instagram')->nullable();
            $table->string('site_web')->nullable();
            $table->string('actif')->default('OUI');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associations');
    }
};