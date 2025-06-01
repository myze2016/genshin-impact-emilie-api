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
        Schema::create('party_position_characters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('element')->nullable();
            $table->unsignedInteger('value')->default(1);
            $table->unsignedBigInteger('character_id')->nullable();
            $table->foreign('character_id')
                ->references('id')->on('characters')
                ->onDelete('cascade');
            $table->unsignedBigInteger('party_position_id')->nullable();
            $table->foreign('party_position_id')
                ->references('id')->on('party_positions')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('party_position_characters');
    }
};
