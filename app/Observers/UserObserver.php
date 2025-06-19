<?php

namespace App\Observers;

use App\Models\User;
use App\Models\Modulo;
use App\Models\Progreso;

class UserObserver
{
    /**
     * Handle the User "created" event.
     */
    public function created(User $user): void
    {
        // Solo asignar módulos si es estudiante
        if ($user->rol === 'estudiante') {
            $this->asignarModulos($user);
        }
    }

    /**
     * Asignar todos los módulos disponibles al usuario
     */
    private function asignarModulos(User $user): void
    {
        $modulos = Modulo::all();
        
        foreach ($modulos as $modulo) {
            Progreso::firstOrCreate([
                'id_usuario' => $user->id,
                'id_modulo' => $modulo->id,
            ], [
                'completado' => false,
                'fecha_inicio' => now(),
                'puntuacion' => 0,
            ]);
        }
    }
}
