@extends('layouts.app')

@section('title', 'Detalles del Curso')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">{{ $curso->titulo }}</h1>
            <p class="text-muted mb-0">Detalles del curso</p>
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

    <!-- Información principal del curso -->
    <div class="row">
        <div class="col-md-8">
            <!-- Tarjeta de información del curso -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <div class="row align-items-center">
                        <div class="col-md-6">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-graduation-cap me-2 text-primary"></i>
                                Información del Curso
                            </h5>
                        </div>
                        <div class="col-md-6 text-end">
                            <div class="btn-group" role="group">
                                <a href="{{ route('cursos.edit', $curso) }}" class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>Editar
                                </a>
                                <a href="{{ route('cursos.index') }}" class="btn btn-outline-secondary btn-sm">
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
                                    <td><span class="badge bg-secondary">#{{ $curso->id }}</span></td>
                                </tr>
                                <tr>
                                    <td><strong>Título:</strong></td>
                                    <td>{{ $curso->titulo }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Descripción:</strong></td>
                                    <td>{{ $curso->descripcion }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Estado:</strong></td>
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
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Configuración</h6>
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Modalidad:</strong></td>
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
                                </tr>
                                <tr>
                                    <td><strong>Fecha Inicio:</strong></td>
                                    <td>{{ $curso->fecha_inicio->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Fecha Fin:</strong></td>
                                    <td>{{ $curso->fecha_fin->format('d/m/Y') }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Cupos:</strong></td>
                                    <td>{{ $curso->inscripciones->count() }} / {{ $curso->cupos_maximos }}</td>
                                </tr>
                                @if($curso->aula_virtual)
                                    <tr>
                                        <td><strong>Aula Virtual:</strong></td>
                                        <td>
                                            <a href="{{ $curso->aula_virtual }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-external-link-alt me-1"></i>Acceder
                                            </a>
                                        </td>
                                    </tr>
                                @endif
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información del docente -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-tie me-2 text-primary"></i>
                        Docente Asignado
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                            {{ strtoupper(substr($curso->docente->nombre, 0, 1)) }}{{ strtoupper(substr($curso->docente->apellido, 0, 1)) }}
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}</h6>
                            <p class="text-muted mb-1">
                                <i class="fas fa-graduation-cap me-1"></i>
                                {{ $curso->docente->especialidad }}
                            </p>
                            <p class="text-muted mb-1">
                                <i class="fas fa-envelope me-1"></i>
                                {{ $curso->docente->email }}
                            </p>
                            <p class="text-muted mb-0">
                                <i class="fas fa-phone me-1"></i>
                                {{ $curso->docente->telefono }}
                            </p>
                        </div>
                        <div class="text-end">
                            <span class="badge {{ $curso->docente->activo ? 'bg-success' : 'bg-danger' }}">
                                <i class="fas fa-circle me-1"></i>
                                {{ $curso->docente->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Panel lateral con estadísticas -->
        <div class="col-md-4">
            <!-- Estadísticas del curso -->
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
                                <h4 class="text-primary mb-1">{{ $curso->inscripciones->count() }}</h4>
                                <small class="text-muted">Inscriptos</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-success mb-1">{{ $curso->inscripciones->where('estado', 'aprobado')->count() }}</h4>
                                <small class="text-muted">Aprobados</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div class="border-end">
                                <h4 class="text-warning mb-1">{{ $curso->inscripciones->where('estado', 'activo')->count() }}</h4>
                                <small class="text-muted">En Curso</small>
                            </div>
                        </div>
                        <div class="col-6 mb-3">
                            <div>
                                <h4 class="text-danger mb-1">{{ $curso->inscripciones->where('estado', 'desaprobado')->count() }}</h4>
                                <small class="text-muted">Desaprobados</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Progreso de cupos -->
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-1">
                            <small>Cupos Ocupados</small>
                            <small>{{ number_format(($curso->inscripciones->count() / $curso->cupos_maximos) * 100, 1) }}%</small>
                        </div>
                        <div class="progress" style="height: 8px;">
                            <div class="progress-bar" role="progressbar" 
                                 style="width: {{ ($curso->inscripciones->count() / $curso->cupos_maximos) * 100 }}%"></div>
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
                        <a href="{{ route('inscripciones.create', ['curso_id' => $curso->id]) }}" 
                           class="btn btn-outline-primary btn-sm">
                            <i class="fas fa-user-plus me-2"></i>Inscribir Alumno
                        </a>
                        <a href="{{ route('evaluaciones.create', ['curso_id' => $curso->id]) }}" 
                           class="btn btn-outline-success btn-sm">
                            <i class="fas fa-clipboard-check me-2"></i>Crear Evaluación
                        </a>
                        <a href="{{ route('archivos.create', ['curso_id' => $curso->id]) }}" 
                           class="btn btn-outline-info btn-sm">
                            <i class="fas fa-file-upload me-2"></i>Subir Archivo
                        </a>
                        @if($curso->estado === 'activo')
                            <div class="dropdown">
                                <button class="btn btn-outline-warning btn-sm dropdown-toggle w-100" 
                                        type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-cog me-2"></i>Cambiar Estado
                                </button>
                                <ul class="dropdown-menu">
                                    <li>
                                        <form action="{{ route('cursos.cambiar-estado', $curso) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="estado" value="finalizado">
                                            <button type="submit" class="dropdown-item">
                                                <i class="fas fa-check me-2"></i>Finalizar Curso
                                            </button>
                                        </form>
                                    </li>
                                    <li>
                                        <form action="{{ route('cursos.cambiar-estado', $curso) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="estado" value="cancelado">
                                            <button type="submit" class="dropdown-item text-danger">
                                                <i class="fas fa-times me-2"></i>Cancelar Curso
                                            </button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pestañas de contenido -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <ul class="nav nav-tabs card-header-tabs" id="cursoTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="alumnos-tab" data-bs-toggle="tab" data-bs-target="#alumnos" type="button" role="tab">
                        <i class="fas fa-users me-2"></i>Alumnos ({{ $curso->inscripciones->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="evaluaciones-tab" data-bs-toggle="tab" data-bs-target="#evaluaciones" type="button" role="tab">
                        <i class="fas fa-clipboard-check me-2"></i>Evaluaciones ({{ $curso->evaluaciones->count() }})
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="archivos-tab" data-bs-toggle="tab" data-bs-target="#archivos" type="button" role="tab">
                        <i class="fas fa-file me-2"></i>Archivos ({{ $curso->archivosAdjuntos->count() }})
                    </button>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="cursoTabsContent">
                <!-- Pestaña de Alumnos -->
                <div class="tab-pane fade show active" id="alumnos" role="tabpanel">
                    @if($curso->inscripciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Estado</th>
                                        <th>Nota Final</th>
                                        <th>Asistencias</th>
                                        <th>Fecha Inscripción</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->inscripciones as $inscripcion)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->alumno->apellido, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</div>
                                                        <small class="text-muted">{{ $inscripcion->alumno->email }}</small>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                @switch($inscripcion->estado)
                                                    @case('activo')
                                                        <span class="badge bg-warning">En Curso</span>
                                                        @break
                                                    @case('aprobado')
                                                        <span class="badge bg-success">Aprobado</span>
                                                        @break
                                                    @case('desaprobado')
                                                        <span class="badge bg-danger">Desaprobado</span>
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
                                            <td>{{ $inscripcion->asistencias }}</td>
                                            <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('inscripciones.show', $inscripcion) }}" 
                                                       class="btn btn-sm btn-outline-primary" title="Ver detalles">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('inscripciones.edit', $inscripcion) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
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
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <h5>No hay alumnos inscritos</h5>
                            <p class="text-muted">Este curso aún no tiene alumnos inscritos.</p>
                            <a href="{{ route('inscripciones.create', ['curso_id' => $curso->id]) }}" class="btn btn-primary">
                                <i class="fas fa-user-plus me-2"></i>Inscribir primer alumno
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pestaña de Evaluaciones -->
                <div class="tab-pane fade" id="evaluaciones" role="tabpanel">
                    @if($curso->evaluaciones->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th>Alumno</th>
                                        <th>Descripción</th>
                                        <th>Nota</th>
                                        <th>Fecha</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($curso->evaluaciones as $evaluacion)
                                        @if($evaluacion->inscripcion && $evaluacion->inscripcion->alumno)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                        {{ strtoupper(substr($evaluacion->inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($evaluacion->inscripcion->alumno->apellido, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $evaluacion->inscripcion->alumno->nombre }} {{ $evaluacion->inscripcion->alumno->apellido }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{ $evaluacion->descripcion }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $evaluacion->nota }}</span>
                                            </td>
                                            <td>{{ $evaluacion->fecha->format('d/m/Y') }}</td>
                                            <td>
                                                <div class="btn-group" role="group">
                                                    <a href="{{ route('evaluaciones.edit', $evaluacion) }}" 
                                                       class="btn btn-sm btn-outline-warning" title="Editar">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                            <h5>No hay evaluaciones</h5>
                            <p class="text-muted">Este curso aún no tiene evaluaciones registradas.</p>
                            <a href="{{ route('evaluaciones.create', ['curso_id' => $curso->id]) }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>Crear primera evaluación
                            </a>
                        </div>
                    @endif
                </div>

                <!-- Pestaña de Archivos -->
                <div class="tab-pane fade" id="archivos" role="tabpanel">
                    @if($curso->archivosAdjuntos->count() > 0)
                        <div class="row">
                            @foreach($curso->archivosAdjuntos as $archivo)
                                <div class="col-md-6 col-lg-4 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body">
                                            <div class="d-flex align-items-center mb-2">
                                                <i class="fas fa-file-pdf text-danger me-2"></i>
                                                <h6 class="card-title mb-0">{{ $archivo->titulo }}</h6>
                                            </div>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-tag me-1"></i>
                                                    @switch($archivo->tipo)
                                                        @case('tarea')
                                                            <span class="badge bg-warning">Tarea</span>
                                                            @break
                                                        @case('material')
                                                            <span class="badge bg-info">Material</span>
                                                            @break
                                                        @case('guia')
                                                            <span class="badge bg-success">Guía</span>
                                                            @break
                                                    @endswitch
                                                </small>
                                            </p>
                                            <p class="card-text">
                                                <small class="text-muted">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $archivo->fecha_subida->format('d/m/Y') }}
                                                </small>
                                            </p>
                                            <div class="d-grid">
                                                <a href="{{ $archivo->archivo_url }}" 
                                                   class="btn btn-outline-primary btn-sm" 
                                                   target="_blank">
                                                    <i class="fas fa-download me-1"></i>Descargar
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-file fa-3x text-muted mb-3"></i>
                            <h5>No hay archivos</h5>
                            <p class="text-muted">Este curso aún no tiene archivos adjuntos.</p>
                            <a href="{{ route('archivos.create', ['curso_id' => $curso->id]) }}" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Subir primer archivo
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.bg-blue { background-color: #007bff !important; }
.bg-purple { background-color: #6f42c1 !important; }
.bg-orange { background-color: #fd7e14 !important; }
.avatar-sm { width: 32px; height: 32px; font-size: 12px; }
.avatar-lg { width: 64px; height: 64px; font-size: 24px; }
</style>
@endsection