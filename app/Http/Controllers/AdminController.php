<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modulo;
use App\Models\Evaluacion;
use App\Models\Progreso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user() || !auth()->user()->esAdministrador()) {
                abort(403, 'Acceso denegado');
            }
            return $next($request);
        });
    }

    /**
     * Dashboard de administración
     */
    public function dashboard()
    {
        $totalUsuarios = User::where('rol', 'estudiante')->count();
        $totalModulos = Modulo::count();
        $totalEvaluaciones = Evaluacion::count();
        $progresosCompletados = Progreso::where('estado', 'completado')->count();
        
        return Inertia::render('Admin/Dashboard', [
            'stats' => [
                'totalUsuarios' => $totalUsuarios,
                'totalModulos' => $totalModulos,
                'totalEvaluaciones' => $totalEvaluaciones,
                'progresosCompletados' => $progresosCompletados,
            ]
        ]);
    }

    /**
     * Gestión de usuarios
     */
    public function usuarios()
    {
        $usuarios = User::all();
        
        return Inertia::render('Admin/Usuarios', [
            'usuarios' => $usuarios,
        ]);
    }

    /**
     * Gestión de módulos
     */
    public function modulos()
    {
        $modulos = Modulo::with('evaluaciones')->orderBy('nivel')->get();
        
        return Inertia::render('Admin/Modulos', [
            'modulos' => $modulos,
        ]);
    }

    /**
     * Gestión de evaluaciones
     */
    public function evaluaciones()
    {
        $evaluaciones = Evaluacion::with('modulo')->get();
        
        return Inertia::render('Admin/Evaluaciones', [
            'evaluaciones' => $evaluaciones,
        ]);
    }
    
    /**
     * Cambiar rol de usuario
     */
    public function cambiarRol(Request $request, User $user)
    {
        $request->validate([
            'rol' => 'required|in:estudiante,administrador',
        ]);
        
        $user->update([
            'rol' => $request->rol,
        ]);
        
        return redirect()->back()->with('success', 'Rol actualizado exitosamente.');
    }
}
