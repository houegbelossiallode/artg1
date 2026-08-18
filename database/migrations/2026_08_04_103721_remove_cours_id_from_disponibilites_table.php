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
        // Désactiver temporairement la vérification des clés étrangères pour MySQL
        Schema::disableForeignKeyConstraints();

        Schema::table('disponibilites', function (Blueprint $table) {
            // Supprimer la colonne cours_id uniquement si elle existe
            if (Schema::hasColumn('disponibilites', 'cours_id')) {
                $table->dropColumn('cours_id');
            }
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->unsignedBigInteger('cours_id')->nullable();
        });
    }


};
