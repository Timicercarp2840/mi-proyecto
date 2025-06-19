<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;

class MostrarUsuarios extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuarios:mostrar';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Mostrar todos los usuarios en la base de datos';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('=== USUARIOS EN BASE DE DATOS ===');
        
        $users = User::all();
        
        if ($users->isEmpty()) {
            $this->warn('⚠️ No hay usuarios en la base de datos');
            return;
        }
          $this->table(
            ['ID', 'Nombre', 'Email', 'Rol', 'Verificado', 'Creado'],
            $users->map(function ($user) {
                return [
                    $user->id,
                    $user->name,
                    $user->email,
                    $user->rol,
                    $user->email_verified_at ? '✅' : '❌',
                    $user->created_at->format('Y-m-d H:i')
                ];
            })
        );
        
        $this->info("Total usuarios: {$users->count()}");
        
        // Mostrar usuarios por defecto específicamente
        $this->line('');
        $this->info('=== VERIFICACIÓN USUARIOS POR DEFECTO ===');
        
        $admin = User::where('email', 'admin@sable.com')->first();
        if ($admin) {
            $this->info("✅ Admin encontrado: {$admin->email} (Rol: {$admin->rol})");
        } else {
            $this->warn("❌ Usuario admin@sable.com NO encontrado");
        }
        
        $estudiante = User::where('email', 'estudiante@sable.com')->first();
        if ($estudiante) {
            $this->info("✅ Estudiante encontrado: {$estudiante->email} (Rol: {$estudiante->rol})");
        } else {
            $this->warn("❌ Usuario estudiante@sable.com NO encontrado");
        }
        
        return 0;
    }
}
