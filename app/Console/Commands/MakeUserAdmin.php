<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class MakeUserAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:make-admin {email : Email del usuario}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Convertir un usuario existente en administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');

        $user = User::where('email', $email)->first();

        if (!$user) {
            $this->error("❌ No se encontró un usuario con el email: {$email}");
            return 1;
        }

        $user->update(['rol' => 'administrador']);

        $this->info('✅ Usuario convertido a administrador exitosamente:');
        $this->line("📧 Email: {$user->email}");
        $this->line("👤 Nombre: {$user->name}");
        $this->line("🔑 Nuevo rol: {$user->rol}");

        return 0;
    }
}
