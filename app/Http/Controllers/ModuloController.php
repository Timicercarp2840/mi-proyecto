<?php

namespace App\Http\Controllers;

use App\Models\Modulo;
use App\Models\Progreso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modulos = Modulo::orderBy('nivel')->get();
        
        // Si el usuario está autenticado, obtenemos su progreso
        $progreso = [];
        if (auth()->check()) {
            $progreso = Progreso::where('id_usuario', auth()->id())
                ->pluck('estado', 'id_modulo')
                ->toArray();
        }
        
        return Inertia::render('Modulos/Index', [
            'modulos' => $modulos,
            'progreso' => $progreso,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Modulos/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nivel' => 'required|integer|min:1',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido' => 'nullable|string',
        ]);

        Modulo::create($request->all());

        return redirect()->route('admin.modulos')->with('success', 'Módulo creado exitosamente.');
    }

    /**
     * Display the specified resource.
     */    public function show($id_modulo)
    {
        $modulo = Modulo::where('id_modulo', $id_modulo)->with('evaluaciones')->firstOrFail();
        
        // Verificar progreso del usuario
        $progreso = null;
        if (auth()->check()) {
            $progreso = Progreso::where('id_usuario', auth()->id())
                ->where('id_modulo', $modulo->id_modulo)
                ->first();
        }
        
        // Obtener desafíos del nivel correspondiente al módulo
        $desafios = \App\Models\Desafio::where('nivel', $modulo->nivel)
            ->where('activo', true)
            ->orderBy('created_at')
            ->get();
            
        // Verificar progreso en desafíos si el usuario está autenticado
        $progresoDesafios = [];
        if (auth()->check()) {
            $progresoDesafios = \App\Models\ProgresoDesafio::where('id_usuario', auth()->id())
                ->whereIn('id_desafio', $desafios->pluck('id_desafio'))
                ->pluck('completado', 'id_desafio')
                ->toArray();
        }
        
        // Marcar desafíos completados
        foreach ($desafios as $desafio) {
            $desafio->completado = $progresoDesafios[$desafio->id_desafio] ?? false;
        }
        
        return Inertia::render('Modulos/Show', [
            'modulo' => $modulo,
            'progreso' => $progreso,
            'desafios' => $desafios,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_modulo)
    {
        $modulo = Modulo::where('id_modulo', $id_modulo)->firstOrFail();
        
        return Inertia::render('Modulos/Edit', [
            'modulo' => $modulo,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_modulo)
    {
        $modulo = Modulo::where('id_modulo', $id_modulo)->firstOrFail();
        
        $request->validate([
            'nivel' => 'required|integer|min:1',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'contenido' => 'nullable|string',
        ]);

        $modulo->update($request->all());

        return redirect()->route('admin.modulos')->with('success', 'Módulo actualizado exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_modulo)
    {
        $modulo = Modulo::where('id_modulo', $id_modulo)->firstOrFail();
        $modulo->delete();

        return redirect()->route('admin.modulos')->with('success', 'Módulo eliminado exitosamente.');
    }
}
