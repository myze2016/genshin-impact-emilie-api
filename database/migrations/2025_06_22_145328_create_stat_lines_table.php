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
        Schema::create('stat_lines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('party_artifact_id')->nullable();
            $table->foreign('party_artifact_id')
                ->references('id')->on('party_artifact')
                ->onDelete('cascade');
            $table->unsignedBigInteger('sands')->nullable();
            $table->foreign('sands')
                ->references('id')->on('stats')
                ->onDelete('cascade');
            $table->unsignedBigInteger('goblet')->nullable();
            $table->foreign('goblet')
                ->references('id')->on('stats')
                ->onDelete('cascade');
            $table->unsignedBigInteger('circlet')->nullable();
            $table->foreign('circlet')
                ->references('id')->on('stats')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stat_lines');
    }
};
