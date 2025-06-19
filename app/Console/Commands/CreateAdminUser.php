<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class CreateAdminUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create 
                            {--email= : Email del administrador}
                            {--password= : Contraseña del administrador}
                            {--name= : Nombre del administrador}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Crear un usuario administrador';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->option('email') ?: $this->ask('Email del administrador');
        $password = $this->option('password') ?: $this->secret('Contraseña del administrador');
        $name = $this->option('name') ?: $this->ask('Nombre del administrador');

        // Validar datos
        $validator = Validator::make([
            'email' => $email,
            'password' => $password,
            'name' => $name,
        ], [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }
            return 1;
        }

        // Crear usuario administrador
        $user = User::create([
            'name' => $name,
            'username' => strtolower(str_replace(' ', '', $name)),
            'email' => $email,
            'password' => Hash::make($password),
            'rol' => 'administrador',
            'phone' => '000-0000',
            'email_verified_at' => now(),
        ]);

        $this->info('✅ Usuario administrador creado exitosamente:');
        $this->line("📧 Email: {$user->email}");
        $this->line("👤 Nombre: {$user->name}");
        $this->line("🔑 Rol: {$user->rol}");

        return 0;
    }
}
