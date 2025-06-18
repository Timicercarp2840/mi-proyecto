<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuario administrador
        User::factory()->create([
            'name' => 'Administrador SABLE',
            'email' => 'admin@sable.edu',
            'rol' => 'administrador',
        ]);

        // Crear usuario estudiante de prueba
        User::factory()->create([
            'name' => 'Estudiante Demo',
            'email' => 'estudiante@sable.edu',
            'rol' => 'estudiante',
        ]);

        // Ejecutar otros seeders
        $this->call([
            ModuloSeeder::class,
            EvaluacionSeeder::class,
        ]);
    }
}
