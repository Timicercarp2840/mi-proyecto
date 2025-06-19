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
        Schema::create('progreso_desafios', function (Blueprint $table) {
            $table->id('id_progreso_desafio');
            $table->unsignedBigInteger('id_usuario');
            $table->unsignedBigInteger('id_desafio');
            $table->boolean('completado')->default(false);
            $table->integer('intentos')->default(0);
            $table->timestamp('completado_en')->nullable();
            $table->timestamps();
            
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_desafio')->references('id_desafio')->on('desafios')->onDelete('cascade');
            $table->unique(['id_usuario', 'id_desafio']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progreso_desafios');
    }
};
