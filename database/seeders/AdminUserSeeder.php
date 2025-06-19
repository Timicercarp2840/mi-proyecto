<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        echo "\n🔄 ========== INICIANDO ADMIN USER SEEDER ==========\n";
        
        try {
            // Verificar que la tabla existe
            echo "🔍 Verificando tabla users...\n";
            $tableExists = DB::getSchemaBuilder()->hasTable('users');
            if (!$tableExists) {
                echo "❌ Error: La tabla 'users' no existe!\n";
                return;
            }
            echo "✅ Tabla users encontrada\n";

            // Mostrar estado inicial
            $initialCount = User::count();
            echo "📊 Usuarios existentes antes del seeding: {$initialCount}\n";

            // Crear usuario administrador
            echo "\n👤 Creando usuario ADMINISTRADOR...\n";
            $admin = User::updateOrCreate(
                ['email' => 'admin@sable.com'],
                [
                    'name' => 'Administrador SABLE',
                    'email' => 'admin@sable.com',
                    'password' => Hash::make('admin123'),
                    'rol' => 'administrador',
                    'email_verified_at' => now(),
                ]
            );

            if ($admin->wasRecentlyCreated) {
                echo "✅ Usuario ADMINISTRADOR creado exitosamente!\n";
            } else {
                echo "🔄 Usuario ADMINISTRADOR actualizado!\n";
            }
            echo "   📧 Email: admin@sable.com\n";
            echo "   🔑 Password: admin123\n";
            echo "   👑 Rol: administrador\n";
            echo "   🆔 ID: {$admin->id}\n";

            // Crear usuario estudiante
            echo "\n🎓 Creando usuario ESTUDIANTE...\n";
            $estudiante = User::updateOrCreate(
                ['email' => 'estudiante@sable.com'],
                [
                    'name' => 'Estudiante de Prueba',
                    'email' => 'estudiante@sable.com',
                    'password' => Hash::make('estudiante123'),
                    'rol' => 'estudiante',
                    'email_verified_at' => now(),
                ]
            );

            if ($estudiante->wasRecentlyCreated) {
                echo "✅ Usuario ESTUDIANTE creado exitosamente!\n";
            } else {
                echo "🔄 Usuario ESTUDIANTE actualizado!\n";
            }
            echo "   📧 Email: estudiante@sable.com\n";
            echo "   🔑 Password: estudiante123\n";
            echo "   🎓 Rol: estudiante\n";
            echo "   🆔 ID: {$estudiante->id}\n";

            // Mostrar TODOS los usuarios
            echo "\n📋 ========== TODOS LOS USUARIOS EN BASE DE DATOS ==========\n";
            $allUsers = User::all();
            
            if ($allUsers->isEmpty()) {
                echo "❌ ¡ERROR! No hay usuarios en la base de datos después del seeding\n";
            } else {
                foreach ($allUsers as $user) {                    echo sprintf(
                        "   🔹 ID: %s | 📧 %s | 👤 %s | 🏷️  %s | ✅ %s\n", 
                        $user->id, 
                        $user->email, 
                        $user->name, 
                        $user->rol,
                        $user->email_verified_at ? 'Verificado' : 'No verificado'
                    );
                }
                echo "   📊 Total usuarios: " . $allUsers->count() . "\n";
            }

            // Verificación específica de usuarios por defecto
            echo "\n🎯 ========== VERIFICACIÓN USUARIOS POR DEFECTO ==========\n";
            
            $adminCheck = User::where('email', 'admin@sable.com')->first();            if ($adminCheck) {
                echo "✅ ADMIN CONFIRMADO: {$adminCheck->email} (ID: {$adminCheck->id})\n";
                // Test de autenticación
                if (Hash::check('admin123', $adminCheck->password)) {
                    echo "✅ Password de admin es CORRECTO\n";
                } else {
                    echo "❌ Password de admin es INCORRECTO\n";
                }
            } else {
                echo "❌ ADMIN NO ENCONTRADO!\n";
            }
            
            $estudianteCheck = User::where('email', 'estudiante@sable.com')->first();            if ($estudianteCheck) {
                echo "✅ ESTUDIANTE CONFIRMADO: {$estudianteCheck->email} (ID: {$estudianteCheck->id})\n";
                // Test de autenticación
                if (Hash::check('estudiante123', $estudianteCheck->password)) {
                    echo "✅ Password de estudiante es CORRECTO\n";
                } else {
                    echo "❌ Password de estudiante es INCORRECTO\n";
                }
            } else {
                echo "❌ ESTUDIANTE NO ENCONTRADO!\n";
            }
            
            echo "\n🎉 ========== ADMIN USER SEEDER COMPLETADO ==========\n\n";
            
        } catch (\Exception $e) {
            echo "❌ ERROR en AdminUserSeeder: " . $e->getMessage() . "\n";
            echo "📍 Archivo: " . $e->getFile() . "\n";
            echo "📍 Línea: " . $e->getLine() . "\n";
            throw $e;
        }
    }
}
