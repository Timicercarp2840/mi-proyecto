<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ProgresoController;
use App\Http\Controllers\AdminController;
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
    
    // Rutas para estudiantes
    Route::get('/modulos', [ModuloController::class, 'index'])->name('modulos.index');
    Route::get('/modulos/{modulo}', [ModuloController::class, 'show'])->name('modulos.show');
    Route::get('/evaluaciones/{evaluacion}/tomar', [EvaluacionController::class, 'tomar'])->name('evaluaciones.tomar');
    Route::post('/evaluaciones/{evaluacion}/calificar', [EvaluacionController::class, 'calificar'])->name('evaluaciones.calificar');
    Route::get('/mi-progreso', [ProgresoController::class, 'miProgreso'])->name('progreso.mi-progreso');
    Route::post('/progreso/{modulo}', [ProgresoController::class, 'actualizar'])->name('progreso.actualizar');
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
    Route::get('/modulos/{modulo}/editar', [ModuloController::class, 'edit'])->name('admin.modulos.edit');
    Route::put('/modulos/{modulo}', [ModuloController::class, 'update'])->name('admin.modulos.update');
    Route::delete('/modulos/{modulo}', [ModuloController::class, 'destroy'])->name('admin.modulos.destroy');
    
    // CRUD de evaluaciones
    Route::get('/evaluaciones/crear', [EvaluacionController::class, 'create'])->name('admin.evaluaciones.create');
    Route::post('/evaluaciones', [EvaluacionController::class, 'store'])->name('admin.evaluaciones.store');
    Route::get('/evaluaciones/{evaluacion}/editar', [EvaluacionController::class, 'edit'])->name('admin.evaluaciones.edit');
    Route::put('/evaluaciones/{evaluacion}', [EvaluacionController::class, 'update'])->name('admin.evaluaciones.update');
    Route::delete('/evaluaciones/{evaluacion}', [EvaluacionController::class, 'destroy'])->name('admin.evaluaciones.destroy');
});

require __DIR__.'/auth.php';
