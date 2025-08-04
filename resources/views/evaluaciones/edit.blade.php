@extends('layouts.app')

@section('title', 'Editar Evaluación')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Editar Evaluación</h1>
            <p class="text-muted mb-0">Modifica la información de la evaluación</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Editar: Evaluación #{{ $evaluacion->id }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('evaluaciones.show', $evaluacion) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('evaluaciones.update', $evaluacion) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Información de la evaluación -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alumno_id" class="form-label">
                                    <i class="fas fa-user-graduate me-2"></i>Alumno <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('alumno_id') is-invalid @enderror"
                                        id="alumno_id"
                                        name="alumno_id"
                                        required>
                                    <option value="">Selecciona un alumno</option>
                                    @foreach($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}"
                                                {{ old('alumno_id', $evaluacion->alumno_id) == $alumno->id ? 'selected' : '' }}>
                                            {{ $alumno->apellido }}, {{ $alumno->nombre }} ({{ $alumno->dni }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('alumno_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="curso_id" class="form-label">
                                    <i class="fas fa-book me-2"></i>Curso <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('curso_id') is-invalid @enderror"
                                        id="curso_id"
                                        name="curso_id"
                                        required>
                                    <option value="">Selecciona un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}"
                                                {{ old('curso_id', $evaluacion->curso_id) == $curso->id ? 'selected' : '' }}
                                                data-docente="{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}">
                                            {{ $curso->titulo }} - {{ $curso->docente->apellido }}, {{ $curso->docente->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-clipboard me-2"></i>Descripción <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('descripcion') is-invalid @enderror" 
                                       id="descripcion" 
                                       name="descripcion" 
                                       value="{{ old('descripcion', $evaluacion->descripcion) }}" 
                                       placeholder="Ej: Examen Parcial, Trabajo Práctico, etc."
                                       required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="nota" class="form-label">
                                    <i class="fas fa-star me-2"></i>Nota <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('nota') is-invalid @enderror" 
                                       id="nota" 
                                       name="nota" 
                                       value="{{ old('nota', $evaluacion->nota) }}" 
                                       min="0"
                                       max="10"
                                       step="0.1"
                                       required>
                                @error('nota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    De 0 a 10 con un decimal
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha de Evaluación <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha') is-invalid @enderror" 
                                       id="fecha" 
                                       name="fecha" 
                                       value="{{ old('fecha', $evaluacion->fecha->format('Y-m-d')) }}" 
                                       required>
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-comment me-2"></i>Observaciones
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                          id="observaciones" 
                                          name="observaciones" 
                                          rows="3" 
                                          placeholder="Observaciones adicionales sobre la evaluación...">{{ old('observaciones', $evaluacion->observaciones) }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">


                        <!-- Información del alumno -->
                        <div class="card border-info mt-3" id="alumno_info" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Información del Alumno
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="alumno_details"></div>
                            </div>
                        </div>

                        <!-- Información del curso -->
                        <div class="card border-success mt-3" id="curso_info" style="display: none;">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>Información del Curso
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="curso_details"></div>
                            </div>
                        </div>

                        <!-- Información de la evaluación actual -->
                        <div class="card border-info mt-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Estado Actual
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-clipboard me-2 text-primary"></i>
                                        <strong>Descripción:</strong> {{ $evaluacion->descripcion }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-star me-2 text-warning"></i>
                                        <strong>Nota:</strong> 
                                        @if($evaluacion->nota >= 7)
                                            <span class="badge bg-success">{{ $evaluacion->nota }}</span>
                                        @elseif($evaluacion->nota >= 4)
                                            <span class="badge bg-warning">{{ $evaluacion->nota }}</span>
                                        @else
                                            <span class="badge bg-danger">{{ $evaluacion->nota }}</span>
                                        @endif
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-calendar me-2 text-secondary"></i>
                                        <strong>Fecha:</strong> {{ $evaluacion->fecha->format('d/m/Y') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        <strong>Alumno:</strong> {{ $evaluacion->alumno->nombre }} {{ $evaluacion->alumno->apellido }}
                                    </li>
                                    <li>
                                        <i class="fas fa-graduation-cap me-2 text-success"></i>
                                        <strong>Curso:</strong> {{ $evaluacion->curso->titulo }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Validaciones -->
                        <div class="card border-warning mt-3" id="validaciones" style="display: none;">
                            <div class="card-header bg-warning text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Validaciones
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="validaciones_details"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('evaluaciones.show', $evaluacion) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Evaluación
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const alumnoSelect = document.getElementById('alumno_id');
    const cursoSelect = document.getElementById('curso_id');
    const alumnoInfo = document.getElementById('alumno_info');
    const cursoInfo = document.getElementById('curso_info');
    const validaciones = document.getElementById('validaciones');
    const alumnoDetails = document.getElementById('alumno_details');
    const cursoDetails = document.getElementById('curso_details');
    const validacionesDetails = document.getElementById('validaciones_details');

    // Mostrar información del alumno seleccionado
    alumnoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const alumnoNombre = selectedOption.textContent;
            
            alumnoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Nombre:</strong> ${alumnoNombre}
                </div>
                <small class="text-muted">Alumno disponible para evaluación</small>
            `;
            alumnoInfo.style.display = 'block';
        } else {
            alumnoInfo.style.display = 'none';
        }
        validarEvaluacion();
    });

    // Mostrar información del curso seleccionado
    cursoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const cursoTitulo = selectedOption.textContent;
            const docente = selectedOption.getAttribute('data-docente');
            
            cursoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Título:</strong> ${cursoTitulo}
                </div>
                <div class="mb-2">
                    <strong>Docente:</strong> ${docente}
                </div>
                <small class="text-muted">Curso disponible para evaluación</small>
            `;
            cursoInfo.style.display = 'block';
        } else {
            cursoInfo.style.display = 'none';
        }
        validarEvaluacion();
    });

    // Validar la evaluación
    function validarEvaluacion() {
        let validacionesHTML = '';
        let hayProblemas = false;

        if (!alumnoSelect.value) {
            validacionesHTML += '<div class="alert alert-warning mb-2"><i class="fas fa-info-circle me-1"></i>Selecciona un alumno</div>';
        }

        if (!cursoSelect.value) {
            validacionesHTML += '<div class="alert alert-warning mb-2"><i class="fas fa-info-circle me-1"></i>Selecciona un curso</div>';
        }

        if (hayProblemas || validacionesHTML) {
            validacionesDetails.innerHTML = validacionesHTML;
            validaciones.style.display = 'block';
        } else {
            validaciones.style.display = 'none';
        }
    }

    // Trigger inicial para mostrar información si hay valores preseleccionados
    if (alumnoSelect.value) {
        alumnoSelect.dispatchEvent(new Event('change'));
    }
    if (cursoSelect.value) {
        cursoSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection