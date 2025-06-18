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
        Schema::create('comandos_enviados', function (Blueprint $table) {
            $table->id('id_comando');
            $table->unsignedBigInteger('id_usuario');
            $table->string('comando');
            $table->integer('desafio_id');
            $table->boolean('correcto')->default(false);
            $table->timestamp('enviado_en');
            
            $table->foreign('id_usuario')->references('id')->on('users')->onDelete('cascade');
            $table->index(['id_usuario', 'correcto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comandos_enviados');
    }
};
