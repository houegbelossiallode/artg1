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
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->date('date_dispo')->nullable()->after('professeur_id');
            $table->string('jour')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->dropColumn('date_dispo');
            $table->string('jour')->nullable(false)->change();
        });
    }
};
