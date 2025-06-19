<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\User;
use App\Models\Progreso;
use App\Models\ProgresoDesafio;
use App\Models\Insignia;
use App\Models\Modulo;
use App\Models\Evaluacion;

class PerfilUnificadoController extends Controller
{
    public function index()
    {
        $usuario = auth()->user();
        
        // Obtener progreso de módulos
        $progresos = Progreso::with('modulo')
            ->where('id_usuario', $usuario->id)
            ->get();
        
        // Calcular estadísticas de progreso
        $totalModulos = Modulo::count();
        $modulosCompletados = $progresos->where('estado', 'completado')->count();
        
        // Calcular evaluaciones aprobadas (nota >= 60)
        $evaluacionesAprobadas = $progresos->where('puntuacion', '>=', 60)->count();
        
        // Calcular promedio general
        $puntuacionesValidas = $progresos->where('puntuacion', '>', 0)->pluck('puntuacion');
        $promedioGeneral = $puntuacionesValidas->count() > 0 
            ? round($puntuacionesValidas->avg(), 1) 
            : 0;
        
        // Obtener insignias del usuario
        $insignias = $usuario->insignias;
        
        // Obtener leaderboard (top 10)
        $leaderboard = User::where('rol', 'estudiante')
            ->orderBy('xp_total', 'desc')
            ->limit(10)
            ->get();
        
        // Calcular posición del usuario actual
        $miPosicion = User::where('rol', 'estudiante')
            ->where('xp_total', '>', $usuario->xp_total)
            ->count() + 1;
        
        // Contar desafíos completados
        $desafiosCompletados = ProgresoDesafio::where('id_usuario', $usuario->id)
            ->where('completado', true)
            ->count();
        
        return Inertia::render('Perfil/Unificado', [
            'usuario' => $usuario,
            'progresos' => $progresos,
            'insignias' => $insignias,
            'leaderboard' => $leaderboard,
            'miPosicion' => $miPosicion,
            'desafiosCompletados' => $desafiosCompletados,
            'totalModulos' => $totalModulos,
            'modulosCompletados' => $modulosCompletados,
            'evaluacionesAprobadas' => $evaluacionesAprobadas,
            'promedioGeneral' => $promedioGeneral
        ]);
    }
}
