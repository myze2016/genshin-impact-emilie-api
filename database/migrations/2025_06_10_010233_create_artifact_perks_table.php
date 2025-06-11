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
        Schema::create('artifact_perks', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('artifact_id')->nullable();
            $table->foreign('artifact_id')
                ->references('id')->on('artifacts')
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
        Schema::dropIfExists('artifact_perks');
    }
};
