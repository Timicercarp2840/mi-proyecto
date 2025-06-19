<?php

namespace App\Http\Controllers;

use App\Models\Desafio;
use App\Models\User;
use App\Models\Modulo;
use App\Models\ProgresoDesafio;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\DB;

class AdminDesafioController extends Controller
{
    /**
     * Mostrar lista de desafíos para administración
     */
    public function index()
    {
        $desafios = Desafio::with(['progresosDesafio' => function($query) {
            $query->where('completado', true);
        }])->get();

        return Inertia::render('Admin/Desafios/Index', [
            'desafios' => $desafios
        ]);
    }

    /**
     * Mostrar formulario para crear nuevo desafío
     */
    public function create()
    {
        return Inertia::render('Admin/Desafios/Create');
    }

    /**
     * Almacenar nuevo desafío
     */
    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required|integer|min:1',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:terminal,filesystem,permisos,general',
            'criterios_validacion' => 'required|array',
            'xp_recompensa' => 'required|integer|min:1',
            'activo' => 'boolean'
        ]);

        $desafio = Desafio::create([
            'nivel' => $request->nivel,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'criterios_validacion' => $request->criterios_validacion,
            'xp_recompensa' => $request->xp_recompensa,
            'activo' => $request->activo ?? true
        ]);

        // Asignar el desafío a todos los usuarios existentes
        $this->asignarDesafioATodosLosUsuarios($desafio);

        return redirect()->route('admin.desafios')
            ->with('success', 'Desafío creado exitosamente y asignado a todos los usuarios.');
    }

    /**
     * Mostrar formulario para editar desafío
     */
    public function edit($id)
    {
        $desafio = Desafio::findOrFail($id);

        return Inertia::render('Admin/Desafios/Edit', [
            'desafio' => $desafio
        ]);
    }

    /**
     * Actualizar desafío
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nivel' => 'required|integer|min:1',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'tipo' => 'required|in:terminal,filesystem,permisos,general',
            'criterios_validacion' => 'required|array',
            'xp_recompensa' => 'required|integer|min:1',
            'activo' => 'boolean'
        ]);

        $desafio = Desafio::findOrFail($id);
        $desafio->update([
            'nivel' => $request->nivel,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'tipo' => $request->tipo,
            'criterios_validacion' => $request->criterios_validacion,
            'xp_recompensa' => $request->xp_recompensa,
            'activo' => $request->activo ?? true
        ]);

        return redirect()->route('admin.desafios')
            ->with('success', 'Desafío actualizado exitosamente.');
    }

    /**
     * Eliminar desafío
     */
    public function destroy($id)
    {
        $desafio = Desafio::findOrFail($id);
        
        // Eliminar progreso relacionado
        ProgresoDesafio::where('id_desafio', $id)->delete();
        
        $desafio->delete();

        return redirect()->route('admin.desafios')
            ->with('success', 'Desafío eliminado exitosamente.');
    }

    /**
     * Asignar desafío a todos los usuarios
     */
    private function asignarDesafioATodosLosUsuarios(Desafio $desafio)
    {
        $usuarios = User::where('rol', 'estudiante')->get();
        
        foreach ($usuarios as $usuario) {
            ProgresoDesafio::firstOrCreate([
                'id_usuario' => $usuario->id,
                'id_desafio' => $desafio->id_desafio
            ], [
                'completado' => false,
                'fecha_completado' => null
            ]);
        }
    }

    /**
     * Asignar desafío específico a todos los usuarios (para usar desde API)
     */
    public function asignarATodos($id)
    {
        $desafio = Desafio::findOrFail($id);
        $this->asignarDesafioATodosLosUsuarios($desafio);

        return redirect()->route('admin.desafios')
            ->with('success', 'Desafío asignado a todos los usuarios exitosamente.');
    }

    /**
     * Activar/Desactivar desafío
     */
    public function toggleActivation($id)
    {
        $desafio = Desafio::findOrFail($id);
        $desafio->update(['activo' => !$desafio->activo]);

        $status = $desafio->activo ? 'activado' : 'desactivado';
        
        return redirect()->route('admin.desafios')
            ->with('success', "Desafío {$status} exitosamente.");
    }
}
