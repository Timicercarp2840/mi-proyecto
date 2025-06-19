<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DesafioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $desafios = [
            // Nivel 1 - Terminal Básico
            [
                'nivel' => 1,
                'titulo' => 'Explorador de directorios',
                'descripcion' => 'Usa el comando ls para listar el contenido del directorio actual',
                'tipo' => 'terminal',
                'criterios_validacion' => json_encode(['comando' => 'ls']),
                'xp_recompensa' => 25,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Navegando por el sistema',
                'descripcion' => 'Usa pwd para saber en qué directorio te encuentras',
                'tipo' => 'terminal',
                'criterios_validacion' => json_encode(['comando' => 'pwd']),
                'xp_recompensa' => 20,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Creando directorios',
                'descripcion' => 'Crea un directorio llamado "mi_proyecto" usando mkdir',
                'tipo' => 'terminal',
                'criterios_validacion' => json_encode(['comando' => 'mkdir mi_proyecto']),
                'xp_recompensa' => 30,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Moviéndose por directorios',
                'descripcion' => 'Cambia al directorio "mi_proyecto" que acabas de crear',
                'tipo' => 'terminal',
                'criterios_validacion' => json_encode(['comando' => 'cd mi_proyecto']),
                'xp_recompensa' => 25,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Creando archivos',
                'descripcion' => 'Crea un archivo vacío llamado "readme.txt" usando touch',
                'tipo' => 'terminal',
                'criterios_validacion' => json_encode(['comando' => 'touch readme.txt']),
                'xp_recompensa' => 30,
                'activo' => true
            ],
            
            // Nivel 2 - Sistema de Archivos
            [
                'nivel' => 2,
                'titulo' => 'Navegación avanzada',
                'descripcion' => 'Navega hasta el directorio /home/usuario/documentos',
                'tipo' => 'filesystem',
                'criterios_validacion' => json_encode(['tipo' => 'navegacion', 'objetivo' => '/home/usuario/documentos']),
                'xp_recompensa' => 40,
                'activo' => true
            ],
            [
                'nivel' => 2,
                'titulo' => 'Copiando archivos',
                'descripcion' => 'Copia el archivo config.txt al directorio backup/',
                'tipo' => 'filesystem',
                'criterios_validacion' => json_encode(['tipo' => 'copia', 'archivo_origen' => 'config.txt', 'destino' => 'backup/']),
                'xp_recompensa' => 50,
                'activo' => true
            ],
            [
                'nivel' => 2,
                'titulo' => 'Organizando archivos',
                'descripcion' => 'Mueve todos los archivos .log al directorio logs/',
                'tipo' => 'filesystem',
                'criterios_validacion' => json_encode(['tipo' => 'mover', 'patron' => '*.log', 'destino' => 'logs/']),
                'xp_recompensa' => 60,
                'activo' => true
            ],
            [
                'nivel' => 2,
                'titulo' => 'Limpieza del sistema',
                'descripcion' => 'Elimina archivos temporales (.tmp) del directorio actual',
                'tipo' => 'filesystem',
                'criterios_validacion' => json_encode(['tipo' => 'eliminar', 'patron' => '*.tmp']),
                'xp_recompensa' => 45,
                'activo' => true
            ],
            
            // Nivel 3 - Permisos
            [
                'nivel' => 3,
                'titulo' => 'Permisos básicos de archivo',
                'descripcion' => 'Otorga permisos de lectura y escritura al propietario del archivo script.sh',
                'tipo' => 'permisos',
                'criterios_validacion' => json_encode(['archivo' => 'script.sh', 'permisos_objetivo' => '644']),
                'xp_recompensa' => 45,
                'activo' => true
            ],
            [
                'nivel' => 3,
                'titulo' => 'Ejecutando scripts',
                'descripcion' => 'Haz que el archivo backup.sh sea ejecutable para todos',
                'tipo' => 'permisos',
                'criterios_validacion' => json_encode(['archivo' => 'backup.sh', 'permisos_objetivo' => '755']),
                'xp_recompensa' => 50,
                'activo' => true
            ],
            [
                'nivel' => 3,
                'titulo' => 'Seguridad avanzada',
                'descripcion' => 'Configura permisos restrictivos (solo propietario) para el archivo secreto.txt',
                'tipo' => 'permisos',
                'criterios_validacion' => json_encode(['archivo' => 'secreto.txt', 'permisos_objetivo' => '600']),
                'xp_recompensa' => 55,
                'activo' => true
            ],
            [
                'nivel' => 3,
                'titulo' => 'Directorio compartido',
                'descripcion' => 'Configura el directorio compartido/ para acceso completo del grupo',
                'tipo' => 'permisos',
                'criterios_validacion' => json_encode(['archivo' => 'compartido/', 'permisos_objetivo' => '775']),
                'xp_recompensa' => 60,
                'activo' => true
            ],
            
            // Nivel 4 - Procesos
            [
                'nivel' => 4,
                'titulo' => 'Monitor de procesos',
                'descripcion' => 'Lista todos los procesos en ejecución usando ps',
                'tipo' => 'procesos',
                'criterios_validacion' => json_encode(['comando' => 'ps aux']),
                'xp_recompensa' => 50,
                'activo' => true
            ],
            [
                'nivel' => 4,
                'titulo' => 'Proceso en segundo plano',
                'descripcion' => 'Ejecuta un script en segundo plano usando &',
                'tipo' => 'procesos',
                'criterios_validacion' => json_encode(['tipo' => 'background', 'comando_base' => './monitor.sh &']),
                'xp_recompensa' => 65,
                'activo' => true
            ],
            [
                'nivel' => 4,
                'titulo' => 'Terminando procesos',
                'descripcion' => 'Termina un proceso específico usando kill',
                'tipo' => 'procesos',
                'criterios_validacion' => json_encode(['tipo' => 'kill', 'proceso_objetivo' => 'firefox']),
                'xp_recompensa' => 55,
                'activo' => true
            ],
            
            // Nivel 5 - Red
            [
                'nivel' => 5,
                'titulo' => 'Conectividad de red',
                'descripcion' => 'Verifica la conectividad con google.com usando ping',
                'tipo' => 'red',
                'criterios_validacion' => json_encode(['comando' => 'ping -c 4 google.com']),
                'xp_recompensa' => 60,
                'activo' => true
            ],
            [
                'nivel' => 5,
                'titulo' => 'Configuración de red',
                'descripcion' => 'Muestra la configuración de las interfaces de red',
                'tipo' => 'red',
                'criterios_validacion' => json_encode(['comando_alt' => ['ifconfig', 'ip addr']]),
                'xp_recompensa' => 70,
                'activo' => true
            ],
            [
                'nivel' => 5,
                'titulo' => 'Puertos abiertos',
                'descripcion' => 'Lista los puertos abiertos en el sistema',
                'tipo' => 'red',
                'criterios_validacion' => json_encode(['comando_alt' => ['netstat -tuln', 'ss -tuln']]),
                'xp_recompensa' => 75,
                'activo' => true
            ]
        ];

        foreach ($desafios as $desafio) {
            \App\Models\Desafio::create($desafio);
        }
    }
}
