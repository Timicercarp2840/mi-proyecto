<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComandoEnviado extends Model
{
    use HasFactory;

    protected $table = 'comandos_enviados';
    protected $primaryKey = 'id_comando';

    protected $fillable = [
        'id_usuario',
        'comando',
        'desafio_id',
        'correcto',
        'enviado_en'
    ];

    protected $casts = [
        'correcto' => 'boolean',
        'enviado_en' => 'datetime'
    ];

    public $timestamps = false;    /**
     * Relación con el usuario
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}
