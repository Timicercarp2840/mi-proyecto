<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Desafio;
use App\Models\ComandoEnviado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DesafioController extends Controller
{    /**
     * Terminal interactivo con niveles
     */
    public function terminalInteractivo($nivel = 'basico')
    {
        $user = Auth::user();
        
        $desafiosPorNivel = [
            'basico' => [
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
            ],
            'intermedio' => [
                [
                    'id' => 4,
                    'titulo' => 'Copiando archivos',
                    'descripcion' => 'Copia un archivo usando cp archivo.txt copia.txt',
                    'comando_esperado' => 'cp archivo.txt copia.txt',
                    'pista' => 'cp [origen] [destino] copia archivos',
                    'xp_recompensa' => 40,
                    'completado' => false
                ],
                [
                    'id' => 5,
                    'titulo' => 'Pipes y filtros',
                    'descripcion' => 'Lista archivos y cuenta las líneas usando ls | wc -l',
                    'comando_esperado' => 'ls | wc -l',
                    'pista' => 'El pipe | conecta la salida de un comando con la entrada del siguiente',
                    'xp_recompensa' => 50,
                    'completado' => false
                ],
            ],
            'avanzado' => [
                [
                    'id' => 6,
                    'titulo' => 'Búsqueda avanzada',
                    'descripcion' => 'Encuentra archivos .txt usando find . -name "*.txt"',
                    'comando_esperado' => 'find . -name "*.txt"',
                    'pista' => 'find busca archivos según criterios específicos',
                    'xp_recompensa' => 75,
                    'completado' => false
                ],
                [
                    'id' => 7,
                    'titulo' => 'Comandos en background',
                    'descripcion' => 'Ejecuta un comando en segundo plano agregando &',
                    'comando_esperado' => 'sleep 10 &',
                    'pista' => 'El & al final ejecuta el comando en background',
                    'xp_recompensa' => 80,
                    'completado' => false
                ],
            ]
        ];
        
        $desafios = $desafiosPorNivel[$nivel] ?? $desafiosPorNivel['basico'];
        
        return Inertia::render('Desafios/TerminalInteractivo', [
            'desafios' => $desafios,
            'nivel' => ucfirst($nivel),
            'usuario' => $user
        ]);
    }    
    /**
     * Método legacy para compatibilidad
     */
    public function terminalNivel1()
    {
        return $this->terminalInteractivo('basico');
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
            4 => 'cp archivo.txt copia.txt',
            5 => 'ls | wc -l',
            6 => 'find . -name "*.txt"',
            7 => 'sleep 10 &'
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
            // Otorgar XP según el nivel del desafío
            $xpRecompensa = [
                1 => 25, 2 => 20, 3 => 30, 4 => 40, 5 => 50, 6 => 75, 7 => 80
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
     * Desafíos de sistema de archivos con niveles
     */
    public function desafiosFilesystem($nivel = 'basico')
    {
        $desafiosPorNivel = [
            'basico' => [
                [
                    'id' => 'fs1',
                    'titulo' => 'Navegación básica',
                    'descripcion' => 'Navega hasta el directorio home usando cd',
                    'tipo' => 'navegacion',
                    'objetivo' => '/home',
                    'xp_recompensa' => 30
                ],
                [
                    'id' => 'fs2',
                    'titulo' => 'Crear directorios',
                    'descripcion' => 'Crea una estructura de directorios proyecto/src/',
                    'tipo' => 'crear',
                    'estructura' => 'proyecto/src/',
                    'xp_recompensa' => 35
                ]
            ],
            'intermedio' => [
                [
                    'id' => 'fs3',
                    'titulo' => 'Copiando archivos',
                    'descripcion' => 'Copia el archivo config.txt al directorio backup/',
                    'tipo' => 'copia',
                    'archivo_origen' => 'config.txt',
                    'destino' => 'backup/',
                    'xp_recompensa' => 50
                ],
                [
                    'id' => 'fs4',
                    'titulo' => 'Organizando archivos',
                    'descripcion' => 'Mueve todos los archivos .log al directorio logs/',
                    'tipo' => 'mover',
                    'patron' => '*.log',
                    'destino' => 'logs/',
                    'xp_recompensa' => 60
                ]
            ],
            'avanzado' => [
                [
                    'id' => 'fs5',
                    'titulo' => 'Links simbólicos',
                    'descripcion' => 'Crea un enlace simbólico de config.txt en /tmp/',
                    'tipo' => 'symlink',
                    'origen' => 'config.txt',
                    'destino' => '/tmp/config_link',
                    'xp_recompensa' => 80
                ],
                [
                    'id' => 'fs6',
                    'titulo' => 'Búsqueda avanzada',
                    'descripcion' => 'Encuentra archivos modificados en las últimas 24 horas',
                    'tipo' => 'busqueda',
                    'criterio' => '-mtime -1',
                    'xp_recompensa' => 90
                ]
            ]
        ];
        
        $desafios = $desafiosPorNivel[$nivel] ?? $desafiosPorNivel['basico'];
        
        return Inertia::render('Desafios/Filesystem', [
            'desafios' => $desafios,
            'nivel' => ucfirst($nivel)
        ]);
    }
    
    /**
     * Desafíos de permisos con niveles
     */
    public function desafiosPermisos($nivel = 'basico')
    {
        $desafiosPorNivel = [
            'basico' => [
                [
                    'id' => 'perm1',
                    'titulo' => 'Permisos básicos de lectura/escritura',
                    'descripcion' => 'Otorga permisos de lectura y escritura al propietario del archivo script.sh',
                    'tipo' => 'chmod',
                    'archivo' => 'script.sh',
                    'permisos_objetivo' => '644',
                    'xp_recompensa' => 35
                ],
                [
                    'id' => 'perm2',
                    'titulo' => 'Hacer archivo ejecutable',
                    'descripcion' => 'Haz que el archivo backup.sh sea ejecutable para el propietario',
                    'tipo' => 'chmod',
                    'archivo' => 'backup.sh',
                    'permisos_objetivo' => '744',
                    'xp_recompensa' => 40
                ]
            ],
            'intermedio' => [
                [
                    'id' => 'perm3',
                    'titulo' => 'Permisos de grupo',
                    'descripcion' => 'Configura permisos para que el grupo pueda leer y escribir',
                    'tipo' => 'chmod',
                    'archivo' => 'shared.txt',
                    'permisos_objetivo' => '664',
                    'xp_recompensa' => 55
                ],
                [
                    'id' => 'perm4',
                    'titulo' => 'Cambiar propietario',
                    'descripcion' => 'Cambia el propietario del archivo datos.txt',
                    'tipo' => 'chown',
                    'archivo' => 'datos.txt',
                    'nuevo_propietario' => 'admin',
                    'xp_recompensa' => 60
                ]
            ],
            'avanzado' => [
                [
                    'id' => 'perm5',
                    'titulo' => 'Permisos especiales SUID',
                    'descripcion' => 'Aplica el bit SUID a un programa ejecutable',
                    'tipo' => 'chmod',
                    'archivo' => 'programa.bin',
                    'permisos_objetivo' => '4755',
                    'xp_recompensa' => 100
                ],
                [
                    'id' => 'perm6',
                    'titulo' => 'ACLs avanzadas',
                    'descripcion' => 'Configura ACLs para acceso granular de usuarios',
                    'tipo' => 'setfacl',
                    'archivo' => 'confidencial.txt',
                    'acl' => 'u:guest:r--',
                    'xp_recompensa' => 120
                ]
            ]
        ];
        
        $desafios = $desafiosPorNivel[$nivel] ?? $desafiosPorNivel['basico'];
        
        return Inertia::render('Desafios/Permisos', [
            'desafios' => $desafios,
            'nivel' => ucfirst($nivel)
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
    {        // Return updated filesystem state
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

    /**
     * Procesar comandos de la mini terminal de práctica
     */
    public function procesarComandoMiniTerminal(Request $request)
    {
        $comando = trim($request->input('comando'));
        
        // Comandos básicos simulados
        $respuestas = [
            'ls' => "archivo1.txt  archivo2.txt  documentos/  imagenes/  scripts/",
            'pwd' => "/home/student",
            'whoami' => "student",
            'date' => date('D M j H:i:s T Y'),
            'uptime' => "up 2 days, 4:32, 1 user, load average: 0.15, 0.12, 0.08",
            'uname' => "Linux",
            'uname -a' => "Linux sable-system 5.15.0 #1 SMP Ubuntu x86_64 GNU/Linux",
            'id' => "uid=1000(student) gid=1000(student) groups=1000(student)",
            'groups' => "student",
        ];

        // Manejar comandos echo
        if (preg_match('/^echo\s+(.+)/', $comando, $matches)) {
            $mensaje = trim($matches[1], '"\'');
            return response()->json([
                'success' => true,
                'output' => $mensaje
            ]);
        }

        // Manejar comandos mkdir
        if (preg_match('/^mkdir\s+(.+)/', $comando, $matches)) {
            $directorio = trim($matches[1]);
            return response()->json([
                'success' => true,
                'output' => "Directorio '$directorio' creado (simulado)"
            ]);
        }

        // Manejar comandos touch
        if (preg_match('/^touch\s+(.+)/', $comando, $matches)) {
            $archivo = trim($matches[1]);
            return response()->json([
                'success' => true,
                'output' => "Archivo '$archivo' creado (simulado)"
            ]);
        }

        // Manejar comandos cat
        if (preg_match('/^cat\s+(.+)/', $comando, $matches)) {
            $archivo = trim($matches[1]);
            return response()->json([
                'success' => true,
                'output' => "Contenido del archivo '$archivo' (simulado):\nEste es un archivo de ejemplo."
            ]);
        }

        // Manejar comandos cd
        if (preg_match('/^cd\s*(.*)/', $comando, $matches)) {
            $directorio = trim($matches[1]);
            if (empty($directorio) || $directorio === '~') {
                return response()->json([
                    'success' => true,
                    'output' => "Cambiado al directorio home (simulado)"
                ]);
            } else {
                return response()->json([
                    'success' => true,
                    'output' => "Cambiado al directorio '$directorio' (simulado)"
                ]);
            }
        }

        // Comando help
        if ($comando === 'help' || $comando === '--help') {
            return response()->json([
                'success' => true,
                'output' => "Comandos disponibles:\nls, pwd, whoami, date, echo, mkdir, touch, cat, cd, help, clear"
            ]);
        }

        // Comando clear
        if ($comando === 'clear') {
            return response()->json([
                'success' => true,
                'output' => '[clear]',
                'clear' => true
            ]);
        }

        // Verificar si el comando existe en las respuestas predefinidas
        if (array_key_exists($comando, $respuestas)) {
            return response()->json([
                'success' => true,
                'output' => $respuestas[$comando]
            ]);
        }

        // Comando no reconocido
        return response()->json([
            'success' => false,
            'output' => "bash: $comando: command not found"
        ]);
    }
}
