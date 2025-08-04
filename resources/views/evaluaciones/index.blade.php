@extends('layouts.app')

@section('title', 'Gestión de Evaluaciones')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Gestión de Evaluaciones</h1>
            <p class="text-muted mb-0">Administra las evaluaciones de los alumnos</p>
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
                        <i class="fas fa-clipboard-check me-2 text-primary"></i>
                        Lista de Evaluaciones
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nueva Evaluación
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros y búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('evaluaciones.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control me-2" 
                               placeholder="Buscar evaluaciones..." 
                               value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('evaluaciones.index') }}" 
                               class="btn btn-outline-secondary {{ !request('filtro') ? 'active' : '' }}">
                                Todas
                            </a>
                            <a href="{{ route('evaluaciones.filtrar-curso', ['filtro' => 'activos']) }}" 
                               class="btn btn-outline-success {{ request('filtro') == 'activos' ? 'active' : '' }}">
                                Cursos Activos
                            </a>
                            <a href="{{ route('evaluaciones.filtrar-curso', ['filtro' => 'finalizados']) }}" 
                               class="btn btn-outline-info {{ request('filtro') == 'finalizados' ? 'active' : '' }}">
                                Cursos Finalizados
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de evaluaciones -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Alumno</th>
                            <th>Curso</th>
                            <th>Docente</th>
                            <th>Descripción</th>
                            <th>Nota</th>
                            <th>Fecha</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($evaluaciones as $evaluacion)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $evaluacion->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($evaluacion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($evaluacion->alumno->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                                                        <div class="fw-medium">{{ $evaluacion->alumno->nombre }} {{ $evaluacion->alumno->apellido }}</div>
                            <small class="text-muted">{{ $evaluacion->alumno->email }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $evaluacion->curso->titulo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($evaluacion->curso->descripcion, 40) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-info text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($evaluacion->curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($evaluacion->curso->docente->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $evaluacion->curso->docente->nombre }} {{ $evaluacion->curso->docente->apellido }}</div>
                                            <small class="text-muted">{{ $evaluacion->curso->docente->especialidad }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $evaluacion->descripcion }}</strong>
                                        @if($evaluacion->observaciones)
                                            <br>
                                            <small class="text-muted">{{ Str::limit($evaluacion->observaciones, 50) }}</small>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($evaluacion->nota >= 7)
                                        <span class="badge bg-success">{{ $evaluacion->nota }}</span>
                                    @elseif($evaluacion->nota >= 4)
                                        <span class="badge bg-warning">{{ $evaluacion->nota }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $evaluacion->nota }}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="text-nowrap">
                                        <div>{{ $evaluacion->fecha->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $evaluacion->fecha->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('evaluaciones.show', $evaluacion) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('evaluaciones.edit', $evaluacion) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Eliminar"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $evaluacion->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-clipboard-check fa-3x mb-3"></i>
                                        <h5>No se encontraron evaluaciones</h5>
                                        <p>No hay evaluaciones registradas en el sistema.</p>
                                        <a href="{{ route('evaluaciones.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear primera evaluación
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($evaluaciones->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $evaluaciones->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- Modales de confirmación de eliminación -->
    @foreach($evaluaciones as $evaluacion)
        <div class="modal fade" id="deleteModal{{ $evaluacion->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $evaluacion->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="deleteModalLabel{{ $evaluacion->id }}">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Confirmar Eliminación
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <p class="mb-0">
                            ¿Estás seguro de que quieres eliminar la evaluación de 
                            <strong>{{ $evaluacion->alumno->nombre }} {{ $evaluacion->alumno->apellido }}</strong> 
                            en el curso <strong>{{ $evaluacion->curso->titulo }}</strong>?
                        </p>
                        <p class="text-muted small mt-2 mb-0">
                            <strong>Descripción:</strong> {{ $evaluacion->descripcion }}<br>
                            <strong>Nota:</strong> {{ $evaluacion->nota }}<br>
                            <strong>Fecha:</strong> {{ $evaluacion->fecha->format('d/m/Y') }}
                        </p>
                        <div class="alert alert-warning mt-3 mb-0">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <strong>Advertencia:</strong> Esta acción no se puede deshacer.
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <form action="{{ route('evaluaciones.destroy', $evaluacion) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-trash me-2"></i>Eliminar Evaluación
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<style>
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
</style>
@endsection