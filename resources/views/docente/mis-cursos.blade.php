@extends('layouts.app')

@section('title', 'Mis Cursos')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-book me-2"></i>
                    Mis Cursos - {{ $docente['nombre'] }} {{ $docente['apellido'] }}
                </h4>
                <div>
                    <a href="{{ route('docente.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver al Dashboard
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-list me-2"></i>
                        Lista de Cursos Asignados
                    </h4>
                </div>
                
                <div class="card-body p-4">
                    <!-- Información del usuario -->
                    <div class="text-center mb-4">
                        <div class="d-flex align-items-center justify-content-center mb-3">
                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                {{ strtoupper(substr($user['name'], 0, 1)) }}
                            </div>
                            <div class="text-start">
                                <h6 class="mb-0">{{ $user['name'] }}</h6>
                                <small class="text-muted">Docente</small>
                            </div>
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

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Lista de cursos -->
                    @if($cursos->count() > 0)
                        <div class="row">
                            @foreach($cursos as $curso)
                                <div class="col-md-6 col-lg-4 mb-4">
                                    <div class="card curso-card h-100">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <h5 class="card-title mb-0">{{ $curso->titulo }}</h5>
                                                <span class="badge bg-{{ $curso->estado === 'activo' ? 'success' : ($curso->estado === 'finalizado' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($curso->estado) }}
                                                </span>
                                            </div>
                                            
                                            <p class="card-text text-muted">
                                                <i class="fas fa-calendar me-2"></i>
                                                {{ $curso->fecha_inicio->format('d/m/Y') }} - {{ $curso->fecha_fin->format('d/m/Y') }}
                                            </p>
                                            
                                            <p class="card-text text-muted">
                                                <i class="fas fa-users me-2"></i>
                                                {{ $curso->total_alumnos ?? 0 }} alumnos inscritos
                                            </p>
                                            
                                            <p class="card-text text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>
                                                {{ ucfirst($curso->modalidad) }}
                                            </p>
                                            
                                            <div class="mt-3">
                                                <div class="d-grid gap-2">
                                                    <a href="{{ route('docente.alumnos-curso', $curso->id) }}" 
                                                       class="btn btn-primary btn-sm">
                                                        <i class="fas fa-users me-2"></i>Ver Alumnos
                                                    </a>
                                                    
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('docente.cargar-asistencias', $curso->id) }}" 
                                                           class="btn btn-outline-success btn-sm">
                                                            <i class="fas fa-clipboard-check me-1"></i>Asistencias
                                                        </a>
                                                        <a href="{{ route('docente.cargar-evaluaciones', $curso->id) }}" 
                                                           class="btn btn-outline-warning btn-sm">
                                                            <i class="fas fa-star me-1"></i>Evaluaciones
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-chalkboard-teacher fa-3x text-muted mb-3"></i>
                            <h5>No tienes cursos asignados</h5>
                            <p class="text-muted">Contacta al administrador para que te asigne cursos.</p>
                        </div>
                    @endif

                    <!-- Botones de acción -->
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <a href="{{ route('docente.archivos.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-upload me-2"></i>Cargar Archivos
                        </a>
                        
                        <a href="{{ route('docente.archivos.index') }}" class="btn btn-outline-info">
                            <i class="fas fa-folder me-2"></i>Mis Archivos
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 