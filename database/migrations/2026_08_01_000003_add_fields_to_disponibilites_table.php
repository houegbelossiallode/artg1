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
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->string('jour')->after('professeur_id');
            $table->time('debut')->after('jour');
            $table->time('fin')->after('debut');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('disponibilites', function (Blueprint $table) {
            $table->dropColumn(['jour', 'debut', 'fin']);
        });
    }
};
?>
