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
         Schema::table('artifacts', function (Blueprint $table) {
            $table->string('ollama')->nullable();
             $table->text('2set')->nullable();
            $table->text('4set')->nullable();
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
         Schema::table('artifacts', function (Blueprint $table) {
            $table->dropColumn('ollama');
            $table->dropColumn('2set');
              $table->dropColumn('4set');
        });
    }
};
