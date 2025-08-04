@extends('layouts.app')

@section('title', 'Dashboard Coordinador')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    Dashboard Coordinador
                </h4>
            </div>
        </div>
    </div>

    <!-- Estadísticas -->
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Alumnos Activos</p>
                            <h4 class="mb-0">{{ $stats['total_alumnos'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-success align-self-center overflow-hidden">
                                <span class="avatar-title">
                                    <i class="fas fa-user-graduate font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Cursos Activos</p>
                            <h4 class="mb-0">{{ $stats['total_cursos'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-info align-self-center overflow-hidden">
                                <span class="avatar-title">
                                    <i class="fas fa-book font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-md-6">
            <div class="card mini-stats-wid">
                <div class="card-body">
                    <div class="d-flex">
                        <div class="flex-grow-1">
                            <p class="text-muted fw-medium">Inscripciones Pendientes</p>
                            <h4 class="mb-0">{{ $stats['inscripciones_pendientes'] }}</h4>
                        </div>
                        <div class="flex-shrink-0 align-self-center">
                            <div class="mini-stat-icon avatar-sm rounded-circle bg-warning align-self-center overflow-hidden">
                                <span class="avatar-title">
                                    <i class="fas fa-clock font-size-24"></i>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
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
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('alumnos.create') }}" class="btn btn-primary w-100">
                                <i class="fas fa-plus me-2"></i>
                                Registrar Nuevo Alumno
                            </a>
                        </div>
                        <div class="col-md-6 mb-3">
                            <a href="{{ route('inscripciones.create') }}" class="btn btn-success w-100">
                                <i class="fas fa-plus me-2"></i>
                                Cargar Nueva Inscripción
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gestión de Alumnos e Inscripciones -->
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>
                        Gestión de Alumnos
                    </h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('alumnos.index') }}" class="btn btn-outline-primary">
                            <i class="fas fa-list me-2"></i>
                            Ver Todos los Alumnos
                        </a>
                        <a href="{{ route('alumnos.filtrar-estado', ['estado' => 'activo']) }}" class="btn btn-outline-success">
                            <i class="fas fa-check-circle me-2"></i>
                            Alumnos Activos
                        </a>
                        <a href="{{ route('alumnos.filtrar-estado', ['estado' => 'inactivo']) }}" class="btn btn-outline-danger">
                            <i class="fas fa-times-circle me-2"></i>
                            Alumnos Inactivos
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title mb-0">
                        <i class="fas fa-clipboard-list me-2"></i>
                        Gestión de Inscripciones
                    </h4>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-success">
                            <i class="fas fa-list me-2"></i>
                            Ver Todas las Inscripciones
                        </a>
                        <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'activo']) }}" class="btn btn-outline-success">
                            <i class="fas fa-clock me-2"></i>
                            Inscripciones Activas
                        </a>
                        <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'aprobado']) }}" class="btn btn-outline-primary">
                            <i class="fas fa-check me-2"></i>
                            Inscripciones Aprobadas
                        </a>
                        <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'desaprobado']) }}" class="btn btn-outline-danger">
                            <i class="fas fa-times me-2"></i>
                            Inscripciones Desaprobadas
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 