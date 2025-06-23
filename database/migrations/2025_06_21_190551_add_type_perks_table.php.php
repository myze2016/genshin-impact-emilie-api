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
        Schema::table('perks', function (Blueprint $table) {
            $table->string('type')->nullable()->default('Perk');
            $table->unsignedBigInteger('common_id')->nullable();
            $table->foreign('common_id')
                ->references('id')->on('commons')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('perks', function (Blueprint $table) {
            $table->dropColumn('type');
            $table->dropColumn('color');
            $table->dropForeign(['common_id']);
            $table->dropColumn('common_id');
        });
    }
};
