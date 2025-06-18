<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
        'xp_total',
        'nivel_actual',
        'titulo',
        'estadisticas',
        'username',
        'telefono',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'estadisticas' => 'array',
        ];
    }
    
    /**
     * Relación con progresos
     */
    public function progresos()
    {
        return $this->hasMany(Progreso::class, 'id_usuario');
    }
    
    /**
     * Verificar si es administrador
     */
    public function esAdministrador()
    {
        return $this->rol === 'administrador';
    }
    
    /**
     * Verificar si es estudiante
     */
    public function esEstudiante()
    {
        return $this->rol === 'estudiante';
    }
    
    /**
     * Relación con insignias obtenidas
     */
    public function insignias()
    {
        return $this->belongsToMany(Insignia::class, 'user_insignias', 'user_id', 'insignia_id')
            ->withPivot('obtenida_en')
            ->withTimestamps();
    }
    
    /**
     * Agregar XP al usuario
     */
    public function agregarXP($xp)
    {
        $this->xp_total += $xp;
        
        // Calcular nuevo nivel (cada 1000 XP = 1 nivel)
        $nuevoNivel = floor($this->xp_total / 1000) + 1;
        if ($nuevoNivel > $this->nivel_actual) {
            $this->nivel_actual = $nuevoNivel;
            // Aquí se puede disparar evento de subida de nivel
        }
        
        $this->save();
        return $this;
    }
    
    /**
     * Obtener insignia
     */
    public function obtenerInsignia($insigniaId)
    {
        if (!$this->insignias()->where('insignia_id', $insigniaId)->exists()) {
            $this->insignias()->attach($insigniaId, ['obtenida_en' => now()]);
        }
        return $this;
    }
    
    /**
     * XP necesario para el siguiente nivel
     */
    public function xpParaSiguienteNivel()
    {
        return ($this->nivel_actual * 1000) - $this->xp_total;
    }
}
