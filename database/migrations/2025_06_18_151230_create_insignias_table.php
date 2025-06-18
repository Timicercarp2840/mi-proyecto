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
        Schema::create('insignias', function (Blueprint $table) {
            $table->id('id_insignia');
            $table->string('nombre');
            $table->text('descripcion');
            $table->string('icono')->default('🏆'); // Emoji por defecto
            $table->string('color')->default('#f59e0b'); // Color por defecto
            $table->integer('xp_requerido')->default(0);
            $table->integer('nivel_modulo')->nullable(); // Nivel de módulo asociado
            $table->string('tipo')->default('logro'); // logro, nivel, especial
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insignias');
    }
};
