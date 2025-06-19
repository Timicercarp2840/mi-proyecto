<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Modulo;
use App\Models\Progreso;
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
        $admin = User::firstOrCreate(
            ['email' => 'admin@sable.edu'],
            [
                'name' => 'Administrador SABLE',
                'username' => 'admin',
                'email' => 'admin@sable.edu',
                'password' => Hash::make('administrador123'),
                'rol' => 'administrador',
                'telefono' => '555-0000',
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario estudiante de demostración
        $estudiante = User::firstOrCreate(
            ['email' => 'estudiante@sable.edu'],
            [
                'name' => 'Estudiante Demo',
                'username' => 'estudiante',
                'email' => 'estudiante@sable.edu',
                'password' => Hash::make('estudiante123'),
                'rol' => 'estudiante',
                'telefono' => '555-0001',
                'email_verified_at' => now(),
            ]
        );

        // Asignar módulos a todos los estudiantes existentes
        $this->asignarModulosAEstudiantes();

        $this->command->info('Usuarios creados correctamente:');
        $this->command->info('Admin - Email: admin@sable.edu | Password: administrador123');
        $this->command->info('Estudiante - Email: estudiante@sable.edu | Password: estudiante123');
    }

    /**
     * Asignar todos los módulos a todos los estudiantes
     */
    private function asignarModulosAEstudiantes(): void
    {
        $estudiantes = User::where('rol', 'estudiante')->get();
        $modulos = Modulo::all();

        foreach ($estudiantes as $estudiante) {
            foreach ($modulos as $modulo) {
                Progreso::firstOrCreate([
                    'id_usuario' => $estudiante->id,
                    'id_modulo' => $modulo->id,
                ], [
                    'completado' => false,
                    'fecha_inicio' => now(),
                    'puntuacion' => 0,
                ]);
            }
        }

        $this->command->info('Módulos asignados a ' . $estudiantes->count() . ' estudiantes.');
    }
}
