<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    // public function up(): void
    // {
    //     Schema::table('disponibilites', function (Blueprint $table) {
    //         $table->dropForeign(['cours_id']);
    //         $table->dropColumn('cours_id');
    //     });
    // }

    // /**
    //  * Reverse the migrations.
    //  */
    // public function down(): void
    // {
    //     Schema::table('disponibilites', function (Blueprint $table) {
    //         $table->foreignId('cours_id')->nullable()->constrained('cours');
    //     });
    // }


    public function up(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            // Tente de supprimer la clé étrangère si elle existe, sinon ignore l'erreur
            try {
                $table->dropForeign(['cours_id']);
            } catch (\Exception $e) {
                // La clé étrangère n'existe pas, on passe à la suite
            }

            // Supprime la colonne cours_id si elle existe toujours
            if (Schema::hasColumn('disponibilites', 'cours_id')) {
                $table->dropColumn('cours_id');
            }
        });
    }

    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->foreignId('cours_id')->nullable()->constrained();
        });
    }


};
