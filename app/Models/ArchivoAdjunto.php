<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArchivoAdjunto extends Model
{
    use HasFactory;

    protected $table = 'archivos_adjuntos';

    protected $fillable = [
        'curso_id',
        'titulo',
        'archivo_url',
        'tipo',
        'fecha_subida'
    ];

    protected $casts = [
        'fecha_subida' => 'datetime',
    ];

    // Relaciones
    public function curso(): BelongsTo
    {
        return $this->belongsTo(Curso::class);
    }

    // Scopes
    public function scopePorTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeMateriales($query)
    {
        return $query->where('tipo', 'material');
    }

    public function scopeTareas($query)
    {
        return $query->where('tipo', 'tarea');
    }

    public function scopeGuias($query)
    {
        return $query->where('tipo', 'guia');
    }

    public function scopePorCurso($query, $cursoId)
    {
        return $query->where('curso_id', $cursoId);
    }



    // Accesores
    public function getExtensionAttribute()
    {
        return pathinfo($this->nombre_archivo, PATHINFO_EXTENSION);
    }

    public function getTamañoFormateadoAttribute()
    {
        if ($this->tamaño < 1024) {
            return $this->tamaño . ' B';
        } elseif ($this->tamaño < 1024 * 1024) {
            return round($this->tamaño / 1024, 1) . ' KB';
        } else {
            return round($this->tamaño / (1024 * 1024), 1) . ' MB';
        }
    }

    public function getIconoAttribute()
    {
        $extension = strtolower($this->extension);
        
        switch ($extension) {
            case 'pdf':
                return 'fas fa-file-pdf text-danger';
            case 'docx':
                return 'fas fa-file-word text-primary';
            case 'ppt':
                return 'fas fa-file-powerpoint text-warning';
            case 'jpg':
            case 'jpeg':
            case 'png':
                return 'fas fa-file-image text-info';
            default:
                return 'fas fa-file text-muted';
        }
    }

    // Métodos
    public function esFormatoValido()
    {
        $formatosValidos = ['pdf', 'docx', 'ppt', 'jpg', 'jpeg', 'png']; // Solo formatos especificados en las reglas
        return in_array(strtolower($this->extension), $formatosValidos);
    }

    public function esTamañoValido()
    {
        // Máximo 10MB
        return $this->tamaño <= 10 * 1024 * 1024;
    }

    public function puedeSerDescargado()
    {
        return file_exists(storage_path('app/public/' . $this->ruta_archivo));
    }
}
