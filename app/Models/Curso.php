<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'estado',
        'modalidad',
        'aula_virtual',
        'cupos_maximos',
        'docente_id'
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'cupos_maximos' => 'integer',
    ];

    // Relaciones
    public function docente(): BelongsTo
    {
        return $this->belongsTo(Docente::class);
    }

    public function inscripciones(): HasMany
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluacion::class);
    }

    public function archivosAdjuntos(): HasMany
    {
        return $this->hasMany(ArchivoAdjunto::class);
    }

    public function alumnos()
    {
        return $this->belongsToMany(Alumno::class, 'inscripciones');
    }

    // Accesores
    public function getCuposDisponiblesAttribute()
    {
        return $this->cupos_maximos - $this->inscripciones()->count();
    }

    public function getEstaCompletoAttribute()
    {
        return $this->cupos_disponibles <= 0;
    }

    public function getPuedeAceptarInscripcionesAttribute()
    {
        return $this->estado === 'activo' && !$this->esta_completo;
    }

    // Scopes
    public function scopeActivos($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeFinalizados($query)
    {
        return $query->where('estado', 'finalizado');
    }

    public function scopeCancelados($query)
    {
        return $query->where('estado', 'cancelado');
    }

    public function scopeConCuposDisponibles($query)
    {
        return $query->whereRaw('(SELECT COUNT(*) FROM inscripciones WHERE inscripciones.curso_id = cursos.id) < cupos_maximos');
    }

    // Métodos
    public function puedeFinalizar()
    {
        return $this->estado === 'activo' && $this->inscripciones()->count() > 0;
    }

    public function tieneAlumnos()
    {
        return $this->inscripciones()->count() > 0;
    }
}
