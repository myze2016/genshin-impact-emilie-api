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
        Schema::create('party_artifact', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_character_id')->nullable();
            $table->foreign('party_character_id')
                ->references('id')->on('party_position_characters')
                ->onDelete('cascade');
            $table->unsignedBigInteger('artifact_id')->nullable();
            $table->foreign('artifact_id')
                ->references('id')->on('artifacts')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_artifact');
    }
};
