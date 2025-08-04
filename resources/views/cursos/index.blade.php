@extends('layouts.app')

@section('title', 'Gestión de Cursos')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Gestión de Cursos</h1>
            <p class="text-muted mb-0">Administra los cursos del sistema</p>
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
                        <i class="fas fa-graduation-cap me-2 text-primary"></i>
                        Lista de Cursos
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('cursos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Curso
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros y búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('cursos.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control me-2" 
                               placeholder="Buscar cursos..." 
                               value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('cursos.index') }}" 
                               class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                                Todos
                            </a>
                            <a href="{{ route('cursos.filtrar-estado', ['estado' => 'activo']) }}" 
                               class="btn btn-outline-success {{ request('estado') == 'activo' ? 'active' : '' }}">
                                Activos
                            </a>
                            <a href="{{ route('cursos.filtrar-estado', ['estado' => 'finalizado']) }}" 
                               class="btn btn-outline-info {{ request('estado') == 'finalizado' ? 'active' : '' }}">
                                Finalizados
                            </a>
                            <a href="{{ route('cursos.filtrar-estado', ['estado' => 'cancelado']) }}" 
                               class="btn btn-outline-danger {{ request('estado') == 'cancelado' ? 'active' : '' }}">
                                Cancelados
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if(request('q'))
                <div class="alert alert-info mb-3">
                    <i class="fas fa-search me-2"></i>
                    Resultados de búsqueda para: <strong>"{{ request('q') }}"</strong>
                    <a href="{{ route('cursos.index') }}" class="float-end">
                        <i class="fas fa-times me-1"></i>Limpiar búsqueda
                    </a>
                </div>
            @endif

            <!-- Tabla de cursos -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Docente</th>
                            <th>Modalidad</th>
                            <th>Fechas</th>
                            <th>Inscriptos</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($cursos as $curso)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $curso->id }}</span>
                                </td>
                                <td>
                                    <div>
                                        <strong>{{ $curso->titulo }}</strong>
                                        <br>
                                        <small class="text-muted">{{ Str::limit($curso->descripcion, 50) }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($curso->docente->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}</div>
                                            <small class="text-muted">{{ $curso->docente->especialidad }}</small>
                                        </div>
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
                                        @if($curso->estado === 'activo')
                                            <button type="button" 
                                                    class="btn btn-sm btn-outline-success dropdown-toggle dropdown-toggle-split" 
                                                    data-bs-toggle="dropdown">
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <form action="{{ route('cursos.cambiar-estado', $curso) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="estado" value="finalizado">
                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fas fa-check me-2"></i>Finalizar
                                                        </button>
                                                    </form>
                                                </li>
                                                <li>
                                                    <form action="{{ route('cursos.cambiar-estado', $curso) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <input type="hidden" name="estado" value="cancelado">
                                                        <button type="submit" class="dropdown-item text-danger">
                                                            <i class="fas fa-times me-2"></i>Cancelar
                                                        </button>
                                                    </form>
                                                </li>
                                            </ul>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-graduation-cap fa-3x mb-3"></i>
                                        <h5>No se encontraron cursos</h5>
                                        <p>No hay cursos registrados en el sistema.</p>
                                        <a href="{{ route('cursos.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear primer curso
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($cursos->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $cursos->links() }}
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
</style>
@endsection