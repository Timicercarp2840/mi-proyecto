<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DebugUsuarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuarios:debug';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Debug completo de usuarios para producción';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔍 DEBUG COMPLETO DE USUARIOS');
        $this->line('=====================================');
        
        try {
            // Información de la base de datos
            $this->info('📊 INFORMACIÓN DE BASE DE DATOS:');
            $dbName = DB::connection()->getDatabaseName();
            $this->line("   Database: {$dbName}");
            
            // Verificar que la tabla existe
            $tableExists = DB::getSchemaBuilder()->hasTable('users');
            $this->line("   Tabla 'users' existe: " . ($tableExists ? '✅' : '❌'));
            
            if (!$tableExists) {
                $this->error('❌ La tabla users no existe!');
                return 1;
            }
            
            // Contar usuarios
            $totalUsers = User::count();
            $this->line("   Total usuarios: {$totalUsers}");
            $this->line('');
            
            // Listar TODOS los usuarios con información completa
            $this->info('👥 TODOS LOS USUARIOS:');
            $users = User::all();
            
            if ($users->isEmpty()) {
                $this->warn('⚠️ NO HAY USUARIOS EN LA BASE DE DATOS');
                return 0;
            }
            
            foreach ($users as $user) {
                $this->line("   🔹 ID: {$user->id}");
                $this->line("      📧 Email: {$user->email}");
                $this->line("      👤 Nombre: {$user->name}");
                $this->line("      🏷️  Rol: {$user->rol}");
                $this->line("      ✅ Verificado: " . ($user->email_verified_at ? 'Sí' : 'No'));
                $this->line("      🔐 Password Hash: " . substr($user->password, 0, 20) . '...');
                $this->line("      📅 Creado: {$user->created_at}");
                $this->line('');
            }
            
            // Verificación específica de usuarios por defecto
            $this->info('🎯 VERIFICACIÓN USUARIOS POR DEFECTO:');
            
            // Admin
            $admin = User::where('email', 'admin@sable.com')->first();
            if ($admin) {
                $this->info("✅ ADMIN ENCONTRADO:");
                $this->line("   📧 {$admin->email}");
                $this->line("   🆔 ID: {$admin->id}");
                $this->line("   👑 Rol: {$admin->rol}");
                
                // Test password
                if (Hash::check('admin123', $admin->password)) {
                    $this->info("   🔐 Password 'admin123': ✅ CORRECTO");
                } else {
                    $this->error("   🔐 Password 'admin123': ❌ INCORRECTO");
                }
            } else {
                $this->error("❌ ADMIN (admin@sable.com) NO ENCONTRADO");
            }
            
            // Estudiante
            $estudiante = User::where('email', 'estudiante@sable.com')->first();
            if ($estudiante) {
                $this->info("✅ ESTUDIANTE ENCONTRADO:");
                $this->line("   📧 {$estudiante->email}");
                $this->line("   🆔 ID: {$estudiante->id}");
                $this->line("   🎓 Rol: {$estudiante->rol}");
                
                // Test password
                if (Hash::check('estudiante123', $estudiante->password)) {
                    $this->info("   🔐 Password 'estudiante123': ✅ CORRECTO");
                } else {
                    $this->error("   🔐 Password 'estudiante123': ❌ INCORRECTO");
                }
            } else {
                $this->error("❌ ESTUDIANTE (estudiante@sable.com) NO ENCONTRADO");
            }
            
            // Búsqueda de emails similares
            $this->line('');
            $this->info('🔍 BÚSQUEDA DE EMAILS SIMILARES:');
            $similarEmails = User::where('email', 'like', '%admin%')
                ->orWhere('email', 'like', '%estudiante%')
                ->orWhere('email', 'like', '%sable%')
                ->get();
                
            if ($similarEmails->isNotEmpty()) {
                foreach ($similarEmails as $user) {
                    $this->line("   📧 {$user->email} (ID: {$user->id}, Rol: {$user->rol})");
                }
            } else {
                $this->line("   (Ningún email similar encontrado)");
            }
            
            $this->line('');
            $this->info('✅ Debug completado!');
            
            // Resumen final
            if ($admin && $estudiante) {
                $this->comment('💡 CREDENCIALES PARA LOGIN:');
                $this->comment('   👑 Admin: admin@sable.com / admin123');
                $this->comment('   🎓 Estudiante: estudiante@sable.com / estudiante123');
            } else {
                $this->error('❌ USUARIOS POR DEFECTO NO ESTÁN CONFIGURADOS CORRECTAMENTE');
            }
            
        } catch (\Exception $e) {
            $this->error("❌ ERROR: {$e->getMessage()}");
            $this->error("   Archivo: {$e->getFile()}");
            $this->error("   Línea: {$e->getLine()}");
            return 1;
        }
        
        return 0;
    }
}
