<?php

namespace Database\Seeders;

use App\Models\Evaluacion;
use App\Models\Modulo;
use Illuminate\Database\Seeder;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulos = Modulo::all();

        foreach ($modulos as $modulo) {
            $preguntas = $this->getPreguntasPorModulo($modulo->nivel);
            
            Evaluacion::create([
                'id_modulo' => $modulo->id_modulo,
                'contenido_eval' => $preguntas
            ]);
        }
    }

    private function getPreguntasPorModulo($nivel)
    {
        $preguntas = [
            1 => [ // Introducción a Linux
                [
                    'pregunta' => '¿Qué significa GNU/Linux?',
                    'opciones' => [
                        'GNU Network Unix/Linux',
                        'GNU is Not Unix/Linux',
                        'General Network Unix/Linux',
                        'Global Network Unix/Linux'
                    ],
                    'respuesta_correcta' => 1
                ],
                [
                    'pregunta' => '¿Cuál es una distribución popular de Linux?',
                    'opciones' => ['Windows', 'Ubuntu', 'macOS', 'MS-DOS'],
                    'respuesta_correcta' => 1
                ]
            ],
            2 => [ // Navegación por el Sistema de Archivos
                [
                    'pregunta' => '¿Qué comando se usa para listar archivos?',
                    'opciones' => ['list', 'ls', 'dir', 'show'],
                    'respuesta_correcta' => 1
                ],
                [
                    'pregunta' => '¿Cómo cambias de directorio?',
                    'opciones' => ['cd', 'chdir', 'change', 'mv'],
                    'respuesta_correcta' => 0
                ]
            ],
            3 => [ // Permisos y Usuarios
                [
                    'pregunta' => '¿Qué comando cambia permisos de archivos?',
                    'opciones' => ['chown', 'chmod', 'chgrp', 'perm'],
                    'respuesta_correcta' => 1
                ]
            ],
            4 => [ // Procesos y Servicios
                [
                    'pregunta' => '¿Qué comando muestra procesos en ejecución?',
                    'opciones' => ['proc', 'ps', 'process', 'show'],
                    'respuesta_correcta' => 1
                ]
            ],
            5 => [ // Redes en Linux
                [
                    'pregunta' => '¿Qué comando verifica la conectividad de red?',
                    'opciones' => ['ping', 'net', 'connect', 'test'],
                    'respuesta_correcta' => 0
                ]
            ]
        ];

        return $preguntas[$nivel] ?? [];
    }
}
