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
        Schema::table('progresos', function (Blueprint $table) {
            // Añadir campos que faltan si no existen
            if (!Schema::hasColumn('progresos', 'completado')) {
                $table->boolean('completado')->default(false);
            }
            if (!Schema::hasColumn('progresos', 'fecha_inicio')) {
                $table->timestamp('fecha_inicio')->nullable();
            }
            if (!Schema::hasColumn('progresos', 'fecha_completado')) {
                $table->timestamp('fecha_completado')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('progresos', function (Blueprint $table) {
            $table->dropColumn(['completado', 'fecha_inicio', 'fecha_completado']);
        });
    }
};
