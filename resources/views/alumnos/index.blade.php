@extends('layouts.app')

@section('title', 'Alumnos - Sistema de Gestión de Cursos')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">
        <i class="fas fa-users me-2"></i>
        Gestión de Alumnos
    </h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group me-2">
            <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i>
                Nuevo Alumno
            </a>
        </div>
    </div>
</div>

<!-- Filtros y Búsqueda -->
<div class="row mb-4">
    <div class="col-md-8">
        <form action="{{ route('alumnos.search') }}" method="GET" class="d-flex">
            <input type="text" name="q" class="form-control me-2" placeholder="Buscar por nombre, apellido, DNI o email..." value="{{ request('q') }}">
            <button type="submit" class="btn btn-outline-primary">
                <i class="fas fa-search"></i>
            </button>
        </form>
    </div>
    <div class="col-md-4 text-end">
        <div class="btn-group" role="group">
            <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary {{ !request('estado') ? 'active' : '' }}">
                <i class="fas fa-list me-1"></i>
                Todos
            </a>
            <a href="{{ route('alumnos.filtrar-estado', ['estado' => 'activo']) }}" class="btn btn-outline-success {{ request('estado') == 'activo' ? 'active' : '' }}">
                <i class="fas fa-check-circle me-1"></i>
                Activos
            </a>
            <a href="{{ route('alumnos.filtrar-estado', ['estado' => 'inactivo']) }}" class="btn btn-outline-danger {{ request('estado') == 'inactivo' ? 'active' : '' }}">
                <i class="fas fa-times-circle me-1"></i>
                Inactivos
            </a>
        </div>
    </div>
</div>

@if(request('q'))
    <div class="alert alert-info mb-3">
        <i class="fas fa-search me-2"></i>
        Resultados de búsqueda para: <strong>"{{ request('q') }}"</strong>
        <a href="{{ route('alumnos.index') }}" class="float-end">
            <i class="fas fa-times me-1"></i>Limpiar búsqueda
        </a>
    </div>
@endif

<!-- Tabla de Alumnos -->
<div class="card shadow">
    <div class="card-body">
        @if($alumnos->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Nombre Completo</th>
                            <th>DNI</th>
                            <th>Email</th>
                            <th>Edad</th>
                            <th>Género</th>
                            <th>Estado</th>
                            <th>Cursos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($alumnos as $alumno)
                        <tr>
                            <td>{{ $alumno->id }}</td>
                            <td>
                                <strong>{{ $alumno->nombre_completo }}</strong>
                                <br>
                                <small class="text-muted">{{ $alumno->telefono }}</small>
                            </td>
                            <td>{{ $alumno->dni }}</td>
                            <td>{{ $alumno->email }}</td>
                            <td>
                                <span class="badge bg-info">{{ $alumno->edad }} años</span>
                            </td>
                            <td>
                                @switch($alumno->genero)
                                    @case('masculino')
                                        <span class="badge bg-primary">Masculino</span>
                                        @break
                                    @case('femenino')
                                        <span class="badge bg-pink">Femenino</span>
                                        @break
                                    @default
                                        <span class="badge bg-secondary">Otro</span>
                                @endswitch
                            </td>
                            <td>
                                @if($alumno->activo)
                                    <span class="badge bg-success">Activo</span>
                                @else
                                    <span class="badge bg-danger">Inactivo</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-warning">{{ $alumno->inscripciones->count() }} cursos</span>
                            </td>
                            <td>
                                <div class="btn-group" role="group">
                                    <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-sm btn-outline-primary" title="Ver">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-sm btn-outline-warning" title="Editar">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-{{ $alumno->activo ? 'danger' : 'success' }}" 
                                            title="{{ $alumno->activo ? 'Desactivar' : 'Activar' }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#toggleModal{{ $alumno->id }}">
                                        <i class="fas fa-{{ $alumno->activo ? 'times' : 'check' }}"></i>
                                    </button>
                                    
                                    <!-- Modal de confirmación para toggle status -->
                                    <div class="modal fade" id="toggleModal{{ $alumno->id }}" tabindex="-1" aria-labelledby="toggleModalLabel{{ $alumno->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-{{ $alumno->activo ? 'danger' : 'success' }} text-white">
                                                    <h5 class="modal-title" id="toggleModalLabel{{ $alumno->id }}">
                                                        <i class="fas fa-{{ $alumno->activo ? 'times' : 'check' }}-circle me-2"></i>
                                                        Confirmar {{ $alumno->activo ? 'Desactivación' : 'Activación' }}
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Estás seguro de que quieres <strong>{{ $alumno->activo ? 'desactivar' : 'activar' }}</strong> al alumno <strong>"{{ $alumno->nombre_completo }}"</strong>?</p>
                                                    @if($alumno->activo)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>
                                                            <strong>Advertencia:</strong> Al desactivar un alumno, no podrá inscribirse a nuevos cursos.
                                                        </div>
                                                    @else
                                                        <div class="alert alert-info">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            Al activar un alumno, podrá inscribirse a cursos nuevamente.
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('alumnos.toggle-status', $alumno) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        <button type="submit" class="btn btn-{{ $alumno->activo ? 'danger' : 'success' }}">
                                                            <i class="fas fa-{{ $alumno->activo ? 'times' : 'check' }} me-2"></i>
                                                            {{ $alumno->activo ? 'Desactivar' : 'Activar' }}
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <button type="button" 
                                            class="btn btn-sm btn-outline-danger" 
                                            title="Eliminar"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#deleteModal{{ $alumno->id }}">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                    
                                    <!-- Modal de confirmación para eliminar -->
                                    <div class="modal fade" id="deleteModal{{ $alumno->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $alumno->id }}" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header bg-danger text-white">
                                                    <h5 class="modal-title" id="deleteModalLabel{{ $alumno->id }}">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                                                    </h5>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <p>¿Estás seguro de que quieres eliminar al alumno <strong>"{{ $alumno->nombre_completo }}"</strong>?</p>
                                                    <div class="alert alert-danger">
                                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                                        <strong>¡Advertencia!</strong> Esta acción no se puede deshacer y eliminará todos los datos asociados al alumno.
                                                    </div>
                                                    @if($alumno->inscripciones->count() > 0)
                                                        <div class="alert alert-warning">
                                                            <i class="fas fa-info-circle me-2"></i>
                                                            <strong>Nota:</strong> Este alumno tiene {{ $alumno->inscripciones->count() }} inscripción(es) activa(s).
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                        <i class="fas fa-times me-2"></i>Cancelar
                                                    </button>
                                                    <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">
                                                            <i class="fas fa-trash me-2"></i>Eliminar
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="d-flex justify-content-center mt-4">
                {{ $alumnos->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                <h4 class="text-muted">No se encontraron alumnos</h4>
                <p class="text-muted">No hay alumnos registrados en el sistema.</p>
                <a href="{{ route('alumnos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i>
                    Registrar Primer Alumno
                </a>
            </div>
        @endif
    </div>
</div>

@push('styles')
<style>
.badge.bg-pink {
    background-color: #e83e8c !important;
}
.table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
}
.btn-group .btn {
    margin-right: 2px;
}
</style>
@endpush
@endsection