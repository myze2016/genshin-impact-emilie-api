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
        Schema::create('character_weapons', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('character_id')->nullable();
            $table->foreign('character_id')
                ->references('id')->on('characters')
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
        Schema::dropIfExists('character_weapons');
    }
};
