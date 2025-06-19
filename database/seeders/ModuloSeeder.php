<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Seeder;

class ModuloSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modulos = [
            [
                'nivel' => 1,
                'titulo' => 'Introducción a Linux',
                'descripcion' => 'Conceptos básicos del sistema operativo Linux',
                'contenido' => 'En este módulo aprenderás los conceptos fundamentales de Linux, su historia, distribuciones principales y las ventajas de usar este sistema operativo.'
            ],
            [
                'nivel' => 2,
                'titulo' => 'Navegación por el Sistema de Archivos',
                'descripcion' => 'Aprende a navegar y gestionar archivos en Linux',
                'contenido' => 'Domina los comandos básicos para navegar por el sistema de archivos: ls, cd, pwd, mkdir, rmdir, cp, mv, rm.'
            ],
            [
                'nivel' => 3,
                'titulo' => 'Permisos y Usuarios',
                'descripcion' => 'Gestión de usuarios y permisos en Linux',
                'contenido' => 'Comprende el sistema de permisos de Linux, cómo gestionar usuarios y grupos, y cómo cambiar permisos de archivos y directorios.'
            ],
            [
                'nivel' => 4,
                'titulo' => 'Procesos y Servicios',
                'descripcion' => 'Gestión de procesos y servicios del sistema',
                'contenido' => 'Aprende a monitorear y gestionar procesos, trabajar con servicios del sistema y usar comandos como ps, top, kill, systemctl.'
            ],
            [
                'nivel' => 5,
                'titulo' => 'Redes en Linux',
                'descripcion' => 'Configuración y gestión de redes',
                'contenido' => 'Configuración de interfaces de red, comandos de diagnóstico de red, y herramientas básicas de administración de redes.'
            ]
        ];

        foreach ($modulos as $modulo) {
            Modulo::create($modulo);
        }
    }
}
