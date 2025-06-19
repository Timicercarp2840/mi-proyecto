<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Desafio;
use App\Models\Modulo;
use App\Models\ProgresoDesafio;
use App\Models\Progreso;

class AsignarContenidoExistente extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'usuarios:asignar-contenido {--solo-nuevos : Solo asignar contenido que no tengan}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Asigna módulos y desafíos a todos los usuarios estudiantes existentes';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $soloNuevos = $this->option('solo-nuevos');
        
        $usuarios = User::where('rol', 'estudiante')->get();
        $modulos = Modulo::all();
        $desafios = Desafio::where('activo', true)->get();
        
        $this->info('Iniciando asignación de contenido...');
        $this->info("Usuarios encontrados: {$usuarios->count()}");
        $this->info("Módulos disponibles: {$modulos->count()}");
        $this->info("Desafíos activos: {$desafios->count()}");
        
        $progressBar = $this->output->createProgressBar($usuarios->count());
        $progressBar->start();
        
        foreach ($usuarios as $usuario) {
            // Asignar módulos
            foreach ($modulos as $modulo) {
                if ($soloNuevos) {
                    Progreso::firstOrCreate([
                        'id_usuario' => $usuario->id,
                        'id_modulo' => $modulo->id_modulo
                    ], [
                        'estado' => 'no_iniciado',
                        'puntuacion' => null
                    ]);
                } else {
                    Progreso::updateOrCreate([
                        'id_usuario' => $usuario->id,
                        'id_modulo' => $modulo->id_modulo
                    ], [
                        'estado' => 'no_iniciado',
                        'puntuacion' => null
                    ]);
                }
            }
            
            // Asignar desafíos
            foreach ($desafios as $desafio) {
                if ($soloNuevos) {
                    ProgresoDesafio::firstOrCreate([
                        'id_usuario' => $usuario->id,
                        'id_desafio' => $desafio->id_desafio
                    ], [
                        'completado' => false,
                        'completado_en' => null
                    ]);
                } else {
                    ProgresoDesafio::updateOrCreate([
                        'id_usuario' => $usuario->id,
                        'id_desafio' => $desafio->id_desafio
                    ], [
                        'completado' => false,
                        'completado_en' => null
                    ]);
                }
            }
            
            $progressBar->advance();
        }
        
        $progressBar->finish();
        $this->newLine();
        $this->info('✅ Asignación de contenido completada exitosamente!');
        
        // Mostrar estadísticas
        $totalProgresos = Progreso::count();
        $totalProgresosDesafio = ProgresoDesafio::count();
        
        $this->table(['Tipo', 'Total Asignaciones'], [
            ['Módulos', $totalProgresos],
            ['Desafíos', $totalProgresosDesafio]
        ]);
    }
}
