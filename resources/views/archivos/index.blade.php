@extends('layouts.app')

@section('title', 'Gestión de Archivos Adjuntos')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Gestión de Archivos Adjuntos</h1>
            <p class="text-muted mb-0">Administra los archivos adjuntos del sistema</p>
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
                        <i class="fas fa-paperclip me-2 text-primary"></i>
                        Lista de Archivos Adjuntos
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('archivos.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Subir Archivo
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <!-- Filtros y búsqueda -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <form action="{{ route('archivos.search') }}" method="GET" class="d-flex">
                        <input type="text" name="q" class="form-control me-2" 
                               placeholder="Buscar archivos..." 
                               value="{{ $search ?? '' }}">
                        <button type="submit" class="btn btn-outline-secondary">
                            <i class="fas fa-search"></i>
                        </button>
                    </form>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-end">
                        <div class="btn-group" role="group">
                            <a href="{{ route('archivos.index') }}" 
                               class="btn btn-outline-secondary {{ !request('tipo') ? 'active' : '' }}">
                                Todos
                            </a>
                            <a href="{{ route('archivos.filtrar-tipo', ['tipo' => 'material']) }}" 
                               class="btn btn-outline-primary {{ request('tipo') == 'material' ? 'active' : '' }}">
                                Material
                            </a>
                            <a href="{{ route('archivos.filtrar-tipo', ['tipo' => 'tarea']) }}" 
                               class="btn btn-outline-success {{ request('tipo') == 'tarea' ? 'active' : '' }}">
                                Tareas
                            </a>
                            <a href="{{ route('archivos.filtrar-tipo', ['tipo' => 'guia']) }}" 
                               class="btn btn-outline-info {{ request('tipo') == 'guia' ? 'active' : '' }}">
                                Guías
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            @if(request('q'))
                <div class="alert alert-info mb-3">
                    <i class="fas fa-search me-2"></i>
                    Resultados de búsqueda para: <strong>"{{ request('q') }}"</strong>
                    <a href="{{ route('archivos.index') }}" class="float-end">
                        <i class="fas fa-times me-1"></i>Limpiar búsqueda
                    </a>
                </div>
            @endif

            <!-- Tabla de archivos -->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>ID</th>
                            <th>Archivo</th>
                            <th>Tipo</th>
                            <th>Relacionado con</th>
                            <th>Fecha Subida</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($archivos as $archivo)
                            <tr>
                                <td>
                                    <span class="badge bg-secondary">#{{ $archivo->id }}</span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="me-2">
                                            @switch(strtolower(pathinfo($archivo->archivo_url, PATHINFO_EXTENSION)))
                                                @case('pdf')
                                                    <i class="fas fa-file-pdf text-danger fa-lg"></i>
                                                    @break
                                                @case('doc')
                                                @case('docx')
                                                    <i class="fas fa-file-word text-primary fa-lg"></i>
                                                    @break
                                                @case('xls')
                                                @case('xlsx')
                                                    <i class="fas fa-file-excel text-success fa-lg"></i>
                                                    @break
                                                @case('ppt')
                                                @case('pptx')
                                                    <i class="fas fa-file-powerpoint text-warning fa-lg"></i>
                                                    @break
                                                @case('jpg')
                                                @case('jpeg')
                                                @case('png')
                                                @case('gif')
                                                    <i class="fas fa-file-image text-info fa-lg"></i>
                                                    @break
                                                @case('zip')
                                                @case('rar')
                                                    <i class="fas fa-file-archive text-secondary fa-lg"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-file text-muted fa-lg"></i>
                                            @endswitch
                                        </div>
                                        <div>
                                            <div class="fw-medium">{{ $archivo->titulo }}</div>
                                            <small class="text-muted">{{ strtoupper(pathinfo($archivo->archivo_url, PATHINFO_EXTENSION)) }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($archivo->tipo)
                                        @case('material')
                                            <span class="badge bg-primary">
                                                <i class="fas fa-book me-1"></i>Material
                                            </span>
                                            @break
                                        @case('tarea')
                                            <span class="badge bg-success">
                                                <i class="fas fa-tasks me-1"></i>Tarea
                                            </span>
                                            @break
                                        @case('guia')
                                            <span class="badge bg-info">
                                                <i class="fas fa-map me-1"></i>Guía
                                            </span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">
                                                <i class="fas fa-file me-1"></i>{{ ucfirst($archivo->tipo) }}
                                            </span>
                                    @endswitch
                                </td>
                                <td>
                                    @if($archivo->curso)
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <i class="fas fa-graduation-cap"></i>
                                            </div>
                                            <div>
                                                <div class="fw-medium">{{ $archivo->curso->titulo }}</div>
                                                <small class="text-muted">{{ $archivo->curso->docente->nombre }} {{ $archivo->curso->docente->apellido }}</small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>

                                <td>
                                    <div class="text-nowrap">
                                        <div>{{ $archivo->created_at->format('d/m/Y') }}</div>
                                        <small class="text-muted">{{ $archivo->created_at->diffForHumans() }}</small>
                                    </div>
                                </td>
                                <td>
                                    <div class="btn-group" role="group">
                                        <a href="{{ route('archivos.download', $archivo) }}" 
                                           class="btn btn-sm btn-outline-success" 
                                           title="Descargar">
                                            <i class="fas fa-download"></i>
                                        </a>
                                        <a href="{{ route('archivos.edit', $archivo) }}" 
                                           class="btn btn-sm btn-outline-warning" 
                                           title="Editar">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-sm btn-outline-danger" 
                                                title="Eliminar"
                                                data-bs-toggle="modal" 
                                                data-bs-target="#deleteModal{{ $archivo->id }}">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                        
                                        <!-- Modal de confirmación -->
                                        <div class="modal fade" id="deleteModal{{ $archivo->id }}" tabindex="-1" aria-labelledby="deleteModalLabel{{ $archivo->id }}" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-danger text-white">
                                                        <h5 class="modal-title" id="deleteModalLabel{{ $archivo->id }}">
                                                            <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Eliminación
                                                        </h5>
                                                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <p>¿Estás seguro de que quieres eliminar el archivo <strong>"{{ $archivo->titulo }}"</strong>?</p>
                                                        <p class="text-muted mb-0">Esta acción no se puede deshacer.</p>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                            <i class="fas fa-times me-2"></i>Cancelar
                                                        </button>
                                                        <form action="{{ route('archivos.destroy', $archivo) }}" method="POST" class="d-inline">
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <div class="text-muted">
                                        <i class="fas fa-paperclip fa-3x mb-3"></i>
                                        <h5>No se encontraron archivos</h5>
                                        <p>No hay archivos adjuntos registrados en el sistema.</p>
                                        <a href="{{ route('archivos.create') }}" class="btn btn-primary">
                                            <i class="fas fa-plus me-2"></i>Subir primer archivo
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            @if($archivos->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    {{ $archivos->links() }}
                </div>
            @endif
        </div>
    </div>
</div>

<style>
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
</style>
@endsection