<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador si no existe
        User::firstOrCreate(
            ['email' => 'admin@sable.com'],
            [
                'name' => 'Administrador SABLE',
                'email' => 'admin@sable.com',
                'password' => Hash::make('admin123'),
                'rol' => 'administrador',
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario estudiante de prueba si no existe
        User::firstOrCreate(
            ['email' => 'estudiante@sable.com'],
            [
                'name' => 'Estudiante de Prueba',
                'email' => 'estudiante@sable.com',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'email_verified_at' => now(),
            ]
        );
    }
}
