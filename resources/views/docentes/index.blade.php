@extends('layouts.app')

@section('title', 'Gestión de Docentes')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Gestión de Docentes</h1>
            <p class="text-muted mb-0">Administra los docentes del sistema</p>
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
                        <i class="fas fa-user-tie me-2 text-primary"></i>
                        Lista de Docentes
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('docentes.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Nuevo Docente
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('docentes.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control me-2" 
                               placeholder="Buscar docentes..." 
                               value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('docentes.index') }}" 
                               class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                                Todos
                            </a>
                            <a href="{{ route('docentes.filtrar-estado', ['estado' => 'activo']) }}" 
                               class="btn btn-outline-success {{ request('estado') == 'activo' ? 'active' : '' }}">
                                Activos
                            </a>
                            <a href="{{ route('docentes.filtrar-estado', ['estado' => 'inactivo']) }}" 
                               class="btn btn-outline-danger {{ request('estado') == 'inactivo' ? 'active' : '' }}">
                                Inactivos
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabla de docentes -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Docente</th>
                            <th>Especialidad</th>
                            <th>Contacto</th>
                            <th>Cursos Asignados</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docentes as $docente)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $docente->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                            {{ strtoupper(substr($docente->nombre, 0, 1)) }}{{ strtoupper(substr($docente->apellido, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $docente->nombre }} {{ $docente->apellido }}</div>
                                            <small class="text-muted">DNI: {{ $docente->dni }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-info">{{ $docente->especialidad }}</span>
                                </td>
                                <td>
                                    <div>
                                        <div><i class="fas fa-envelope me-1"></i>{{ $docente->email }}</div>
                                        <small class="text-muted"><i class="fas fa-phone me-1"></i>{{ $docente->telefono }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="text-center">
                                        @php
                                            $cursosActivos = $docente->cursos->where('estado', 'activo')->count();
                                            $cursosInactivos = $docente->cursos->where('estado', '!=', 'activo')->count();
                                            $totalCursos = $docente->cursos->count();
                                        @endphp
                                        
                                        @if($totalCursos > 0)
                                            <div class="fw-bold">{{ $totalCursos }}</div>
                                            <small class="text-muted">
                                                {{ $cursosActivos }} activos
                                                @if($cursosInactivos > 0)
                                                    <br>{{ $cursosInactivos }} inactivos
                                                @endif
                                            </small>
                                        @else
                                            <div class="fw-bold text-success">0</div>
                                            <small class="text-success">Sin cursos</small>
                                        @endif
                                    </div>
                                </td>
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
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('docentes.show', $docente) }}" 
                                           class="btn btn-sm btn-outline-primary" 
                                           title="Ver detalles">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('docentes.edit', $docente) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('docentes.toggle-status', $docente) }}" 
                                              method="POST" 
                                              class="d-inline">
                                            @csrf
                                            <button type="submit" 
                                                    class="btn btn-sm {{ $docente->activo ? 'btn-outline-danger' : 'btn-outline-success' }}" 
                                                    title="{{ $docente->activo ? 'Desactivar' : 'Activar' }}"
                                                    onclick="return confirm('¿Estás seguro de {{ $docente->activo ? 'desactivar' : 'activar' }} este docente?')">
                                                <i class="fas {{ $docente->activo ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                            </button>
                                        </form>
                                        
                                        @if($docente->cursos->count() == 0)
                                            <form action="{{ route('docentes.destroy', $docente) }}" 
                                                  method="POST" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                        class="btn btn-sm btn-outline-danger" 
                                                        title="Eliminar docente"
                                                        onclick="return confirm('¿Estás seguro de eliminar este docente? Esta acción no se puede deshacer.')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-user-tie fa-3x mb-3"></i>
                                        <h5>No se encontraron docentes</h5>
                                        <p>No hay docentes registrados en el sistema.</p>
                                        <a href="{{ route('docentes.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Crear primer docente
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($docentes->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $docentes->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
</style>
@endsection