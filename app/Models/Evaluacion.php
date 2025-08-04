<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Evaluacion extends Model
{
    use HasFactory;

    protected $table = 'evaluaciones';

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'descripcion',
        'nota',
        'fecha'
    ];

    protected $casts = [
        'nota' => 'decimal:1',
        'fecha' => 'date',
    ];

    // Relaciones
    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    // Scopes
    public function scopePorAlumno($query, $alumnoId)
    {
        return $query->where('alumno_id', $alumnoId);
    }

    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->where('fecha', $fecha);
    }

    // Métodos
    public function esNotaValida()
    {
        return $this->nota >= 1 && $this->nota <= 10;
    }

    public function getNotaTextoAttribute()
    {
        if ($this->nota >= 9) return 'Excelente';
        if ($this->nota >= 7) return 'Muy Bueno';
        if ($this->nota >= 6) return 'Bueno';
        if ($this->nota >= 4) return 'Regular';
        return 'Insuficiente';
    }
}
