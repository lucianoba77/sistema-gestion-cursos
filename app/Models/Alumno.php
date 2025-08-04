<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Carbon\Carbon;

/**
 * Modelo para gestión de alumnos del sistema
 * Incluye validaciones de edad y límites de cursos activos
 */
class Alumno extends Model
{
    use HasFactory;

    protected $table = 'alumnos';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'email',
        'fecha_nacimiento',
        'telefono',
        'direccion',
        'genero',
        'activo'
    ];

    protected $casts = [
        'fecha_nacimiento' => 'date',
        'activo' => 'boolean',
    ];

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function cursos()
    {
        return $this->belongsToMany(Curso::class, 'inscripciones');
    }

    public function getNombreCompletoAttribute()
    {
        return $this->nombre . ' ' . $this->apellido;
    }

    public function getEdadAttribute()
    {
        if (!$this->fecha_nacimiento) {
            return null;
        }
        return Carbon::parse((string)$this->fecha_nacimiento)->age;
    }

    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeInactivos($query)
    {
        return $query->where('activo', false);
    }

    public function puedeInscribirse()
    {
        return $this->activo && $this->edad >= 16;
    }

    public function tieneCursosActivos()
    {
        return $this->inscripciones()->whereHas('curso', function($query) {
            $query->where('estado', 'activo');
        })->count() < 5;
    }
}
