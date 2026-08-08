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
        Schema::table('cours', function (Blueprint $table) {
            $table->dropColumn(['date_cours', 'heure_debut', 'heure_fin', 'duree']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cours', function (Blueprint $table) {
            $table->date('date_cours')->nullable();
            $table->time('heure_debut')->nullable();
            $table->time('heure_fin')->nullable();
            $table->integer('duree')->nullable();
        });
    }
};
