<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->string('jitsi_room_id')->nullable()->after('status');
            $table->string('jitsi_room_password')->nullable()->after('jitsi_room_id');
            $table->string('lien_replay')->nullable()->after('jitsi_room_password');
            $table->text('description_replay')->nullable()->after('lien_replay');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['jitsi_room_id', 'jitsi_room_password', 'lien_replay', 'description_replay']);
        });
    }
};
