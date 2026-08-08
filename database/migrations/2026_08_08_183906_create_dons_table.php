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
        Schema::create('dons', function (Blueprint $table) {
            $table->id();
            $table->string('nom')->nullable();
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->decimal('montant', 10, 2);
            $table->string('mode_paiement')->default('especes'); // especes, cheque, virement, mobile_money
            $table->text('message')->nullable();
            $table->boolean('anonyme')->default(false);
            $table->enum('statut', ['en_attente', 'confirme', 'annule'])->default('en_attente');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dons');
    }
};
