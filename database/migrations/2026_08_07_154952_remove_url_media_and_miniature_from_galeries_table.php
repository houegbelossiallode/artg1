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
        Schema::table('galeries', function (Blueprint $table) {
            $table->dropColumn(['url_media', 'miniature']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('galeries', function (Blueprint $table) {
            $table->string('url_media', 500)->after('description');
            $table->string('miniature', 500)->nullable()->after('url_media');
        });
    }
};
