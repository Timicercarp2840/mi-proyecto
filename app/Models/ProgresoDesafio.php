<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgresoDesafio extends Model
{
    use HasFactory;

    protected $table = 'progreso_desafios';
    protected $primaryKey = 'id_progreso_desafio';

    protected $fillable = [
        'id_usuario',
        'id_desafio',
        'completado',
        'intentos',
        'completado_en'
    ];

    protected $casts = [
        'completado' => 'boolean',
        'completado_en' => 'datetime'
    ];    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }

    /**
     * Relación con el desafío
     */
    public function desafio()
    {
        return $this->belongsTo(Desafio::class, 'id_desafio', 'id_desafio');
    }
}
