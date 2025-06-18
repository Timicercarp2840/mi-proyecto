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
        Schema::create('progresos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_modulo');
            $table->enum('estado', ['en_proceso', 'completado'])->default('en_proceso');
            $table->integer('puntuacion')->nullable();
            $table->timestamps();
            
            $table->unique(['id_usuario', 'id_modulo']);
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_modulo')->references('id_modulo')->on('modulos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progresos');
    }
};
