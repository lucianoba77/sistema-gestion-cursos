@extends('layouts.app')

@section('title', 'Detalles del Docente')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">{{ $docente->nombre }} {{ $docente->apellido }}</h1>
            <p class="text-muted mb-0">Detalles del docente</p>
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

    <!-- Información principal del docente -->
    <div class="row">
        <div class="col-md-8">
            <!-- Tarjeta de información del docente -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-user-tie me-2 text-primary"></i>
                                Información Personal
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('docentes.edit', $docente) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                    <td><span class="badge bg-secondary">#{{ $docente->id }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Nombre:</strong></td>
                                    <td>{{ $docente->nombre }} {{ $docente->apellido }}</td>
                                </tr>
                                <tr>
                                    <td><strong>DNI:</strong></td>
                                    <td>{{ $docente->dni }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Especialidad:</strong></td>
                                    <td><span class="badge bg-info">{{ $docente->especialidad }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
                                    <td>
                                        @if($docente->activo)
                                            <span class="badge bg-success">
                                                <i class="fas fa-check me-1"></i>Activo
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times me-1"></i>Inactivo
                                            </span>
                                        @endif
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Información de Contacto</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Email:</strong></td>
                                    <td>
                                        <a href="mailto:{{ $docente->email }}" class="text-decoration-none">
                                            <i class="fas fa-envelope me-1"></i>{{ $docente->email }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Teléfono:</strong></td>
                                    <td>
                                        <a href="tel:{{ $docente->telefono }}" class="text-decoration-none">
                                            <i class="fas fa-phone me-1"></i>{{ $docente->telefono }}
                                        </a>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Dirección:</strong></td>
                                    <td>
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $docente->direccion }}
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Creado:</strong></td>
                                    <td>{{ $docente->created_at->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Última actualización:</strong></td>
                                    <td>{{ $docente->updated_at->format('d/m/Y H:i') }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel lateral con estadísticas -->
        <div class="col-md-4">
            <!-- Estadísticas del docente -->
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
                                <h4 class="text-primary mb-1">{{ $docente->cursos->count() }}</h4>
                                <small class="text-muted">Total Cursos</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-success mb-1">{{ $docente->cursos->where('estado', 'activo')->count() }}</h4>
                                <small class="text-muted">Cursos Activos</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-info mb-1">{{ $docente->cursos->where('estado', 'finalizado')->count() }}</h4>
                                <small class="text-muted">Finalizados</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-warning mb-1">{{ $docente->cursos->sum(function($curso) { return $curso->inscripciones->count(); }) }}</h4>
                                <small class="text-muted">Total Alumnos</small>
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
                        <a href="{{ route('cursos.create', ['docente_id' => $docente->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-plus me-2"></i>Asignar Curso
                        </a>
                        @if($docente->activo)
                            <form action="{{ route('docentes.toggle-status', $docente) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" 
                                        onclick="return confirm('¿Estás seguro de desactivar este docente?')">
                                    <i class="fas fa-user-slash me-2"></i>Desactivar
                                </button>
                            </form>
                        @else
                            <form action="{{ route('docentes.toggle-status', $docente) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-success btn-sm w-100">
                                    <i class="fas fa-user-check me-2"></i>Activar
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2 text-primary"></i>
                        Información Adicional
                    </h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Disponibilidad:</strong> 
                            @if($docente->puedeAsignarCursos())
                                <span class="text-success">Puede asignar cursos</span>
                            @else
                                <span class="text-warning">Límite de cursos alcanzado</span>
                            @endif
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Estado:</strong> 
                            @if($docente->activo)
                                <span class="text-success">Activo</span>
                            @else
                                <span class="text-danger">Inactivo</span>
                            @endif
                        </li>
                        <li>
                            <i class="fas fa-check-circle text-success me-2"></i>
                            <strong>Cursos activos:</strong> {{ $docente->cursos->where('estado', 'activo')->count() }}/3
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Cursos asignados -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <h5 class="card-title mb-0">
                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                Cursos Asignados ({{ $docente->cursos->count() }})
            </h5>
        </div>
        <div class="card-body">
            @if($docente->cursos->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Curso</th>
                                <th>Modalidad</th>
                                <th>Fechas</th>
                                <th>Inscriptos</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($docente->cursos as $curso)
                                <tr>
                                    <td>
                                        <div>
                                            <strong>{{ $curso->titulo }}</strong>
                                            <br>
                                            <small class="text-muted">{{ Str::limit($curso->descripcion, 50) }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($curso->modalidad)
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
                                    </td>
                                    <td>
                                        <div class="text-nowrap">
                                            <div><strong>Inicio:</strong> {{ $curso->fecha_inicio->format('d/m/Y') }}</div>
                                            <div><strong>Fin:</strong> {{ $curso->fecha_fin->format('d/m/Y') }}</div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="text-center">
                                            <div class="fw-bold">{{ $curso->inscripciones->count() }}</div>
                                            <small class="text-muted">de {{ $curso->cupos_maximos }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        @switch($curso->estado)
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
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('cursos.show', $curso) }}" 
                                               class="btn btn-sm btn-outline-primary" 
                                               title="Ver detalles">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('cursos.edit', $curso) }}" 
                                               class="btn btn-sm btn-outline-warning" 
                                               title="Editar">
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
                    <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                    <h5>No hay cursos asignados</h5>
                    <p class="text-muted">Este docente aún no tiene cursos asignados.</p>
                    <a href="{{ route('cursos.create', ['docente_id' => $docente->id]) }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Asignar primer curso
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
</style>
@endsection