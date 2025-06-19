<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Modulo;
use App\Models\Progreso;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $evaluaciones = Evaluacion::with('modulo')->get();
        
        return Inertia::render('Evaluaciones/Index', [
            'evaluaciones' => $evaluaciones,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $modulos = Modulo::all();
        
        return Inertia::render('Evaluaciones/Create', [
            'modulos' => $modulos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_modulo' => 'required|exists:modulos,id_modulo',
            'contenido_eval' => 'required|array',
        ]);

        Evaluacion::create($request->all());

        return redirect()->route('admin.evaluaciones')->with('success', 'Evaluación creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->with('modulo')->firstOrFail();
        
        return Inertia::render('Evaluaciones/Show', [
            'evaluacion' => $evaluacion,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->firstOrFail();
        $modulos = Modulo::all();
        
        return Inertia::render('Evaluaciones/Edit', [
            'evaluacion' => $evaluacion,
            'modulos' => $modulos,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->firstOrFail();
        
        $request->validate([
            'id_modulo' => 'required|exists:modulos,id_modulo',
            'contenido_eval' => 'required|array',
        ]);

        $evaluacion->update($request->all());

        return redirect()->route('admin.evaluaciones')->with('success', 'Evaluación actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->firstOrFail();
        $evaluacion->delete();

        return redirect()->route('admin.evaluaciones')->with('success', 'Evaluación eliminada exitosamente.');
    }

    /**
     * Tomar evaluación
     */
    public function tomar($id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->with('modulo')->firstOrFail();
        
        return Inertia::render('Evaluaciones/Tomar', [
            'evaluacion' => $evaluacion,
        ]);
    }

    /**
     * Calificar evaluación
     */
    public function calificar(Request $request, $id_eval)
    {
        $evaluacion = Evaluacion::where('id_eval', $id_eval)->with('modulo')->firstOrFail();
        
        $request->validate([
            'respuestas' => 'required|array',
        ]);

        $contenido = $evaluacion->contenido_eval;
        $respuestasCorrectas = 0;
        $totalPreguntas = count($contenido);

        foreach ($contenido as $index => $pregunta) {
            if (isset($request->respuestas[$index]) && 
                $request->respuestas[$index] == $pregunta['respuesta_correcta']) {
                $respuestasCorrectas++;
            }
        }

        $puntuacion = ($respuestasCorrectas / $totalPreguntas) * 100;
        $aprobado = $puntuacion >= 70;

        // Actualizar progreso
        Progreso::updateOrCreate([
            'id_usuario' => auth()->id(),
            'id_modulo' => $evaluacion->id_modulo,
        ], [
            'estado' => $aprobado ? 'completado' : 'en_proceso',
            'puntuacion' => $puntuacion,
        ]);

        // Sistema de gamificación
        $user = auth()->user();
        $gamificacionController = new \App\Http\Controllers\GamificacionController();
        
        if ($aprobado) {
            // XP por aprobar: 100 XP base + puntuación extra
            $xpGanado = 100 + round($puntuacion);
            $razon = "Evaluación del Nivel {$evaluacion->modulo->nivel} aprobada con {$puntuacion}%";
            
            // Verificar si completó el módulo por primera vez
            $progresoAnterior = Progreso::where('id_usuario', auth()->id())
                ->where('id_modulo', $evaluacion->id_modulo)
                ->where('estado', 'completado')
                ->exists();
                
            if (!$progresoAnterior) {
                $xpGanado += 50; // XP bonus por primera vez
                $razon .= " (¡Primera vez!)";
            }
            
            $resultadoGamificacion = $gamificacionController->agregarXP($user, $xpGanado, $razon);
            
            $mensaje = "¡Felicitaciones! 🎉 Has aprobado la evaluación con {$puntuacion}% ({$respuestasCorrectas}/{$totalPreguntas} respuestas correctas). ¡Módulo completado! " . $resultadoGamificacion['mensaje'];
        } else {
            // XP consolación por intentar
            $xpGanado = round($respuestasCorrectas * 10); // 10 XP por respuesta correcta
            $razon = "Evaluación intentada - {$respuestasCorrectas} respuestas correctas";
            
            if ($xpGanado > 0) {
                $resultadoGamificacion = $gamificacionController->agregarXP($user, $xpGanado, $razon);
                $mensajeXP = " " . $resultadoGamificacion['mensaje'];
            } else {
                $mensajeXP = "";
            }
            
            $mensaje = "Sigue intentando 😔 Obtuviste {$puntuacion}% ({$respuestasCorrectas}/{$totalPreguntas} respuestas correctas). Necesitas al menos 70% para aprobar. Revisa el contenido del módulo e inténtalo nuevamente." . $mensajeXP;
        }

        $tipo = $aprobado ? 'success' : 'warning';

        return redirect()->route('modulos.show', $evaluacion->id_modulo)
            ->with($tipo, $mensaje)
            ->with('evaluacion_resultado', [
                'puntuacion' => round($puntuacion, 1),
                'respuestas_correctas' => $respuestasCorrectas,
                'total_preguntas' => $totalPreguntas,
                'aprobado' => $aprobado,
                'xp_ganado' => $xpGanado ?? 0,
            ]);
    }
}
