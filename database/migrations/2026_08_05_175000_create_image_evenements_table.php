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
        Schema::create('image_evenements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('evenement_id')->constrained('evenements')->onDelete('cascade');
            $table->string('image_path');
            $table->boolean('is_principal')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('image_evenements');
    }
};
