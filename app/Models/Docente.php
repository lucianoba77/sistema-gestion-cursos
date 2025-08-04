<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Docente extends Model
{
    use HasFactory;

    protected $table = 'docentes';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'especialidad',
        'telefono',
        'direccion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];

    // Relaciones
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class);
    }

    // Accesores
    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    // Métodos
    public function puedeAsignarCursos()
    {
        return $this->activo && $this->cursos()->where('estado', 'activo')->count() < 3;
    }

    public function cursosActivos()
    {
        return $this->cursos()->where('estado', 'activo');
    }
}
