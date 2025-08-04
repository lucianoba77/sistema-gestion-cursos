@extends('layouts.app')

@section('title', 'Gestión de Inscripciones')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Gestión de Inscripciones</h1>
            <p class="text-muted mb-0">Administra las inscripciones de alumnos a cursos</p>
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

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2 text-primary"></i>
                        Lista de Inscripciones
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Inscripción
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros y búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('inscripciones.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control me-2" 
                               placeholder="Buscar inscripciones..." 
                               value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('inscripciones.index') }}" 
                               class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                                Todas
                            </a>
                            <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'activo']) }}" 
                               class="btn btn-outline-warning {{ request('estado') == 'activo' ? 'active' : '' }}">
                                En Curso
                            </a>
                            <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'aprobado']) }}" 
                               class="btn btn-outline-success {{ request('estado') == 'aprobado' ? 'active' : '' }}">
                                Aprobadas
                            </a>
                            <a href="{{ route('inscripciones.filtrar-estado', ['estado' => 'desaprobado']) }}" 
                               class="btn btn-outline-danger {{ request('estado') == 'desaprobado' ? 'active' : '' }}">
                                <i class="fas fa-times-circle me-1"></i>
                                Desaprobadas
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de inscripciones -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Alumno</th>
                            <th>Curso</th>
                            <th>Docente</th>
                            <th>Estado</th>
                            <th>Nota Final</th>
                            <th>Asistencias</th>
                            <th>Fecha Inscripción</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($inscripciones as $inscripcion)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $inscripcion->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->alumno->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</div>
                                            <small class="text-muted">{{ $inscripcion->alumno->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $inscripcion->curso->titulo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($inscripcion->curso->descripcion, 40) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($inscripcion->curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->curso->docente->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $inscripcion->curso->docente->nombre }} {{ $inscripcion->curso->docente->apellido }}</div>
                                            <small class="text-muted">{{ $inscripcion->curso->docente->especialidad }}</small>
                                        </div>
                                    </div>
                                </td>
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
                                        @case('retirado')
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-user-slash me-1"></i>Retirado
                                            </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($inscripcion->nota_final)
                                        <span class="badge bg-info">{{ $inscripcion->nota_final }}</span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-center">
                                        <div class="fw-bold">{{ $inscripcion->asistencias }}</div>
                                        <small class="text-muted">asistencias</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <div>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $inscripcion->fecha_inscripcion->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('inscripciones.show', $inscripcion) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('inscripciones.edit', $inscripcion) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        @if($inscripcion->estado === 'activo')
                                            <div class="dropdown">
                                                <button type="button" 
                                                        class="btn btn-sm btn-outline-success dropdown-toggle dropdown-toggle-split" 
                                                        data-bs-toggle="dropdown">
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="estado" value="aprobado">
                                                            <button type="submit" class="dropdown-item">
                                                                <i class="fas fa-check me-2"></i>Aprobar
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <input type="hidden" name="estado" value="desaprobado">
                                                            <button type="submit" class="dropdown-item text-danger">
                                                                <i class="fas fa-times me-2"></i>Desaprobar
                                                            </button>
                                                        </form>
                                                    </li>
                                                    <li>
                                                        <form action="{{ route('inscripciones.cambiar-estado', $inscripcion) }}" method="POST" class="d-inline">
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
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-user-graduate fa-3x mb-3"></i>
                                        <h5>No se encontraron inscripciones</h5>
                                        <p>No hay inscripciones registradas en el sistema.</p>
                                        <a href="{{ route('inscripciones.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear primera inscripción
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($inscripciones->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $inscripciones->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
</style>
@endsection