<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Evaluacion;

class Inscripcion extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'alumno_id',
        'curso_id',
        'fecha_inscripcion',
        'estado',
        'nota_final',
        'asistencias',
        'observaciones',
        'evaluado_por_docente'
    ];

    protected $casts = [
        'fecha_inscripcion' => 'date',
        'nota_final' => 'decimal:1',
        'asistencias' => 'integer',
        'evaluado_por_docente' => 'boolean',
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

    // Relación con evaluaciones (por alumno_id y curso_id)
    public function evaluaciones(): HasMany
    {
        return $this->hasMany(Evaluacion::class, 'alumno_id', 'alumno_id')
                    ->where('curso_id', $this->curso_id);
    }

    // Accesores
    public function getPorcentajeAsistenciaAttribute()
    {
        // Obtener el total de clases desde la configuración o el curso
        $totalClases = config('app.total_clases_curso', 20);
        return ($this->asistencias / $totalClases) * 100;
    }

    public function getPromedioEvaluacionesAttribute()
    {
        // Buscar evaluaciones directamente por alumno_id y curso_id
        $evaluaciones = Evaluacion::where('alumno_id', $this->alumno_id)
                                 ->where('curso_id', $this->curso_id)
                                 ->get();
        
        if ($evaluaciones->count() === 0) {
            return null;
        }
        
        return $evaluaciones->avg('nota');
    }

    // Scopes
    public function scopeActivas($query)
    {
        return $query->where('estado', 'activo');
    }

    public function scopeAprobadas($query)
    {
        return $query->where('estado', 'aprobado');
    }

    public function scopeReprobadas($query)
    {
        return $query->where('estado', 'desaprobado');
    }

    public function scopeEvaluadas($query)
    {
        return $query->where('evaluado_por_docente', true);
    }

    public function scopeNoEvaluadas($query)
    {
        return $query->where('evaluado_por_docente', false);
    }

    // Métodos
    public function puedeSerAprobado()
    {
        $porcentajeMinimo = config('app.porcentaje_asistencia_minimo', 75);
        return $this->porcentaje_asistencia >= $porcentajeMinimo;
    }

    public function puedeRecibirNota()
    {
        return $this->evaluado_por_docente;
    }

    public function calcularNotaFinal()
    {
        $promedio = $this->promedio_evaluaciones;
        if ($promedio === null) {
            return null;
        }
        
        // Ajustar por asistencia
        $factorAsistencia = min(1.0, $this->porcentaje_asistencia / 100);
        return round($promedio * $factorAsistencia, 1);
    }
}
