<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ComandoEnviadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear algunos comandos de ejemplo para el muro
        $comandos = [
            [
                'id_usuario' => 1, // Asumiendo que existe un usuario con id 1
                'comando' => 'ls -la',
                'desafio_id' => 1,
                'correcto' => true,
                'enviado_en' => now()->subHours(2)
            ],
            [
                'id_usuario' => 1,
                'comando' => 'pwd',
                'desafio_id' => 2,
                'correcto' => true,
                'enviado_en' => now()->subHours(1)
            ],
            [
                'id_usuario' => 1,
                'comando' => 'mkdir mi_proyecto',
                'desafio_id' => 3,
                'correcto' => true,
                'enviado_en' => now()->subMinutes(30)
            ],
            [
                'id_usuario' => 1,
                'comando' => 'cd mi_proyecto',
                'desafio_id' => 4,
                'correcto' => true,
                'enviado_en' => now()->subMinutes(15)
            ],
            [
                'id_usuario' => 1,
                'comando' => 'touch readme.txt',
                'desafio_id' => 5,
                'correcto' => true,
                'enviado_en' => now()->subMinutes(5)
            ]
        ];

        foreach ($comandos as $comando) {
            \App\Models\ComandoEnviado::create($comando);
        }
    }
}
