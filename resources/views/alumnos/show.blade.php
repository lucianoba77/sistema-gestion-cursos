@extends('layouts.app')

@section('title', 'Detalles del Alumno')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Detalles del Alumno</h1>
            <p class="text-muted mb-0">Información completa del alumno</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-user-graduate me-2 text-primary"></i>
                        {{ $alumno->nombre_completo }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('alumnos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                    <a href="{{ route('alumnos.edit', $alumno) }}" class="btn btn-primary">
                        <i class="fas fa-edit me-2"></i>Editar
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <!-- Información personal -->
                <div class="col-md-6">
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-user me-2"></i>Información Personal
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Nombre:</strong></div>
                                <div class="col-sm-8">{{ $alumno->nombre }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Apellido:</strong></div>
                                <div class="col-sm-8">{{ $alumno->apellido }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>DNI:</strong></div>
                                <div class="col-sm-8">{{ $alumno->dni }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Email:</strong></div>
                                <div class="col-sm-8">{{ $alumno->email }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Fecha de Nacimiento:</strong></div>
                                <div class="col-sm-8">{{ $alumno->fecha_nacimiento->format('d/m/Y') }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Edad:</strong></div>
                                <div class="col-sm-8">{{ $alumno->edad }} años</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Género:</strong></div>
                                <div class="col-sm-8">
                                    <span class="badge bg-info">{{ ucfirst($alumno->genero) }}</span>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Teléfono:</strong></div>
                                <div class="col-sm-8">{{ $alumno->telefono }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Dirección:</strong></div>
                                <div class="col-sm-8">{{ $alumno->direccion }}</div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-4"><strong>Estado:</strong></div>
                                <div class="col-sm-8">
                                    @if($alumno->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="col-md-6">
                    <div class="card border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-chart-bar me-2"></i>Estadísticas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <h4 class="text-primary">{{ $alumno->inscripciones->count() }}</h4>
                                        <small class="text-muted">Total Inscripciones</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <h4 class="text-success">{{ $alumno->inscripciones->where('estado', 'aprobado')->count() }}</h4>
                                        <small class="text-muted">Cursos Aprobados</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="text-center">
                                        <h4 class="text-warning">{{ $alumno->inscripciones->where('estado', 'activo')->count() }}</h4>
                                        <small class="text-muted">Cursos Activos</small>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="text-center">
                                                                        <h4 class="text-danger">{{ $alumno->inscripciones->where('estado', 'desaprobado')->count() }}</h4>
                                <small class="text-muted">Cursos Desaprobados</small>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div class="text-center">
                                        <h4 class="text-info">{{ $alumno->evaluaciones->count() }}</h4>
                                        <small class="text-muted">Total Evaluaciones</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Acciones rápidas -->
                    <div class="card border-warning mt-3">
                        <div class="card-header bg-warning text-white">
                            <h6 class="mb-0">
                                <i class="fas fa-bolt me-2"></i>Acciones Rápidas
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="d-grid gap-2">
                                @if($alumno->activo)
                                    <a href="{{ route('inscripciones.create') }}?alumno_id={{ $alumno->id }}" class="btn btn-outline-primary btn-sm">
                                        <i class="fas fa-plus me-2"></i>Inscribir a Curso
                                    </a>
                                    <a href="{{ route('evaluaciones.create') }}?alumno_id={{ $alumno->id }}" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-clipboard-check me-2"></i>Crear Evaluación
                                    </a>
                                @endif
                                <form action="{{ route('alumnos.toggle-status', $alumno) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-{{ $alumno->activo ? 'danger' : 'success' }} btn-sm w-100">
                                        <i class="fas fa-{{ $alumno->activo ? 'ban' : 'check' }} me-2"></i>
                                        {{ $alumno->activo ? 'Desactivar' : 'Activar' }}
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pestañas -->
            <div class="row mt-4">
                <div class="col-12">
                    <ul class="nav nav-tabs" id="alumnoTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="inscripciones-tab" data-bs-toggle="tab" data-bs-target="#inscripciones" type="button" role="tab">
                                <i class="fas fa-graduation-cap me-2"></i>Inscripciones
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="evaluaciones-tab" data-bs-toggle="tab" data-bs-target="#evaluaciones" type="button" role="tab">
                                <i class="fas fa-clipboard-check me-2"></i>Evaluaciones
                            </button>
                        </li>
                    </ul>

                    <div class="tab-content" id="alumnoTabsContent">
                        <!-- Pestaña Inscripciones -->
                        <div class="tab-pane fade show active" id="inscripciones" role="tabpanel">
                            <div class="card border-0">
                                <div class="card-body">
                                    @if($alumno->inscripciones->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Curso</th>
                                                        <th>Docente</th>
                                                        <th>Fecha Inscripción</th>
                                                        <th>Estado</th>
                                                        <th>Nota Final</th>
                                                        <th>Asistencias</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($alumno->inscripciones as $inscripcion)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('cursos.show', $inscripcion->curso) }}" class="text-decoration-none">
                                                                    {{ $inscripcion->curso->titulo }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $inscripcion->curso->docente->nombre_completo }}</td>
                                                            <td>{{ $inscripcion->fecha_inscripcion->format('d/m/Y') }}</td>
                                                            <td>
                                                                @if($inscripcion->estado === 'activo')
                                                                    <span class="badge bg-warning">Activo</span>
                                                                @elseif($inscripcion->estado === 'aprobado')
                                                                    <span class="badge bg-success">Aprobado</span>
                                                                @else
                                                                    <span class="badge bg-danger">Desaprobado</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($inscripcion->nota_final)
                                                                    <span class="badge bg-info">{{ $inscripcion->nota_final }}</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>{{ $inscripcion->asistencias }}</td>
                                                            <td>
                                                                <a href="{{ route('inscripciones.show', $inscripcion) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('inscripciones.edit', $inscripcion) }}" class="btn btn-sm btn-outline-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-graduation-cap fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No hay inscripciones</h5>
                                            <p class="text-muted">Este alumno aún no se ha inscrito a ningún curso.</p>
                                            @if($alumno->activo)
                                                <a href="{{ route('inscripciones.create') }}?alumno_id={{ $alumno->id }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Inscribir a Curso
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Pestaña Evaluaciones -->
                        <div class="tab-pane fade" id="evaluaciones" role="tabpanel">
                            <div class="card border-0">
                                <div class="card-body">
                                    @if($alumno->evaluaciones->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Curso</th>
                                                        <th>Descripción</th>
                                                        <th>Nota</th>
                                                        <th>Fecha</th>
                                                        <th>Acciones</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($alumno->evaluaciones as $evaluacion)
                                                        <tr>
                                                            <td>
                                                                <a href="{{ route('cursos.show', $evaluacion->curso) }}" class="text-decoration-none">
                                                                    {{ $evaluacion->curso->titulo }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $evaluacion->descripcion }}</td>
                                                            <td>
                                                                <span class="badge bg-{{ $evaluacion->nota >= 7 ? 'success' : ($evaluacion->nota >= 4 ? 'warning' : 'danger') }}">
                                                                    {{ $evaluacion->nota }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $evaluacion->fecha->format('d/m/Y') }}</td>
                                                            <td>
                                                                <a href="{{ route('evaluaciones.show', $evaluacion) }}" class="btn btn-sm btn-outline-primary">
                                                                    <i class="fas fa-eye"></i>
                                                                </a>
                                                                <a href="{{ route('evaluaciones.edit', $evaluacion) }}" class="btn btn-sm btn-outline-warning">
                                                                    <i class="fas fa-edit"></i>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <div class="text-center py-4">
                                            <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                                            <h5 class="text-muted">No hay evaluaciones</h5>
                                            <p class="text-muted">Este alumno aún no tiene evaluaciones registradas.</p>
                                            @if($alumno->activo && $alumno->inscripciones->where('estado', 'activo')->count() > 0)
                                                <a href="{{ route('evaluaciones.create') }}?alumno_id={{ $alumno->id }}" class="btn btn-primary">
                                                    <i class="fas fa-plus me-2"></i>Crear Evaluación
                                                </a>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 