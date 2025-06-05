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
        Schema::create('characters', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('element')->nullable();
            $table->string('gacha_card_url')->nullable();
            $table->string('gacha_splash_url')->nullable();
            $table->string('icon_url')->nullable();
            $table->string('icon_side_url')->nullable();
            $table->string('namecard_background_url')->nullable();
            $table->string('api_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('characters');
    }
};
