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
            $table->id('id_desafio');
            $table->integer('nivel');
            $table->string('titulo');
            $table->text('descripcion');
            $table->string('tipo'); // terminal, filesystem, permisos, procesos, red
            $table->json('criterios_validacion')->nullable();
            $table->integer('xp_recompensa')->default(25);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->index(['nivel', 'activo']);
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
