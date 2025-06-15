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
        Schema::create('party_weapon', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_character_id')->nullable();
            $table->foreign('party_character_id')
                ->references('id')->on('party_position_characters')
                ->onDelete('cascade');
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->foreign('weapon_id')
                ->references('id')->on('weapons')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_weapon');
    }
};
