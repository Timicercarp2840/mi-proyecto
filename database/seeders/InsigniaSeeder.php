<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Insignia;

class InsigniaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $insignias = [
            // Nivel 1: Introducción a Linux
            [
                'nombre' => 'Novato Pingüino',
                'descripcion' => 'Completaste tu primer módulo en el Boot Camp de Iniciación Pingüino',
                'icono' => '🐧',
                'color' => '#3b82f6',
                'xp_requerido' => 0,
                'nivel_modulo' => 1,
                'tipo' => 'nivel'
            ],
            [
                'nombre' => 'Ejecutor de Comandos',
                'descripcion' => 'Ejecutaste tu primer comando en la terminal',
                'icono' => '⚡',
                'color' => '#fbbf24',
                'xp_requerido' => 50,
                'nivel_modulo' => 1,
                'tipo' => 'logro'
            ],
            
            // Nivel 2: Navegación por el Sistema de Archivos
            [
                'nombre' => 'Navegante Experto',
                'descripcion' => 'Dominaste la navegación por el sistema de archivos Linux',
                'icono' => '🧭',
                'color' => '#10b981',
                'xp_requerido' => 200,
                'nivel_modulo' => 2,
                'tipo' => 'nivel'
            ],
            [
                'nombre' => 'Explorador del Laberinto',
                'descripcion' => 'Encontraste todos los archivos ocultos en la expedición',
                'icono' => '🗺️',
                'color' => '#8b5cf6',
                'xp_requerido' => 150,
                'nivel_modulo' => 2,
                'tipo' => 'logro'
            ],
            
            // Nivel 3: Permisos y Usuarios
            [
                'nombre' => 'Maestro de Permisos',
                'descripcion' => 'Completaste todos los desafíos del Control de Acceso del Centinela',
                'icono' => '🛡️',
                'color' => '#ef4444',
                'xp_requerido' => 400,
                'nivel_modulo' => 3,
                'tipo' => 'nivel'
            ],
            [
                'nombre' => 'Guardián del Sistema',
                'descripcion' => 'Resolviste todos los problemas de permisos como un verdadero guardián',
                'icono' => '🔐',
                'color' => '#f59e0b',
                'xp_requerido' => 350,
                'nivel_modulo' => 3,
                'tipo' => 'logro'
            ],
            
            // Nivel 4: Procesos y Servicios
            [
                'nombre' => 'Doctor del Sistema',
                'descripcion' => 'Dominaste la gestión de procesos y servicios como un verdadero doctor',
                'icono' => '⚕️',
                'color' => '#06b6d4',
                'xp_requerido' => 600,
                'nivel_modulo' => 4,
                'tipo' => 'nivel'
            ],
            [
                'nombre' => 'Cazador de Procesos',
                'descripcion' => 'Eliminaste todos los procesos malignos de la simulación',
                'icono' => '🎯',
                'color' => '#dc2626',
                'xp_requerido' => 500,
                'nivel_modulo' => 4,
                'tipo' => 'logro'
            ],
            [
                'nombre' => 'Optimizador Experto',
                'descripcion' => 'Optimizaste el sistema como un verdadero experto',
                'icono' => '⚡',
                'color' => '#16a34a',
                'xp_requerido' => 550,
                'nivel_modulo' => 4,
                'tipo' => 'logro'
            ],
            
            // Nivel 5: Redes en Linux
            [
                'nombre' => 'Maestro de Redes',
                'descripcion' => 'Te convertiste en un verdadero Arquitecto de Redes Linux',
                'icono' => '🌐',
                'color' => '#7c3aed',
                'xp_requerido' => 800,
                'nivel_modulo' => 5,
                'tipo' => 'nivel'
            ],
            [
                'nombre' => 'Conector del Mundo',
                'descripcion' => 'Conectaste el mundo Linux con tus habilidades de red',
                'icono' => '🔗',
                'color' => '#0d9488',
                'xp_requerido' => 750,
                'nivel_modulo' => 5,
                'tipo' => 'logro'
            ],
            
            // Insignias Especiales
            [
                'nombre' => 'Administrador Linux Certificado',
                'descripcion' => 'Completaste todos los módulos y te certificaste como Administrador Linux',
                'icono' => '👑',
                'color' => '#facc15',
                'xp_requerido' => 1000,
                'nivel_modulo' => null,
                'tipo' => 'especial'
            ],
            [
                'nombre' => 'Leyenda del Terminal',
                'descripcion' => 'Acumulaste más de 2000 XP dominando Linux',
                'icono' => '⭐',
                'color' => '#f97316',
                'xp_requerido' => 2000,
                'nivel_modulo' => null,
                'tipo' => 'especial'
            ]
        ];

        foreach ($insignias as $insignia) {
            Insignia::create($insignia);
        }
    }
}
