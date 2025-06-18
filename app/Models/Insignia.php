<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Insignia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_insignia';
    
    protected $fillable = [
        'nombre',
        'descripcion',
        'icono',
        'color',
        'xp_requerido',
        'nivel_modulo',
        'tipo',
    ];

    /**
     * Relación con usuarios que tienen esta insignia
     */
    public function usuarios()
    {
        return $this->belongsToMany(User::class, 'user_insignias', 'insignia_id', 'user_id')
            ->withPivot('obtenida_en')
            ->withTimestamps();
    }
}
