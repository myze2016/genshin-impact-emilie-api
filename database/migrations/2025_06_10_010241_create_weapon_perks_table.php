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
        Schema::create('weapon_perks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('weapon_id')->nullable();
            $table->foreign('weapon_id')
                ->references('id')->on('weapons')
                ->onDelete('cascade');
            $table->unsignedBigInteger('perk_id')->nullable();
            $table->foreign('perk_id')
                ->references('id')->on('perks')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weapon_perks');
    }
};
