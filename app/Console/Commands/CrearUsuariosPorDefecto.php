<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class CrearUsuariosPorDefecto extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuarios:crear-defecto {--force : Forzar recreación de usuarios}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear usuarios por defecto (admin y estudiante) si no existen';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🔄 Creando usuarios por defecto...');
        
        $force = $this->option('force');
        
        // Crear/actualizar admin
        $this->createAdmin($force);
        
        // Crear/actualizar estudiante
        $this->createStudent($force);
        
        // Mostrar resumen
        $this->showSummary();
        
        return 0;
    }
    
    private function createAdmin($force = false)
    {
        $this->line('');
        $this->info('👑 Procesando usuario ADMINISTRADOR...');
        
        if ($force) {
            User::where('email', 'admin@sable.com')->delete();
            $this->warn('🗑️ Usuario admin existente eliminado (modo force)');
        }
        
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
            $this->info('✅ Usuario ADMINISTRADOR creado exitosamente');
        } else {
            $this->info('🔄 Usuario ADMINISTRADOR actualizado');
        }
        
        $this->line("   📧 Email: admin@sable.com");
        $this->line("   🔑 Password: admin123");
        $this->line("   👑 Rol: administrador");
        $this->line("   🆔 ID: {$admin->id}");
    }
    
    private function createStudent($force = false)
    {
        $this->line('');
        $this->info('🎓 Procesando usuario ESTUDIANTE...');
        
        if ($force) {
            User::where('email', 'estudiante@sable.com')->delete();
            $this->warn('🗑️ Usuario estudiante existente eliminado (modo force)');
        }
        
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
            $this->info('✅ Usuario ESTUDIANTE creado exitosamente');
        } else {
            $this->info('🔄 Usuario ESTUDIANTE actualizado');
        }
        
        $this->line("   📧 Email: estudiante@sable.com");
        $this->line("   🔑 Password: estudiante123");
        $this->line("   🎓 Rol: estudiante");
        $this->line("   🆔 ID: {$estudiante->id}");
    }
    
    private function showSummary()
    {
        $this->line('');
        $this->info('📊 RESUMEN DE USUARIOS POR DEFECTO:');
        
        $admin = User::where('email', 'admin@sable.com')->first();
        $estudiante = User::where('email', 'estudiante@sable.com')->first();
          if ($admin) {
            $this->line("✅ Admin: {$admin->email} (ID: {$admin->id})");
            
            // Verificar password
            if (Hash::check('admin123', $admin->password)) {
                $this->line("   🔐 Password verificado: ✅");
            } else {
                $this->error("   🔐 Password verificado: ❌");
            }
        } else {
            $this->error("❌ Admin: NO ENCONTRADO");
        }
          if ($estudiante) {
            $this->line("✅ Estudiante: {$estudiante->email} (ID: {$estudiante->id})");
            
            // Verificar password
            if (Hash::check('estudiante123', $estudiante->password)) {
                $this->line("   🔐 Password verificado: ✅");
            } else {
                $this->error("   🔐 Password verificado: ❌");
            }
        } else {
            $this->error("❌ Estudiante: NO ENCONTRADO");
        }
        
        $totalUsers = User::count();
        $this->line('');
        $this->info("📋 Total de usuarios en base de datos: {$totalUsers}");
        
        if ($admin && $estudiante) {
            $this->info('🎉 Usuarios por defecto configurados correctamente!');
            $this->line('');
            $this->comment('💡 Puedes usar estas credenciales para hacer login:');
            $this->comment('   👑 Admin: admin@sable.com / admin123');
            $this->comment('   🎓 Estudiante: estudiante@sable.com / estudiante123');
        } else {
            $this->error('❌ Hay problemas con la configuración de usuarios por defecto');
        }
    }
}
