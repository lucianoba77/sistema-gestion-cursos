@extends('layouts.app')

@section('title', 'Detalles del Archivo')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Detalles del Archivo</h1>
            <p class="text-muted mb-0">Información completa del archivo adjunto</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="{{ $archivo->icono }} me-2"></i>
                        {{ $archivo->nombre_archivo }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('archivos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('archivos.edit', $archivo) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Información del archivo -->
                <div class="col-md-8">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-file me-2"></i>Información del Archivo
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Nombre:</strong></div>
                                <div class="col-sm-8">{{ $archivo->nombre_archivo }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Descripción:</strong></div>
                                <div class="col-sm-8">{{ $archivo->descripcion }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Tipo:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-info">{{ ucfirst($archivo->tipo) }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Extensión:</strong></div>
                                <div class="col-sm-8">{{ strtoupper($archivo->extension) }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Tamaño:</strong></div>
                                <div class="col-sm-8">{{ $archivo->tamaño_formateado }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Ruta:</strong></div>
                                <div class="col-sm-8">
                                    <code class="text-muted">{{ $archivo->ruta_archivo }}</code>
                                </div>
                            </div>
                            @if($archivo->observaciones)
                                <div class="row mb-3">
                                    <div class="col-sm-4"><strong>Observaciones:</strong></div>
                                    <div class="col-sm-8">{{ $archivo->observaciones }}</div>
                                </div>
                            @endif
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Fecha de subida:</strong></div>
                                <div class="col-sm-8">{{ $archivo->created_at->format('d/m/Y H:i') }}</div>
                            </div>
                            <div class="row">
                                <div class="col-sm-4"><strong>Última modificación:</strong></div>
                                <div class="col-sm-8">{{ $archivo->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Información de asociación -->
                    @if($archivo->curso || $archivo->evaluacion)
                        <div class="card border-success mt-3">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-link me-2"></i>Asociación
                                </h6>
                            </div>
                            <div class="card-body">
                                @if($archivo->curso)
                                    <div class="row mb-3">
                                        <div class="col-sm-4"><strong>Curso:</strong></div>
                                        <div class="col-sm-8">
                                            <a href="{{ route('cursos.show', $archivo->curso) }}" class="text-decoration-none">
                                                {{ $archivo->curso->titulo }}
                                            </a>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4"><strong>Docente:</strong></div>
                                        <div class="col-sm-8">{{ $archivo->curso->docente->nombre_completo }}</div>
                                    </div>
                                @endif
                                @if($archivo->evaluacion)
                                    <div class="row mb-3">
                                        <div class="col-sm-4"><strong>Evaluación:</strong></div>
                                        <div class="col-sm-8">{{ $archivo->evaluacion->descripcion }}</div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-4"><strong>Alumno:</strong></div>
                                        <div class="col-sm-8">{{ $archivo->evaluacion->inscripcion->alumno->nombre_completo }}</div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4"><strong>Nota:</strong></div>
                                        <div class="col-sm-8">
                                            <span class="badge bg-{{ $archivo->evaluacion->nota >= 7 ? 'success' : ($archivo->evaluacion->nota >= 4 ? 'warning' : 'danger') }}">
                                                {{ $archivo->evaluacion->nota }}
                                            </span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Panel lateral -->
                <div class="col-md-4">
                    <!-- Vista previa del archivo -->
                    <div class="card border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-eye me-2"></i>Vista Previa
                            </h6>
                        </div>
                        <div class="card-body text-center">
                            <i class="{{ $archivo->icono }} fa-4x mb-3"></i>
                            <h6>{{ $archivo->nombre_archivo }}</h6>
                            <p class="text-muted">{{ $archivo->tamaño_formateado }}</p>
                            
                            @if($archivo->puedeSerDescargado())
                                <a href="{{ route('archivos.download', $archivo) }}" class="btn btn-success btn-sm">
                                    <i class="fas fa-download me-2"></i>Descargar
                                </a>
                            @else
                                <button class="btn btn-secondary btn-sm" disabled>
                                    <i class="fas fa-exclamation-triangle me-2"></i>Archivo no disponible
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="card border-warning mt-3">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($archivo->puedeSerDescargado())
                                    <a href="{{ route('archivos.download', $archivo) }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download me-2"></i>Descargar Archivo
                                    </a>
                                @endif
                                <a href="{{ route('archivos.edit', $archivo) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="fas fa-edit me-2"></i>Editar Información
                                </a>
                                <form action="{{ route('archivos.destroy', $archivo) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                            onclick="return confirm('¿Estás seguro de que quieres eliminar este archivo?')">
                                        <i class="fas fa-trash me-2"></i>Eliminar Archivo
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Información técnica -->
                    <div class="card border-secondary mt-3">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-cog me-2"></i>Información Técnica
                            </h6>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Formato válido
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Tamaño dentro del límite
                                </li>
                                <li class="mb-2">
                                    <i class="fas fa-check-circle text-success me-2"></i>
                                    Almacenado correctamente
                                </li>
                                <li>
                                    <i class="fas fa-id-badge text-info me-2"></i>
                                    ID: {{ $archivo->id }}
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 