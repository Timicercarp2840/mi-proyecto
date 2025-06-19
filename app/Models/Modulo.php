<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
    protected $table = 'modulos';
    protected $primaryKey = 'id_modulo';
    
    protected $fillable = [
        'nivel',
        'titulo',
        'descripcion',
        'contenido',
    ];
    
    /**
     * Relación con evaluaciones
     */
    public function evaluaciones()
    {
        return $this->hasMany(Evaluacion::class, 'id_modulo');
    }
    
    /**
     * Relación con progresos
     */
    public function progresos()
    {
        return $this->hasMany(Progreso::class, 'id_modulo');
    }
}
