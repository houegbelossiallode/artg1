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
            $table->dropForeign(['cours_id']);
            $table->dropColumn('cours_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->foreignId('cours_id')->nullable()->constrained('cours');
        });
    }
};
