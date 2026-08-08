<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('talent_candidatures', function (Blueprint $table) {
            $table->id();
            $table->string('nom');
            $table->string('prenom')->nullable();
            $table->string('pseudo')->nullable();
            $table->integer('age')->nullable();
            $table->foreignId('discipline_id')->constrained('disciplines');
            $table->string('demo_link')->nullable();
            $table->text('presentation')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('whatsapp')->nullable();
            $table->string('statut')->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('talent_candidatures');
    }
};
