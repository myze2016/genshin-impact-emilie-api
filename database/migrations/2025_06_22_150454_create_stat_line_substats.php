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
        Schema::create('stat_line_substats', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('stat_line_id')->nullable();
            $table->foreign('stat_line_id')
                ->references('id')->on('stat_lines')
                ->onDelete('cascade');
            $table->unsignedBigInteger('stat_id')->nullable();
            $table->foreign('stat_id')
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
        Schema::dropIfExists('stat_line_substats');
    }
};
