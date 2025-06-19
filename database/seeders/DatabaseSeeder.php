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
        echo "🌱 Iniciando seeding de la base de datos...\n\n";
        
        // Ejecutar seeders en orden
        $this->call([
            AdminUserSeeder::class,    // Usuarios por defecto
            ModuloSeeder::class,       // Módulos de aprendizaje
            EvaluacionSeeder::class,   // Evaluaciones
            DesafioSeeder::class,      // Desafíos
        ]);
        
        echo "🎉 Seeding completado exitosamente!\n";
    }
}
