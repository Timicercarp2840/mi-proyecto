<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Progreso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        
        if ($user->esAdministrador()) {
            return redirect()->route('admin.dashboard');
        }
        
        // Dashboard para estudiantes
        $modulos = Modulo::orderBy('nivel')->get();
        $progresos = Progreso::where('id_usuario', $user->id)
            ->pluck('estado', 'id_modulo')
            ->toArray();
            
        $totalModulos = $modulos->count();
        $modulosCompletados = count(array_filter($progresos, function($estado) {
            return $estado === 'completado';
        }));
        
        $porcentajeProgreso = $totalModulos > 0 ? ($modulosCompletados / $totalModulos) * 100 : 0;
        
        return Inertia::render('Dashboard', [
            'modulos' => $modulos,
            'progreso' => $progresos,
            'usuario' => [
                'xp_total' => $user->xp_total,
                'nivel_actual' => $user->nivel_actual,
                'titulo' => $user->titulo,
                'insignias' => $user->insignias()->count(),
            ],
            'stats' => [
                'totalModulos' => $totalModulos,
                'modulosCompletados' => $modulosCompletados,
                'porcentajeProgreso' => round($porcentajeProgreso, 2),
            ]
        ]);
    }
}
