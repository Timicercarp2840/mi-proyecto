<?php

namespace App\Listeners;

use App\Models\Desafio;
use App\Models\Modulo;
use App\Models\ProgresoDesafio;
use App\Models\Progreso;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class AsignarContenidoANuevoUsuario
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        $usuario = $event->user;
        
        // Solo asignar contenido a estudiantes
        if ($usuario->rol !== 'estudiante') {
            return;
        }        // Asignar todos los módulos existentes
        $modulos = Modulo::all();
        foreach ($modulos as $modulo) {
            Progreso::firstOrCreate([
                'id_usuario' => $usuario->id,
                'id_modulo' => $modulo->id_modulo
            ], [
                'estado' => 'no_iniciado',
                'puntuacion' => null
            ]);
        }

        // Asignar todos los desafíos activos
        $desafios = Desafio::where('activo', true)->get();
        foreach ($desafios as $desafio) {            ProgresoDesafio::firstOrCreate([
                'id_usuario' => $usuario->id,
                'id_desafio' => $desafio->id_desafio
            ], [
                'completado' => false,
                'completado_en' => null
            ]);
        }
    }
}
