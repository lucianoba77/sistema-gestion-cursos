@extends('layouts.app')

@section('title', 'Detalles de la Evaluación')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Evaluación #{{ $evaluacion->id }}</h1>
            <p class="text-muted mb-0">Detalles de la evaluación</p>
        </div>
    </div>

    <!-- Alertas -->
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Información principal de la evaluación -->
    <div class="row">
        <div class="col-md-8">
            <!-- Tarjeta de información de la evaluación -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-clipboard-check me-2 text-primary"></i>
                                Información de la Evaluación
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('evaluaciones.edit', $evaluacion) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary btn-sm">
                                    <i class="fas fa-arrow-left me-1"></i>Volver
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Información Básica</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>ID:</strong></td>
                                    <td><span class="badge bg-secondary">#{{ $evaluacion->id }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Descripción:</strong></td>
                                    <td>{{ $evaluacion->descripcion }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nota:</strong></td>
                                    <td>
                                        @if($evaluacion->nota >= 7)
                                            <span class="badge bg-success fs-6">{{ $evaluacion->nota }}</span>
                                        @elseif($evaluacion->nota >= 4)
                                            <span class="badge bg-warning fs-6">{{ $evaluacion->nota }}</span>
                                        @else
                                            <span class="badge bg-danger fs-6">{{ $evaluacion->nota }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha:</strong></td>
                                    <td>{{ $evaluacion->fecha->format('d/m/Y') }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Información Adicional</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        @if($evaluacion->nota >= 7)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Aprobado
                                            </span>
                                        @elseif($evaluacion->nota >= 4)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation me-1"></i>Regular
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Desaprobado
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Creado:</strong></td>
                                    <td>{{ $evaluacion->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última actualización:</strong></td>
                                    <td>{{ $evaluacion->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($evaluacion->observaciones)
                                    <tr>
                                        <td><strong>Observaciones:</strong></td>
                                        <td>{{ $evaluacion->observaciones }}</td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del alumno -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user me-2 text-primary"></i>
                        Información del Alumno
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                            {{ strtoupper(substr($evaluacion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($evaluacion->alumno->apellido, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $evaluacion->alumno->nombre }} {{ $evaluacion->alumno->apellido }}</h6>
                            <p class="text-muted mb-1">
                                <i class="fas fa-id-card me-1"></i>
                                DNI: {{ $evaluacion->alumno->dni }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $evaluacion->alumno->email }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i>
                                {{ $evaluacion->alumno->telefono }}
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $evaluacion->alumno->activo ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $evaluacion->alumno->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del curso -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        Información del Curso
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h6 class="mb-2">{{ $evaluacion->curso->titulo }}</h6>
                            <p class="text-muted mb-2">{{ $evaluacion->curso->descripcion }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <strong>Inicio:</strong> {{ $evaluacion->curso->fecha_inicio->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <strong>Fin:</strong> {{ $evaluacion->curso->fecha_fin->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                @switch($evaluacion->curso->modalidad)
                                    @case('presencial')
                                        <span class="badge bg-blue text-white">
                                            <i class="fas fa-users me-1"></i>Presencial
                                        </span>
                                        @break
                                    @case('virtual')
                                        <span class="badge bg-purple text-white">
                                            <i class="fas fa-video me-1"></i>Virtual
                                        </span>
                                        @break
                                    @case('hibrido')
                                        <span class="badge bg-orange text-white">
                                            <i class="fas fa-laptop me-1"></i>Híbrido
                                        </span>
                                        @break
                                @endswitch
                            </div>
                            <div>
                                @switch($evaluacion->curso->estado)
                                    @case('activo')
                                        <span class="badge bg-success">
                                            <i class="fas fa-play me-1"></i>Activo
                                        </span>
                                        @break
                                    @case('finalizado')
                                        <span class="badge bg-info">
                                            <i class="fas fa-check me-1"></i>Finalizado
                                        </span>
                                        @break
                                    @case('cancelado')
                                        <span class="badge bg-danger">
                                            <i class="fas fa-times me-1"></i>Cancelado
                                        </span>
                                        @break
                                @endswitch
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel lateral con estadísticas -->
        <div class="col-md-4">
            <!-- Información de la Evaluación -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>
                        Detalles de la Evaluación
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Descripción:</h6>
                            <p>{{ $evaluacion->descripcion }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Nota:</h6>
                            <span class="badge bg-{{ $evaluacion->nota >= 7 ? 'success' : ($evaluacion->nota >= 6 ? 'warning' : 'danger') }} fs-6">
                                {{ $evaluacion->nota }}/10
                            </span>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <h6>Fecha:</h6>
                            <p>{{ $evaluacion->fecha->format('d/m/Y') }}</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Estado:</h6>
                            <span class="badge bg-success">Registrada</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acciones rápidas -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt me-2 text-primary"></i>
                        Acciones Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('evaluaciones.edit', $evaluacion) }}" 
                           class="btn btn-outline-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Editar Evaluación
                        </a>
                        <a href="{{ route('alumnos.show', $evaluacion->alumno) }}" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-user-graduate me-2"></i>Ver Alumno
                        </a>
                        <a href="{{ route('cursos.show', $evaluacion->curso) }}" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fas fa-graduation-cap me-2"></i>Ver Curso
                        </a>
                    </div>
                </div>
            </div>

            <!-- Información del docente -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2 text-primary"></i>
                        Docente del Curso
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                            {{ strtoupper(substr($evaluacion->curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($evaluacion->curso->docente->apellido, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium">{{ $evaluacion->curso->docente->nombre }} {{ $evaluacion->curso->docente->apellido }}</div>
                            <small class="text-muted">{{ $evaluacion->curso->docente->especialidad }}</small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $evaluacion->curso->docente->email }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Historial de evaluaciones del alumno en este curso -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-history me-2 text-primary"></i>
                Historial de Evaluaciones del Alumno ({{ $evaluacion->alumno->evaluaciones()->where('curso_id', $evaluacion->curso_id)->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($evaluacion->alumno->evaluaciones()->where('curso_id', $evaluacion->curso_id)->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th>Nota</th>
                                <th>Fecha</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluacion->alumno->evaluaciones()->where('curso_id', $evaluacion->curso_id)->orderBy('fecha')->get() as $eval)
                                <tr class="{{ $eval->id === $evaluacion->id ? 'table-primary' : '' }}">
                                    <td>
                                        <strong>{{ $eval->descripcion }}</strong>
                                        @if($eval->id === $evaluacion->id)
                                            <span class="badge bg-primary ms-2">Actual</span>
                                        @endif
                                        @if($eval->observaciones)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($eval->observaciones, 50) }}</small>
                                        @endif
                                    </td>
                                    <td>
                                        @if($eval->nota >= 7)
                                            <span class="badge bg-success">{{ $eval->nota }}</span>
                                        @elseif($eval->nota >= 4)
                                            <span class="badge bg-warning">{{ $eval->nota }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $eval->nota }}</span>
                                        @endif
                                    </td>
                                    <td>{{ $eval->fecha->format('d/m/Y') }}</td>
                                    <td>
                                        @if($eval->nota >= 7)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Aprobado
                                            </span>
                                        @elseif($eval->nota >= 4)
                                            <span class="badge bg-warning">
                                                <i class="fas fa-exclamation me-1"></i>Regular
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Desaprobado
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('evaluaciones.show', $eval) }}" 
                                               class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            @if($eval->id !== $evaluacion->id)
                                                <a href="{{ route('evaluaciones.edit', $eval) }}" 
                                                   class="btn btn-sm btn-outline-warning" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                    <h5>No hay evaluaciones</h5>
                    <p class="text-muted">Este alumno aún no tiene evaluaciones registradas en este curso.</p>
                    <a href="{{ route('evaluaciones.create', ['alumno_id' => $evaluacion->alumno_id, 'curso_id' => $evaluacion->curso_id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Crear primera evaluación
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.bg-blue { background-color: #007bff !important; }
.bg-purple { background-color: #6f42c1 !important; }
.bg-orange { background-color: #fd7e14 !important; }
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
.avatar-lg { width: 64px; height: 64px; font-size: 24px; }
</style>
@endsection