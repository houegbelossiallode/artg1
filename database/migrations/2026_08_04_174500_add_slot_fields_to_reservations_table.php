<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->date('date_reservation')->nullable()->after('user_id');
            $table->time('heure_debut')->nullable()->after('date_reservation');
            $table->time('heure_fin')->nullable()->after('heure_debut');
            $table->foreignId('disponibilite_id')->nullable()->after('heure_fin')->constrained('disponibilites')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['disponibilite_id']);
            $table->dropColumn(['date_reservation', 'heure_debut', 'heure_fin', 'disponibilite_id']);
        });
    }
};
