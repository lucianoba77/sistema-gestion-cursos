@extends('layouts.app')

@section('title', 'Dashboard Docente')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard Docente - {{ $docente['nombre'] }} {{ $docente['apellido'] }}
                </h4>
            </div>
        </div>
    </div>

    <!-- Mis Cursos -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-book me-2"></i>
                        Mis Cursos Activos
                    </h4>
                </div>
                <div class="card-body">
                    @if(count($cursos) > 0)
                        <div class="row">
                            @foreach($cursos as $curso)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $curso['titulo'] }}</h5>
                                            <p class="card-text text-muted">{{ Str::limit($curso['descripcion'], 100) }}</p>
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="badge bg-{{ $curso['estado'] == 'activo' ? 'success' : 'secondary' }}">
                                                    {{ ucfirst($curso['estado']) }}
                                                </span>
                                                <small class="text-muted">
                                                    {{ $curso['modalidad'] }}
                                                </small>
                                            </div>
                                            <div class="mt-2">
                                                <small class="text-muted">
                                                    <i class="fas fa-users me-1"></i>
                                                    {{ $curso['total_alumnos'] ?? 0 }} alumnos
                                                </small>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <div class="d-flex flex-wrap gap-2">
                                                <a href="{{ route('docente.alumnos-curso', $curso['id']) }}" 
                                                   class="btn btn-sm btn-primary">
                                                    <i class="fas fa-users me-1"></i>
                                                    Ver Alumnos
                                                </a>
                                                <a href="{{ route('docente.cargar-asistencias', $curso['id']) }}" 
                                                   class="btn btn-sm btn-success">
                                                    <i class="fas fa-clipboard-check me-1"></i>
                                                    Asistencias
                                                </a>
                                                <a href="{{ route('docente.cargar-evaluaciones', $curso['id']) }}" 
                                                   class="btn btn-sm btn-warning">
                                                    <i class="fas fa-star me-1"></i>
                                                    Calificar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">No tienes cursos asignados</h5>
                            <p class="text-muted">Contacta al administrador para que te asigne cursos.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    @if(count($cursos) > 0)
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title mb-0">
                            <i class="fas fa-bolt me-2"></i>
                            Acciones Rápidas
                        </h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('docente.archivos.create') }}" class="btn btn-success w-100">
                                    <i class="fas fa-upload me-2"></i>
                                    Subir Archivo
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('docente.archivos.index') }}" class="btn btn-info w-100">
                                    <i class="fas fa-folder me-2"></i>
                                    Mis Archivos
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('profile') }}" class="btn btn-secondary w-100">
                                    <i class="fas fa-user me-2"></i>
                                    Mi Perfil
                                </a>
                            </div>
                            <div class="col-md-3 mb-3">
                                <a href="{{ route('docente.mis-cursos') }}" class="btn btn-primary w-100">
                                    <i class="fas fa-list me-2"></i>
                                    Ver Todos Mis Cursos
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Estadísticas del Docente -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Mis Estadísticas
                    </h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 text-primary">{{ count($cursos) }}</div>
                                <small class="text-muted">Cursos Activos</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 text-success">{{ $cursos->sum('total_alumnos') }}</div>
                                <small class="text-muted">Total Alumnos</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 text-warning">{{ $docente['especialidad'] }}</div>
                                <small class="text-muted">Especialidad</small>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="text-center">
                                <div class="h2 text-info">{{ $docente['activo'] ? 'Activo' : 'Inactivo' }}</div>
                                <small class="text-muted">Estado</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 