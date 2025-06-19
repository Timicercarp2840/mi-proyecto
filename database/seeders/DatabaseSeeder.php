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
        try {
            // Ejecutar seeders en orden específico
            $this->command->info('Seeding modules...');
            $this->call(ModuloSeeder::class);
            
            $this->command->info('Seeding insignias...');
            $this->call(InsigniaSeeder::class);
            
            $this->command->info('Seeding desafios...');
            $this->call(DesafioSeeder::class);
            
            $this->command->info('Seeding evaluaciones...');
            $this->call(EvaluacionSeeder::class);
            
            $this->command->info('Creating admin user and demo data...');
            $this->call(ProductionSeeder::class);
            
            $this->command->info('Database seeding completed successfully!');
        } catch (\Exception $e) {
            $this->command->error('Error during seeding: ' . $e->getMessage());
            throw $e;
        }
    }
}
