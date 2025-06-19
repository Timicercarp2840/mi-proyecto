<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Modulo;
use App\Models\Evaluacion;
use App\Models\Progreso;
use App\Models\Desafio;
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

    /**
     * Gestión de desafíos
     */
    public function desafios()
    {
        $desafios = Desafio::ordenados()->get();
        
        return Inertia::render('Admin/Desafios', [
            'desafios' => $desafios,
        ]);
    }

    /**
     * Estadísticas y reportes
     */
    public function estadisticas()
    {
        $totalUsuarios = User::where('rol', 'estudiante')->count();
        $totalModulos = Modulo::count();
        $totalEvaluaciones = Evaluacion::count();
        $totalDesafios = Desafio::count();
        $progresosCompletados = Progreso::where('estado', 'completado')->count();
        
        // Estadísticas por módulo
        $estadisticasModulos = Modulo::withCount([
            'progresos',
            'progresos as completados' => function ($query) {
                $query->where('estado', 'completado');
            }
        ])->get();
        
        // Usuarios más activos
        $usuariosActivos = User::where('rol', 'estudiante')
            ->withCount('progresos')
            ->orderBy('progresos_count', 'desc')
            ->limit(10)
            ->get();
        
        return Inertia::render('Admin/Estadisticas', [
            'stats' => [
                'totalUsuarios' => $totalUsuarios,
                'totalModulos' => $totalModulos,
                'totalEvaluaciones' => $totalEvaluaciones,
                'totalDesafios' => $totalDesafios,
                'progresosCompletados' => $progresosCompletados,
            ],
            'estadisticasModulos' => $estadisticasModulos,
            'usuariosActivos' => $usuariosActivos,
        ]);
    }

    /**
     * Crear nuevo desafío
     */
    public function crearDesafio()
    {
        return Inertia::render('Admin/Desafios/Create');
    }

    /**
     * Guardar nuevo desafío
     */
    public function storeDesafio(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:terminal,filesystem,permisos',
            'nivel' => 'required|integer|min:1|max:3',
            'criterios_validacion' => 'required|array',
            'xp_recompensa' => 'required|integer|min:1',
        ]);

        Desafio::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'nivel' => $request->nivel,
            'criterios_validacion' => $request->criterios_validacion,
            'xp_recompensa' => $request->xp_recompensa,
            'activo' => true,
        ]);

        return redirect()->route('admin.desafios')->with('success', 'Desafío creado exitosamente.');
    }

    /**
     * Editar desafío
     */
    public function editarDesafio($id)
    {
        $desafio = Desafio::findOrFail($id);
        
        return Inertia::render('Admin/Desafios/Edit', [
            'desafio' => $desafio,
        ]);
    }

    /**
     * Actualizar desafío
     */
    public function updateDesafio(Request $request, $id)
    {
        $desafio = Desafio::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:terminal,filesystem,permisos',
            'nivel' => 'required|integer|min:1|max:3',
            'criterios_validacion' => 'required|array',
            'xp_recompensa' => 'required|integer|min:1',
            'activo' => 'required|boolean',
        ]);

        $desafio->update($request->all());

        return redirect()->route('admin.desafios')->with('success', 'Desafío actualizado exitosamente.');
    }

    /**
     * Eliminar desafío
     */
    public function destroyDesafio($id)
    {
        $desafio = Desafio::findOrFail($id);
        $desafio->delete();

        return redirect()->route('admin.desafios')->with('success', 'Desafío eliminado exitosamente.');
    }
}
