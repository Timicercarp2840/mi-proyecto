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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('xp_total')->default(0);
            $table->integer('nivel_actual')->default(1);
            $table->string('titulo')->nullable(); // "Novato Pingüino", "Maestro de Redes", etc.
            $table->json('estadisticas')->nullable(); // Para estadísticas adicionales
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['xp_total', 'nivel_actual', 'titulo', 'estadisticas']);
        });
    }
};
