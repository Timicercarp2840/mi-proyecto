<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Desafio;
use App\Models\ComandoEnviado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DesafioController extends Controller
{
    /**
     * Terminal interactivo para el Nivel 1
     */
    public function terminalNivel1()
    {
        $user = Auth::user();
        
        // Desafíos del Nivel 1 - Comandos básicos
        $desafios = [
            [
                'id' => 1,
                'titulo' => 'Explorador de directorios',
                'descripcion' => 'Usa el comando ls para listar el contenido del directorio actual',
                'comando_esperado' => 'ls',
                'pista' => 'El comando ls (list) muestra los archivos y carpetas en el directorio actual',
                'xp_recompensa' => 25,
                'completado' => false
            ],
            [
                'id' => 2,
                'titulo' => 'Navegando por el sistema',
                'descripcion' => 'Usa pwd para saber en qué directorio te encuentras',
                'comando_esperado' => 'pwd',
                'pista' => 'pwd significa "print working directory" - imprime el directorio de trabajo actual',
                'xp_recompensa' => 20,
                'completado' => false
            ],
            [
                'id' => 3,
                'titulo' => 'Creando directorios',
                'descripcion' => 'Crea un directorio llamado "mi_proyecto" usando mkdir',
                'comando_esperado' => 'mkdir mi_proyecto',
                'pista' => 'mkdir [nombre] crea un nuevo directorio',
                'xp_recompensa' => 30,
                'completado' => false
            ],
            [
                'id' => 4,
                'titulo' => 'Moviéndose por directorios',
                'descripcion' => 'Cambia al directorio "mi_proyecto" que acabas de crear',
                'comando_esperado' => 'cd mi_proyecto',
                'pista' => 'cd [directorio] cambia al directorio especificado',
                'xp_recompensa' => 25,
                'completado' => false
            ],
            [
                'id' => 5,
                'titulo' => 'Creando archivos',
                'descripcion' => 'Crea un archivo vacío llamado "readme.txt" usando touch',
                'comando_esperado' => 'touch readme.txt',
                'pista' => 'touch [archivo] crea un archivo vacío o actualiza la fecha de modificación',
                'xp_recompensa' => 30,
                'completado' => false
            ]
        ];
          // Verificar qué desafíos ha completado el usuario
        $comandosEnviados = ComandoEnviado::where('id_usuario', $user->id)
            ->where('correcto', true)
            ->pluck('comando')
            ->toArray();
            
        foreach ($desafios as &$desafio) {
            $desafio['completado'] = in_array($desafio['comando_esperado'], $comandosEnviados);
        }
        
        return Inertia::render('Desafios/TerminalInteractivo', [
            'desafios' => $desafios,
            'usuario' => $user
        ]);
    }
    
    /**
     * Procesar comando enviado por el usuario
     */
    public function procesarComando(Request $request)
    {
        $request->validate([
            'comando' => 'required|string',
            'desafio_id' => 'required|integer'
        ]);
        
        $user = Auth::user();
        $comando = trim($request->comando);
        $desafioId = $request->desafio_id;
        
        // Definir comandos esperados por desafío
        $comandosEsperados = [
            1 => 'ls',
            2 => 'pwd',
            3 => 'mkdir mi_proyecto',
            4 => 'cd mi_proyecto',
            5 => 'touch readme.txt'
        ];
        
        $comandoEsperado = $comandosEsperados[$desafioId] ?? null;
        $esCorrecto = $comando === $comandoEsperado;
          // Guardar el comando enviado
        ComandoEnviado::create([
            'id_usuario' => $user->id,
            'comando' => $comando,
            'desafio_id' => $desafioId,
            'correcto' => $esCorrecto,
            'enviado_en' => now()
        ]);
        
        if ($esCorrecto) {
            // Otorgar XP
            $xpRecompensa = [
                1 => 25, 2 => 20, 3 => 30, 4 => 25, 5 => 30
            ][$desafioId] ?? 25;
            
            $gamificacionController = new GamificacionController();
            $resultado = $gamificacionController->agregarXP($user, $xpRecompensa, "Completó desafío de terminal");
            
            return response()->json([
                'correcto' => true,
                'mensaje' => '¡Excelente! Comando correcto.',
                'xp_ganado' => $resultado['xp_ganado'],
                'feedback' => $this->obtenerFeedbackComando($comando)
            ]);
        } else {
            return response()->json([
                'correcto' => false,
                'mensaje' => 'Comando incorrecto. ¡Inténtalo de nuevo!',
                'pista' => $this->obtenerPista($desafioId)
            ]);
        }
    }
    
    /**
     * Muro de la Fama de Comandos
     */
    public function muroComandos()
    {
        $comandos = ComandoEnviado::with('usuario')
            ->where('correcto', true)
            ->orderBy('enviado_en', 'desc')
            ->paginate(20);
            
        $estadisticas = [
            'total_comandos' => ComandoEnviado::where('correcto', true)->count(),
            'usuarios_activos' => ComandoEnviado::distinct('id_usuario')->count(),
            'comando_mas_usado' => ComandoEnviado::where('correcto', true)
                ->groupBy('comando')
                ->orderByRaw('COUNT(*) DESC')
                ->pluck('comando')
                ->first()
        ];
        
        return Inertia::render('Desafios/MuroComandos', [
            'comandos' => $comandos,
            'estadisticas' => $estadisticas
        ]);
    }
    
    /**
     * Desafíos del sistema de archivos (Nivel 2)
     */
    public function desafiosFilesystem()
    {
        $desafios = [
            [
                'id' => 'fs1',
                'titulo' => 'Navegación avanzada',
                'descripcion' => 'Navega hasta el directorio /home/usuario/documentos',
                'tipo' => 'navegacion',
                'objetivo' => '/home/usuario/documentos',
                'xp_recompensa' => 40
            ],
            [
                'id' => 'fs2',
                'titulo' => 'Copiando archivos',
                'descripcion' => 'Copia el archivo config.txt al directorio backup/',
                'tipo' => 'copia',
                'archivo_origen' => 'config.txt',
                'destino' => 'backup/',
                'xp_recompensa' => 50
            ],
            [
                'id' => 'fs3',
                'titulo' => 'Organizando archivos',
                'descripcion' => 'Mueve todos los archivos .log al directorio logs/',
                'tipo' => 'mover',
                'patron' => '*.log',
                'destino' => 'logs/',
                'xp_recompensa' => 60
            ]
        ];
        
        return Inertia::render('Desafios/Filesystem', [
            'desafios' => $desafios
        ]);
    }
    
    /**
     * Desafíos de permisos (Nivel 3)
     */
    public function desafiosPermisos()
    {
        $desafios = [
            [
                'id' => 'perm1',
                'titulo' => 'Permisos básicos',
                'descripcion' => 'Otorga permisos de lectura y escritura al propietario del archivo script.sh',
                'tipo' => 'chmod',
                'archivo' => 'script.sh',
                'permisos_objetivo' => '644',
                'xp_recompensa' => 45
            ],
            [
                'id' => 'perm2',
                'titulo' => 'Ejecutando scripts',
                'descripcion' => 'Haz que el archivo backup.sh sea ejecutable para todos',
                'tipo' => 'chmod',
                'archivo' => 'backup.sh',
                'permisos_objetivo' => '755',
                'xp_recompensa' => 50
            ]
        ];
        
        return Inertia::render('Desafios/Permisos', [
            'desafios' => $desafios
        ]);
    }
    
    /**
     * Procesar operación del sistema de archivos
     */
    public function procesarOperacionFilesystem(Request $request)
    {
        $request->validate([
            'desafio_id' => 'required|string',
            'operacion' => 'required|string',
            'parametros' => 'required|array'
        ]);
        
        $user = Auth::user();
        $desafioId = $request->desafio_id;
        $operacion = $request->operacion;
        $parametros = $request->parametros;
        
        // Simulate filesystem operations based on challenge requirements
        $exito = $this->validarOperacionFilesystem($desafioId, $operacion, $parametros);
        
        if ($exito) {
            $xpRecompensa = 50; // Base XP for filesystem operations
            
            $gamificacionController = new GamificacionController();
            $resultado = $gamificacionController->agregarXP($user, $xpRecompensa, "Completó desafío de sistema de archivos");
            
            return response()->json([
                'success' => true,
                'mensaje' => '¡Operación exitosa!',
                'xp_ganado' => $resultado['xp_ganado'],
                'completado' => true,
                'nuevo_estado_fs' => $this->obtenerNuevoEstadoFS($operacion, $parametros)
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mensaje' => 'Operación incorrecta. Revisa los parámetros.'
            ]);
        }
    }
    
    /**
     * Aplicar permisos chmod
     */
    public function aplicarPermisos(Request $request)
    {
        $request->validate([
            'desafio_id' => 'required|string',
            'archivo' => 'required|string',
            'permisos' => 'required|string|size:3',
            'permisos_objetivo' => 'required|string'
        ]);
        
        $user = Auth::user();
        $permisos = $request->permisos;
        $permisosObjetivo = $request->permisos_objetivo;
        
        if ($permisos === $permisosObjetivo) {
            $xpRecompensa = 45; // Base XP for permissions
            
            $gamificacionController = new GamificacionController();
            $resultado = $gamificacionController->agregarXP($user, $xpRecompensa, "Completó desafío de permisos");
            
            return response()->json([
                'success' => true,
                'mensaje' => '¡Permisos aplicados correctamente!',
                'xp_ganado' => $resultado['xp_ganado']
            ]);
        } else {
            return response()->json([
                'success' => false,
                'mensaje' => "Permisos incorrectos. Se esperaba: {$permisosObjetivo}, recibido: {$permisos}"
            ]);
        }
    }
    
    /**
     * Dar like a un comando
     */
    public function darLikeComando($id)
    {
        $user = Auth::user();
        
        // Here you would implement the like system
        // For now, just return success
        return response()->json([
            'success' => true,
            'mensaje' => 'Like agregado'
        ]);
    }
    
    /**
     * Agregar comentario a un comando
     */
    public function agregarComentario(Request $request, $id)
    {
        $request->validate([
            'texto' => 'required|string|max:500'
        ]);
        
        $user = Auth::user();
        
        // Here you would implement the comment system
        // For now, just return success
        return response()->json([
            'success' => true,
            'mensaje' => 'Comentario agregado'
        ]);
    }
    
    /**
     * Obtener feedback personalizado para comandos
     */
    private function obtenerFeedbackComando($comando)
    {
        $feedback = [
            'ls' => 'El comando ls es fundamental para explorar directorios. También puedes usar ls -l para más detalles.',
            'pwd' => 'pwd te ayuda a orientarte en el sistema de archivos. ¡Siempre es bueno saber dónde estás!',
            'mkdir mi_proyecto' => 'mkdir es perfecto para organizar tu trabajo. Recuerda que puedes crear múltiples directorios a la vez.',
            'cd mi_proyecto' => 'cd es tu mejor amigo para navegar. Usa cd .. para retroceder un nivel.',
            'touch readme.txt' => 'touch es útil para crear archivos rápidamente. También actualiza las fechas de archivos existentes.'
        ];
        
        return $feedback[$comando] ?? 'Excelente comando. ¡Sigue practicando!';
    }
    
    /**
     * Obtener pista para un desafío específico
     */
    private function obtenerPista($desafioId)
    {
        $pistas = [
            1 => 'Intenta escribir exactamente: ls',
            2 => 'El comando que necesitas es: pwd',
            3 => 'Usa: mkdir mi_proyecto',
            4 => 'Escribe: cd mi_proyecto',
            5 => 'El comando correcto es: touch readme.txt'
        ];
        
        return $pistas[$desafioId] ?? 'Revisa la descripción del desafío para obtener más pistas.';
    }
    
    /**
     * Validar operación del sistema de archivos
     */
    private function validarOperacionFilesystem($desafioId, $operacion, $parametros)
    {
        // Simulate validation logic based on challenge requirements
        $validaciones = [
            'fs1' => $operacion === 'navegacion' && isset($parametros['destino']),
            'fs2' => $operacion === 'copiar' && isset($parametros['origen']) && isset($parametros['destino']),
            'fs3' => $operacion === 'mover' && isset($parametros['patron']) && isset($parametros['destino'])
        ];
        
        return $validaciones[$desafioId] ?? false;
    }
    
    /**
     * Obtener nuevo estado del sistema de archivos después de operación
     */
    private function obtenerNuevoEstadoFS($operacion, $parametros)
    {
        // Return updated filesystem state
        return [
            'nombre' => 'usuario',
            'tipo' => 'directorio',
            'contenido' => [
                ['nombre' => 'documentos', 'tipo' => 'directorio'],
                ['nombre' => 'backup', 'tipo' => 'directorio'],
                ['nombre' => 'logs', 'tipo' => 'directorio'],
                ['nombre' => 'config.txt', 'tipo' => 'archivo', 'tamaño' => '2KB']
            ]
        ];
    }
}
