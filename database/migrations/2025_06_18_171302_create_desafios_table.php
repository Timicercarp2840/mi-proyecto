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
        Schema::create('desafios', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descripcion');
            $table->enum('tipo', ['terminal', 'filesystem', 'permisos']); // Tipo de desafío
            $table->enum('nivel', ['principiante', 'intermedio', 'avanzado']); // Nivel de dificultad
            $table->json('configuracion'); // Configuración específica del desafío (comandos esperados, archivos, etc.)
            $table->text('solucion')->nullable(); // Solución del desafío
            $table->integer('puntos')->default(10); // Puntos que otorga el desafío
            $table->boolean('activo')->default(true); // Si está activo o no
            $table->integer('orden')->default(0); // Orden de aparición
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('desafios');
    }
};
