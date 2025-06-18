<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Evaluacion extends Model
{
    protected $table = 'evaluaciones';
    protected $primaryKey = 'id_eval';
    
    protected $fillable = [
        'id_modulo',
        'contenido_eval',
    ];
    
    protected $casts = [
        'contenido_eval' => 'array',
    ];
    
    /**
     * Relación con módulo
     */
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }
}
