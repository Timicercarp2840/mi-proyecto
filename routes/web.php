<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminDesafioController;
use App\Http\Controllers\GamificacionController;
use App\Http\Controllers\DesafioController;
use App\Http\Controllers\DesafioLibreController;
use App\Http\Controllers\PerfilUnificadoController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Nueva ruta unificada de perfil
    Route::get('/mi-perfil-completo', [PerfilUnificadoController::class, 'index'])->name('perfil.unificado');
    
    // Rutas para estudiantes
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos.index');
    Route::get('/modulos/{id_modulo}', [ModuloController::class, 'show'])->name('modulos.show');Route::get('/evaluaciones/{id_eval}/tomar', [EvaluacionController::class, 'tomar'])->name('evaluaciones.tomar');
    Route::post('/evaluaciones/{id_eval}/calificar', [EvaluacionController::class, 'calificar'])->name('evaluaciones.calificar');
    Route::get('/mi-progreso', [ProgresoController::class, 'miProgreso'])->name('progreso.mi-progreso');
    Route::post('/progreso/{id_modulo}', [ProgresoController::class, 'actualizar'])->name('progreso.actualizar');
      // Rutas de gamificación
    Route::get('/leaderboard', [GamificacionController::class, 'leaderboard'])->name('gamificacion.leaderboard');
    Route::get('/mi-perfil-gamer', [GamificacionController::class, 'perfil'])->name('gamificacion.perfil');
    
    // Vista de selección para Desafío Libre
    Route::get('/desafio-libre', [DesafioLibreController::class, 'index'])->name('desafio-libre.index');
    
    // Rutas de desafíos interactivos
    Route::get('/desafios/terminal', [DesafioController::class, 'terminalNivel1'])->name('desafios.terminal');
    Route::get('/desafios/filesystem', [DesafioController::class, 'desafiosFilesystem'])->name('desafios.filesystem');
    Route::get('/desafios/permisos', [DesafioController::class, 'desafiosPermisos'])->name('desafios.permisos');
    Route::get('/muro-comandos', [DesafioController::class, 'muroComandos'])->name('desafios.muro-comandos');
    
    // APIs para desafíos
    Route::post('/api/procesar-comando', [DesafioController::class, 'procesarComando']);
    Route::post('/api/filesystem/operacion', [DesafioController::class, 'procesarOperacionFilesystem']);
    Route::post('/api/permisos/aplicar', [DesafioController::class, 'aplicarPermisos']);
    Route::post('/api/comandos/{id}/like', [DesafioController::class, 'darLikeComando']);
    Route::post('/api/comandos/{id}/comentario', [DesafioController::class, 'agregarComentario']);
});

// Rutas de administración
Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/usuarios', [AdminController::class, 'usuarios'])->name('admin.usuarios');
    Route::get('/modulos', [AdminController::class, 'modulos'])->name('admin.modulos');
    Route::get('/evaluaciones', [AdminController::class, 'evaluaciones'])->name('admin.evaluaciones');
      // CRUD de módulos
    Route::get('/modulos/crear', [ModuloController::class, 'create'])->name('admin.modulos.create');
    Route::post('/modulos', [ModuloController::class, 'store'])->name('admin.modulos.store');
    Route::get('/modulos/{id_modulo}/editar', [ModuloController::class, 'edit'])->name('admin.modulos.edit');
    Route::put('/modulos/{id_modulo}', [ModuloController::class, 'update'])->name('admin.modulos.update');
    Route::delete('/modulos/{id_modulo}', [ModuloController::class, 'destroy'])->name('admin.modulos.destroy');
      // CRUD de evaluaciones
    Route::get('/evaluaciones/crear', [EvaluacionController::class, 'create'])->name('admin.evaluaciones.create');
    Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('admin.evaluaciones.store');
    Route::get('/evaluaciones/{id_eval}/editar', [EvaluacionController::class, 'edit'])->name('admin.evaluaciones.edit');
    Route::put('/evaluaciones/{id_eval}', [EvaluacionController::class, 'update'])->name('admin.evaluaciones.update');
    Route::delete('/evaluaciones/{id_eval}', [EvaluacionController::class, 'destroy'])->name('admin.evaluaciones.destroy');
    
    // CRUD de desafíos
    Route::get('/desafios', [AdminDesafioController::class, 'index'])->name('admin.desafios');
    Route::get('/desafios/crear', [AdminDesafioController::class, 'create'])->name('admin.desafios.create');
    Route::post('/desafios', [AdminDesafioController::class, 'store'])->name('admin.desafios.store');
    Route::get('/desafios/{id}/editar', [AdminDesafioController::class, 'edit'])->name('admin.desafios.edit');
    Route::put('/desafios/{id}', [AdminDesafioController::class, 'update'])->name('admin.desafios.update');
    Route::delete('/desafios/{id}', [AdminDesafioController::class, 'destroy'])->name('admin.desafios.destroy');
    Route::patch('/desafios/{id}/toggle', [AdminDesafioController::class, 'toggleActivation'])->name('admin.desafios.toggle');
    Route::post('/desafios/{id}/asignar', [AdminDesafioController::class, 'asignarATodos'])->name('admin.desafios.asignar');
    
    // Gestión de usuarios
    Route::patch('/usuarios/{user}/cambiar-rol', [AdminController::class, 'cambiarRol'])->name('admin.usuarios.cambiar-rol');
});

require __DIR__.'/auth.php';
