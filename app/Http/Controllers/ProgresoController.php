<?php

namespace App\Http\Controllers;

use App\Models\Progreso;
use App\Models\User;
use App\Models\Modulo;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProgresoController extends Controller
{
    /**
     * Obtener progreso del usuario autenticado
     */
    public function miProgreso()
    {
        $usuario = auth()->user();
        $progresos = Progreso::with('modulo')
            ->where('id_usuario', $usuario->id)
            ->get();
            
        $totalModulos = Modulo::count();
        $modulosCompletados = $progresos->where('estado', 'completado')->count();
        $porcentajeProgreso = $totalModulos > 0 ? ($modulosCompletados / $totalModulos) * 100 : 0;
        
        return Inertia::render('Progreso/MiProgreso', [
            'progresos' => $progresos,
            'totalModulos' => $totalModulos,
            'modulosCompletados' => $modulosCompletados,
            'porcentajeProgreso' => round($porcentajeProgreso, 2),
        ]);
    }

    /**
     * Actualizar progreso de un módulo
     */
    public function actualizar(Request $request, $id_modulo)
    {
        $request->validate([
            'estado' => 'required|in:en_proceso,completado',
            'puntuacion' => 'nullable|integer|min:0|max:100',
        ]);

        Progreso::updateOrCreate([
            'id_usuario' => auth()->id(),
            'id_modulo' => $id_modulo,
        ], [
            'estado' => $request->estado,
            'puntuacion' => $request->puntuacion,
        ]);

        return response()->json(['success' => true]);
    }
}
