<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Desafio extends Model
{
    use HasFactory;

    protected $table = 'desafios';
    protected $primaryKey = 'id_desafio';

    protected $fillable = [
        'nivel',
        'titulo',
        'descripcion',
        'tipo',
        'criterios_validacion',
        'xp_recompensa',
        'activo'
    ];

    protected $casts = [
        'criterios_validacion' => 'json',
        'activo' => 'boolean'
    ];

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopePorNivel($query, $nivel)
    {
        return $query->where('nivel', $nivel);
    }

    public function scopeOrdenados($query)
    {
        return $query->orderBy('nivel')->orderBy('titulo');
    }

    // Accessors
    public function getNivelTextoAttribute()
    {
        $niveles = [
            1 => 'Principiante',
            2 => 'Intermedio', 
            3 => 'Avanzado'
        ];
        return $niveles[$this->nivel] ?? 'Desconocido';
    }
}
