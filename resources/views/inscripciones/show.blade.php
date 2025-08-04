@extends('layouts.app')

@section('title', 'Detalles de la Inscripción')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Inscripción #{{ $inscripcion->id }}</h1>
            <p class="text-muted mb-0">Detalles de la inscripción</p>
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

    <!-- Información principal de la inscripción -->
    <div class="row">
        <div class="col-md-8">
            <!-- Tarjeta de información de la inscripción -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-graduate me-2 text-primary"></i>
                                Información de la Inscripción
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                    <td><span class="badge bg-secondary">#{{ $inscripcion->id }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        @switch($inscripcion->estado)
                                            @case('activo')
                                                <span class="badge bg-warning">
                                                    <i class="fas fa-clock me-1"></i>En Curso
                                                </span>
                                                @break
                                            @case('aprobado')
                                                <span class="badge bg-success">
                                                    <i class="fas fa-check me-1"></i>Aprobado
                                                </span>
                                                @break
                                                                                                            @case('desaprobado')
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Desaprobado
                                            </span>
                                            @break
                                        @endswitch
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha Inscripción:</strong></td>
                                    <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Asistencias:</strong></td>
                                    <td>{{ $inscripcion->asistencias }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Nota Final:</strong></td>
                                    <td>
                                        @if($inscripcion->nota_final)
                                            <span class="badge bg-info">{{ $inscripcion->nota_final }}</span>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Información Adicional</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Evaluado por Docente:</strong></td>
                                    <td>
                                        @if($inscripcion->evaluado_por_docente)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Sí
                                            </span>
                                        @else
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock me-1"></i>Pendiente
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Creado:</strong></td>
                                    <td>{{ $inscripcion->created_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última actualización:</strong></td>
                                    <td>{{ $inscripcion->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                                @if($inscripcion->observaciones)
                                    <tr>
                                        <td><strong>Observaciones:</strong></td>
                                        <td>{{ $inscripcion->observaciones }}</td>
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
                            {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->alumno->apellido, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</h6>
                            <p class="text-muted mb-1">
                                <i class="fas fa-id-card me-1"></i>
                                DNI: {{ $inscripcion->alumno->dni }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $inscripcion->alumno->email }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i>
                                {{ $inscripcion->alumno->telefono }}
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $inscripcion->alumno->activo ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $inscripcion->alumno->activo ? 'Activo' : 'Inactivo' }}
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
                            <h6 class="mb-2">{{ $inscripcion->curso->titulo }}</h6>
                            <p class="text-muted mb-2">{{ $inscripcion->curso->descripcion }}</p>
                            <div class="row">
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <strong>Inicio:</strong> {{ $inscripcion->curso->fecha_inicio->format('d/m/Y') }}
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted">
                                        <i class="fas fa-calendar me-1"></i>
                                        <strong>Fin:</strong> {{ $inscripcion->curso->fecha_fin->format('d/m/Y') }}
                                    </small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="mb-2">
                                @switch($inscripcion->curso->modalidad)
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
                                @switch($inscripcion->curso->estado)
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
            <!-- Estadísticas de la inscripción -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2 text-primary"></i>
                        Estadísticas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-primary mb-1">{{ $inscripcion->asistencias }}</h4>
                                <small class="text-muted">Asistencias</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-info mb-1">{{ $evaluaciones->count() }}</h4>
                                <small class="text-muted">Evaluaciones</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-success mb-1">
                                    @if($evaluaciones->count() > 0)
                                        {{ number_format($evaluaciones->avg('nota'), 1) }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <small class="text-muted">Promedio</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-warning mb-1">
                                    @if($inscripcion->nota_final)
                                        {{ $inscripcion->nota_final }}
                                    @else
                                        -
                                    @endif
                                </h4>
                                <small class="text-muted">Nota Final</small>
                            </div>
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
                        <a href="{{ route('evaluaciones.create', ['inscripcion_id' => $inscripcion->id]) }}" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fas fa-clipboard-check me-2"></i>Crear Evaluación
                        </a>
                        @if($inscripcion->estado === 'activo')
                            <div class="dropdown">
                                <button class="btn btn-outline-warning btn-sm dropdown-toggle w-100" 
                                        type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-2"></i>Cambiar Estado
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="estado" value="aprobado">
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check me-2"></i>Aprobar
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="estado" value="desaprobado">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-times me-2"></i>Desaprobar
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="estado" value="retirado">
                                            <button type="submit" class="dropdown-item text-secondary">
                                                <i class="fas fa-user-slash me-2"></i>Marcar como Retirado
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
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
                            {{ strtoupper(substr($inscripcion->curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->curso->docente->apellido, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-medium">{{ $inscripcion->curso->docente->nombre }} {{ $inscripcion->curso->docente->apellido }}</div>
                            <small class="text-muted">{{ $inscripcion->curso->docente->especialidad }}</small>
                        </div>
                    </div>
                    <div class="mt-2">
                        <small class="text-muted">
                            <i class="fas fa-envelope me-1"></i>
                            {{ $inscripcion->curso->docente->email }}
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Evaluaciones del alumno -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-clipboard-check me-2 text-primary"></i>
                Evaluaciones del Alumno ({{ $evaluaciones->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($evaluaciones->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Descripción</th>
                                <th>Nota</th>
                                <th>Fecha</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($evaluaciones as $evaluacion)
                                <tr>
                                    <td>{{ $evaluacion->descripcion }}</td>
                                    <td>
                                        <span class="badge bg-info">{{ $evaluacion->nota }}</span>
                                    </td>
                                    <td>{{ $evaluacion->fecha->format('d/m/Y') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('evaluaciones.edit', $evaluacion) }}" 
                                               class="btn btn-sm btn-outline-warning" title="Editar">
                                                <i class="fas fa-edit"></i>
                                            </a>
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
                    <p class="text-muted">Este alumno aún no tiene evaluaciones registradas.</p>
                    <a href="{{ route('evaluaciones.create', ['inscripcion_id' => $inscripcion->id]) }}" class="btn btn-primary">
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