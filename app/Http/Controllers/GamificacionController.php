<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Insignia;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GamificacionController extends Controller
{
    /**
     * Agregar XP a un usuario y verificar insignias
     */
    public function agregarXP(User $user, $xp, $razon = null)
    {
        $xpAnterior = $user->xp_total;
        $user->agregarXP($xp);
        
        // Verificar si obtuvo nuevas insignias
        $nuevasInsignias = $this->verificarInsignias($user);
        
        // Crear mensaje de feedback
        $mensaje = "¡Ganaste {$xp} XP!";
        if ($razon) {
            $mensaje .= " Razón: {$razon}";
        }
        
        if (!empty($nuevasInsignias)) {
            $nombreInsignias = collect($nuevasInsignias)->pluck('nombre')->join(', ');
            $mensaje .= " ¡También obtuviste nuevas insignias: {$nombreInsignias}!";
        }
        
        return [
            'xp_ganado' => $xp,
            'xp_total' => $user->xp_total,
            'nivel_actual' => $user->nivel_actual,
            'nuevas_insignias' => $nuevasInsignias,
            'mensaje' => $mensaje
        ];
    }
    
    /**
     * Verificar si el usuario obtuvo nuevas insignias
     */
    private function verificarInsignias(User $user)
    {
        $insigniasDisponibles = Insignia::where('xp_requerido', '<=', $user->xp_total)->get();
        $insigniasObtenidas = $user->insignias()->pluck('insignia_id')->toArray();
        
        $nuevasInsignias = [];
        
        foreach ($insigniasDisponibles as $insignia) {
            if (!in_array($insignia->id_insignia, $insigniasObtenidas)) {
                $user->obtenerInsignia($insignia->id_insignia);
                $nuevasInsignias[] = $insignia;
            }
        }
        
        return $nuevasInsignias;
    }
    
    /**
     * Tabla de clasificación
     */
    public function leaderboard()
    {
        $topUsuarios = User::where('rol', 'estudiante')
            ->orderBy('xp_total', 'desc')
            ->with('insignias')
            ->take(10)
            ->get();
            
        return Inertia::render('Gamificacion/Leaderboard', [
            'usuarios' => $topUsuarios
        ]);
    }
    
    /**
     * Perfil de gamificación del usuario
     */
    public function perfil()
    {
        $user = auth()->user();
        $insignias = $user->insignias()->orderBy('obtenida_en', 'desc')->get();
        $todasLasInsignias = Insignia::all();
        
        // Obtener progreso completo de módulos (igual que en Mi Progreso)
        $progresoModulos = $user->progresos()->with('modulo')->get();
        $totalModulos = \App\Models\Modulo::count();
        $modulosCompletados = $user->progresos()->where('estado', 'completado')->count();
        $porcentajeProgreso = $totalModulos > 0 ? round(($modulosCompletados / $totalModulos) * 100, 1) : 0;
        
        return Inertia::render('Gamificacion/Perfil', [
            'usuario' => $user,
            'insignias_obtenidas' => $insignias,
            'todas_las_insignias' => $todasLasInsignias,
            'progreso_modulos' => $progresoModulos,
            'progresos' => $progresoModulos, // Para compatibilidad con el componente Mi Progreso
            'totalModulos' => $totalModulos,
            'modulosCompletados' => $modulosCompletados,
            'porcentajeProgreso' => $porcentajeProgreso,
            'estadisticas' => [
                'modulos_completados' => $modulosCompletados,
                'modulos_totales' => $totalModulos,
                'porcentaje_completado' => $porcentajeProgreso,
                'xp_siguiente_nivel' => $user->xpParaSiguienteNivel(),
            ]
        ]);
    }
}
