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

    /**
     * Relación con los progresos de usuarios en desafíos
     */
    public function progresosDesafio()
    {
        return $this->hasMany(ProgresoDesafio::class, 'id_desafio', 'id_desafio');
    }
}
