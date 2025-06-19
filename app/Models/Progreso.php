<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Progreso extends Model
{
    protected $table = 'progresos';
    protected $primaryKey = 'id';
    public $incrementing = true;
    
    protected $fillable = [
        'id_usuario',
        'id_modulo',
        'estado',
        'puntuacion',
        'completado',
        'fecha_inicio',
    ];
    
    protected $casts = [
        'fecha_inicio' => 'datetime',
        'completado' => 'boolean',
    ];
    
    /**
     * Relación con usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
    
    /**
     * Relación con módulo
     */
    public function modulo()
    {
        return $this->belongsTo(Modulo::class, 'id_modulo');
    }
}
