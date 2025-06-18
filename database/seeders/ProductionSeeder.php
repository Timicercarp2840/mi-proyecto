<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        User::firstOrCreate(
            ['email' => 'admin@sable.edu'],
            [
                'name' => 'Administrador SABLE',
                'username' => 'admin',
                'email' => 'admin@sable.edu',
                'password' => Hash::make('admin123'),
                'rol' => 'administrador',
                'phone' => '555-0000',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Usuario administrador creado correctamente.');
        $this->command->info('Email: admin@sable.edu');
        $this->command->info('Password: admin123');
    }
}Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
    }
}
