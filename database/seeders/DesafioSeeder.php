<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Desafio;

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
                'titulo' => 'Primer Comando: pwd',
                'descripcion' => 'Aprende a mostrar el directorio actual usando el comando pwd (print working directory).',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'pwd', 'descripcion' => 'Mostrar el directorio actual']
                ],
                'xp_recompensa' => 25,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Listando Archivos: ls',
                'descripcion' => 'Usa el comando ls para ver el contenido de un directorio.',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'ls', 'descripcion' => 'Listar archivos del directorio actual']
                ],
                'xp_recompensa' => 25,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Navegación Básica: cd',
                'descripcion' => 'Aprende a cambiar de directorio usando el comando cd.',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'cd Documents', 'descripcion' => 'Cambiar al directorio Documents'],
                    ['comando' => 'pwd', 'descripcion' => 'Verificar el directorio actual']
                ],
                'xp_recompensa' => 50,
                'activo' => true
            ],
            [
                'nivel' => 1,
                'titulo' => 'Crear Archivo: touch',
                'descripcion' => 'Crea un archivo vacío llamado "readme.txt" usando touch',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'touch readme.txt', 'descripcion' => 'Crear archivo readme.txt']
                ],
                'xp_recompensa' => 30,
                'activo' => true
            ],

            // Nivel 2 - Sistema de Archivos
            [
                'nivel' => 2,
                'titulo' => 'Navegación avanzada',
                'descripcion' => 'Navega hasta el directorio /home/usuario/documentos',
                'tipo' => 'filesystem',
                'criterios_validacion' => [
                    ['tipo' => 'navegacion', 'objetivo' => '/home/usuario/documentos']
                ],
                'xp_recompensa' => 40,
                'activo' => true
            ],
            [
                'nivel' => 2,
                'titulo' => 'Copiando archivos',
                'descripcion' => 'Copia el archivo config.txt al directorio backup/',
                'tipo' => 'filesystem',
                'criterios_validacion' => [
                    ['tipo' => 'copia', 'archivo_origen' => 'config.txt', 'destino' => 'backup/']
                ],
                'xp_recompensa' => 50,
                'activo' => true
            ],
            [
                'nivel' => 2,
                'titulo' => 'Crear Directorio',
                'descripcion' => 'Crea un nuevo directorio llamado "proyectos"',
                'tipo' => 'filesystem',
                'criterios_validacion' => [
                    ['tipo' => 'crear_directorio', 'nombre' => 'proyectos']
                ],
                'xp_recompensa' => 35,
                'activo' => true
            ],

            // Nivel 3 - Permisos
            [
                'nivel' => 3,
                'titulo' => 'Cambiar Permisos: chmod',
                'descripcion' => 'Cambia los permisos del archivo script.sh para hacerlo ejecutable',
                'tipo' => 'permisos',
                'criterios_validacion' => [
                    ['comando' => 'chmod +x script.sh', 'descripcion' => 'Hacer ejecutable script.sh']
                ],
                'xp_recompensa' => 60,
                'activo' => true
            ],
            [
                'nivel' => 3,
                'titulo' => 'Permisos Numéricos',
                'descripcion' => 'Establece permisos 755 en el archivo programa.py',
                'tipo' => 'permisos',
                'criterios_validacion' => [
                    ['comando' => 'chmod 755 programa.py', 'descripcion' => 'Establecer permisos 755']
                ],
                'xp_recompensa' => 70,
                'activo' => true
            ],
            [
                'nivel' => 3,
                'titulo' => 'Cambiar Propietario: chown',
                'descripcion' => 'Cambia el propietario del archivo datos.txt al usuario admin',
                'tipo' => 'permisos',
                'criterios_validacion' => [
                    ['comando' => 'chown admin datos.txt', 'descripcion' => 'Cambiar propietario a admin']
                ],
                'xp_recompensa' => 80,
                'activo' => true
            ],

            // Nivel 4 - Comandos Avanzados
            [
                'nivel' => 4,
                'titulo' => 'Buscar Archivos: find',
                'descripcion' => 'Busca todos los archivos .txt en el directorio actual y subdirectorios',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'find . -name "*.txt"', 'descripcion' => 'Buscar archivos .txt']
                ],
                'xp_recompensa' => 90,
                'activo' => true
            ],
            [
                'nivel' => 4,
                'titulo' => 'Filtrar Contenido: grep',
                'descripcion' => 'Busca la palabra "error" en el archivo log.txt',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'grep "error" log.txt', 'descripcion' => 'Buscar "error" en log.txt']
                ],
                'xp_recompensa' => 85,
                'activo' => true
            ],

            // Desafío Completo
            [
                'nivel' => 5,
                'titulo' => 'Desafío del Archivo Perdido',
                'descripcion' => 'Completa una secuencia de comandos para encontrar y manipular archivos',
                'tipo' => 'terminal',
                'criterios_validacion' => [
                    ['comando' => 'mkdir temp_work', 'descripcion' => 'Crear directorio temporal'],
                    ['comando' => 'touch temp_work/archivo_movido.txt', 'descripcion' => 'Crear archivo en el directorio'],
                    ['comando' => 'ls temp_work/', 'descripcion' => 'Verificar contenido del directorio'],
                    ['comando' => 'rm -r temp_work', 'descripcion' => 'Eliminar directorio y contenido']
                ],
                'xp_recompensa' => 125,
                'activo' => true
            ]
        ];

        // Procesar criterios de validación para JSON
        foreach ($desafios as &$desafio) {
            if (isset($desafio['criterios_validacion']) && is_array($desafio['criterios_validacion'])) {
                $desafio['criterios_validacion'] = json_encode($desafio['criterios_validacion']);
            }
        }

        foreach ($desafios as $desafio) {
            Desafio::updateOrCreate(
                ['titulo' => $desafio['titulo']],
                $desafio
            );
        }
    }
}
