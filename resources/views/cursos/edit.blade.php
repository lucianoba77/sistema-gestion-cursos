@extends('layouts.app')

@section('title', 'Editar Curso')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Editar Curso</h1>
            <p class="text-muted mb-0">Modifica la información del curso</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        Editar: {{ $curso->titulo }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('cursos.show', $curso) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('cursos.update', $curso) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Información básica -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="titulo" class="form-label">
                                    <i class="fas fa-book me-2"></i>Título del Curso <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" 
                                       name="titulo" 
                                       value="{{ old('titulo', $curso->titulo) }}" 
                                       placeholder="Ej: Matemáticas Avanzadas"
                                       required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-align-left me-2"></i>Descripción <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('descripcion') is-invalid @enderror" 
                                          id="descripcion" 
                                          name="descripcion" 
                                          rows="4" 
                                          placeholder="Describe el contenido y objetivos del curso..."
                                          required>{{ old('descripcion', $curso->descripcion) }}</textarea>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inicio" class="form-label">
                                    <i class="fas fa-calendar-plus me-2"></i>Fecha de Inicio <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha_inicio') is-invalid @enderror" 
                                       id="fecha_inicio" 
                                       name="fecha_inicio" 
                                       value="{{ old('fecha_inicio', $curso->fecha_inicio->format('Y-m-d')) }}" 
                                       required>
                                @error('fecha_inicio')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_fin" class="form-label">
                                    <i class="fas fa-calendar-minus me-2"></i>Fecha de Fin <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha_fin') is-invalid @enderror" 
                                       id="fecha_fin" 
                                       name="fecha_fin" 
                                       value="{{ old('fecha_fin', $curso->fecha_fin->format('Y-m-d')) }}" 
                                       required>
                                @error('fecha_fin')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="modalidad" class="form-label">
                                    <i class="fas fa-chalkboard-teacher me-2"></i>Modalidad <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('modalidad') is-invalid @enderror" 
                                        id="modalidad" 
                                        name="modalidad" 
                                        required>
                                    <option value="">Selecciona una modalidad</option>
                                    <option value="presencial" {{ old('modalidad', $curso->modalidad) == 'presencial' ? 'selected' : '' }}>
                                        Presencial
                                    </option>
                                    <option value="virtual" {{ old('modalidad', $curso->modalidad) == 'virtual' ? 'selected' : '' }}>
                                        Virtual
                                    </option>
                                    <option value="hibrido" {{ old('modalidad', $curso->modalidad) == 'hibrido' ? 'selected' : '' }}>
                                        Híbrido
                                    </option>
                                </select>
                                @error('modalidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="estado" class="form-label">
                                    <i class="fas fa-toggle-on me-2"></i>Estado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('estado') is-invalid @enderror" 
                                        id="estado" 
                                        name="estado" 
                                        required>
                                    <option value="">Selecciona un estado</option>
                                    <option value="activo" {{ old('estado', $curso->estado) == 'activo' ? 'selected' : '' }}>
                                        Activo
                                    </option>
                                    <option value="finalizado" {{ old('estado', $curso->estado) == 'finalizado' ? 'selected' : '' }}>
                                        Finalizado
                                    </option>
                                    <option value="cancelado" {{ old('estado', $curso->estado) == 'cancelado' ? 'selected' : '' }}>
                                        Cancelado
                                    </option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cupos_maximos" class="form-label">
                                    <i class="fas fa-users me-2"></i>Cupos Máximos <span class="text-danger">*</span>
                                </label>
                                <input type="number" 
                                       class="form-control @error('cupos_maximos') is-invalid @enderror" 
                                       id="cupos_maximos" 
                                       name="cupos_maximos" 
                                       value="{{ old('cupos_maximos', $curso->cupos_maximos) }}" 
                                       min="{{ $curso->inscripciones->count() }}" 
                                       max="100"
                                       required>
                                @error('cupos_maximos')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($curso->inscripciones->count() > 0)
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Mínimo: {{ $curso->inscripciones->count() }} (alumnos ya inscritos)
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12 mb-3" id="aula_virtual_container" style="display: {{ in_array($curso->modalidad, ['virtual', 'hibrido']) ? 'block' : 'none' }};">
                                <label for="aula_virtual" class="form-label">
                                    <i class="fas fa-link me-2"></i>Enlace del Aula Virtual
                                </label>
                                <input type="url" 
                                       class="form-control @error('aula_virtual') is-invalid @enderror" 
                                       id="aula_virtual" 
                                       name="aula_virtual" 
                                       value="{{ old('aula_virtual', $curso->aula_virtual) }}" 
                                       placeholder="https://meet.google.com/... o https://zoom.us/j/...">
                                @error('aula_virtual')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Solo requerido para modalidades virtual e híbrida
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-tie me-2"></i>Asignar Docente
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="docente_id" class="form-label">
                                        Docente <span class="text-danger">*</span>
                                    </label>
                                    <select class="form-select @error('docente_id') is-invalid @enderror" 
                                            id="docente_id" 
                                            name="docente_id" 
                                            required>
                                        <option value="">Selecciona un docente</option>
                                        @foreach($docentes as $docente)
                                            <option value="{{ $docente->id }}" 
                                                    {{ old('docente_id', $curso->docente_id) == $docente->id ? 'selected' : '' }}
                                                    data-especialidad="{{ $docente->especialidad }}">
                                                {{ $docente->apellido }}, {{ $docente->nombre }} - {{ $docente->especialidad }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('docente_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div id="docente_info" class="alert alert-info" style="display: none;">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-info-circle me-2"></i>Información del Docente
                                    </h6>
                                    <div id="docente_details"></div>
                                </div>

                                @if($docentes->isEmpty())
                                    <div class="alert alert-warning">
                                        <i class="fas fa-exclamation-triangle me-2"></i>
                                        No hay docentes activos disponibles. 
                                        <a href="{{ route('docentes.create') }}" class="alert-link">Crear docente</a>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <!-- Información del curso actual -->
                        <div class="card border-info mt-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Estado Actual
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-circle me-2 text-{{ $curso->estado === 'activo' ? 'success' : ($curso->estado === 'finalizado' ? 'info' : 'danger') }}"></i>
                                        <strong>Estado:</strong> {{ ucfirst($curso->estado) }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-users me-2 text-primary"></i>
                                        <strong>Inscriptos:</strong> {{ $curso->inscripciones->count() }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-calendar me-2 text-warning"></i>
                                        <strong>Creado:</strong> {{ $curso->created_at->format('d/m/Y') }}
                                    </li>
                                    <li>
                                        <i class="fas fa-clock me-2 text-secondary"></i>
                                        <strong>Última actualización:</strong> {{ $curso->updated_at->format('d/m/Y H:i') }}
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Advertencias -->
                        @if($curso->inscripciones->count() > 0)
                            <div class="card border-warning mt-3">
                                <div class="card-header bg-warning text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-exclamation-triangle me-2"></i>Advertencias
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="alert alert-warning mb-0">
                                        <i class="fas fa-info-circle me-2"></i>
                                        <strong>¡Atención!</strong> Este curso tiene {{ $curso->inscripciones->count() }} alumnos inscritos. 
                                        Los cambios pueden afectar a los estudiantes.
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('cursos.show', $curso) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Actualizar Curso
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
    const modalidadSelect = document.getElementById('modalidad');
    const aulaVirtualContainer = document.getElementById('aula_virtual_container');
    const aulaVirtualInput = document.getElementById('aula_virtual');
    const docenteSelect = document.getElementById('docente_id');
    const docenteInfo = document.getElementById('docente_info');
    const docenteDetails = document.getElementById('docente_details');
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFin = document.getElementById('fecha_fin');

    // Mostrar/ocultar campo de aula virtual según modalidad
    modalidadSelect.addEventListener('change', function() {
        if (this.value === 'virtual' || this.value === 'hibrido') {
            aulaVirtualContainer.style.display = 'block';
            aulaVirtualInput.required = true;
        } else {
            aulaVirtualContainer.style.display = 'none';
            aulaVirtualInput.required = false;
            aulaVirtualInput.value = '';
        }
    });

    // Mostrar información del docente seleccionado
    docenteSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const especialidad = selectedOption.getAttribute('data-especialidad');
            docenteDetails.innerHTML = `
                <strong>Especialidad:</strong> ${especialidad}<br>
                <strong>Email:</strong> ${selectedOption.text.split(' - ')[0]}<br>
                <small class="text-muted">Docente activo y disponible</small>
            `;
            docenteInfo.style.display = 'block';
        } else {
            docenteInfo.style.display = 'none';
        }
    });

    // Validar que fecha fin sea posterior a fecha inicio
    fechaInicio.addEventListener('change', function() {
        fechaFin.min = this.value;
        if (fechaFin.value && fechaFin.value <= this.value) {
            fechaFin.value = '';
        }
    });

    fechaFin.addEventListener('change', function() {
        if (this.value <= fechaInicio.value) {
            alert('La fecha de fin debe ser posterior a la fecha de inicio');
            this.value = '';
        }
    });

    // Trigger inicial para mostrar campos según valores existentes
    if (modalidadSelect.value) {
        modalidadSelect.dispatchEvent(new Event('change'));
    }
    if (docenteSelect.value) {
        docenteSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection