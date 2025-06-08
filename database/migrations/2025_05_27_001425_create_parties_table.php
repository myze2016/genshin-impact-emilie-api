<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('parties', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('description')->nullable();
            $table->string('reaction')->nullable();
            $table->unsignedBigInteger('element_id')->nullable();
            $table->foreign('element_id')
                ->references('id')->on('elements')
                ->onDelete('cascade');
            $table->unsignedBigInteger('character_id')->nullable();
            $table->foreign('character_id')
                ->references('id')->on('characters')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('parties');
    }
};
