@extends('layouts.app')

@section('title', 'Crear Nueva Evaluación')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Crear Nueva Evaluación</h1>
            <p class="text-muted mb-0">Registra una evaluación para un alumno</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Información de la Evaluación
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('evaluaciones.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Información de la evaluación -->
                    <div class="col-md-8">
                        <div class="row">
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
                                                {{ old('curso_id', request('curso_id')) == $curso->id ? 'selected' : '' }}
                                                data-docente="{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}"
                                                data-alumnos="{{ $curso->inscripciones_count }}">
                                            {{ $curso->titulo }} - {{ $curso->docente->apellido }}, {{ $curso->docente->nombre }} ({{ $curso->inscripciones_count }} alumnos)
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="alumno_id" class="form-label">
                                    <i class="fas fa-user-graduate me-2"></i>Alumno <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('alumno_id') is-invalid @enderror" 
                                        id="alumno_id" 
                                        name="alumno_id" 
                                        required 
                                        disabled>
                                    <option value="">Primero selecciona un curso</option>
                                </select>
                                @error('alumno_id')
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
                                       value="{{ old('descripcion') }}" 
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
                                       value="{{ old('nota') }}" 
                                       min="1" 
                                       max="10" 
                                       step="0.1"
                                       placeholder="1-10"
                                       required>
                                @error('nota')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha') is-invalid @enderror" 
                                       id="fecha" 
                                       name="fecha" 
                                       value="{{ old('fecha', date('Y-m-d')) }}" 
                                       max="{{ date('Y-m-d') }}"
                                       required>
                                @error('fecha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-comment me-2"></i>Observaciones
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                          id="observaciones" 
                                          name="observaciones" 
                                          rows="3"
                                          placeholder="Observaciones adicionales (opcional)">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral con información -->
                    <div class="col-md-4">
                        <!-- Información de la evaluación -->
                        <div class="card border-primary" id="evaluacion_info" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Evaluación
                                </h6>
                            </div>
                            <div class="card-body" id="evaluacion_details">
                                <!-- Se llena dinámicamente -->
                            </div>
                        </div>

                        <!-- Información del curso -->
                        <div class="card border-info" id="curso_info" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-book me-2"></i>Curso
                                </h6>
                            </div>
                            <div class="card-body" id="curso_details">
                                <!-- Se llena dinámicamente -->
                            </div>
                        </div>

                        <!-- Información del alumno -->
                        <div class="card border-success" id="alumno_info" style="display: none;">
                            <div class="card-header bg-success text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user-graduate me-2"></i>Alumno
                                </h6>
                            </div>
                            <div class="card-body" id="alumno_details">
                                <!-- Se llena dinámicamente -->
                            </div>
                        </div>

                        <!-- Validaciones -->
                        <div class="card border-warning" id="validaciones" style="display: none;">
                            <div class="card-header bg-warning text-dark">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Validaciones
                                </h6>
                            </div>
                            <div class="card-body" id="validaciones_details">
                                <!-- Se llena dinámicamente -->
                            </div>
                        </div>

                        <!-- Información adicional -->
                        <div class="card border-secondary mt-3">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Información Adicional
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Solo se pueden evaluar alumnos activos
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Solo se pueden evaluar cursos activos
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        La nota debe estar entre 1 y 10
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Se puede agregar observaciones opcionales
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        La fecha debe ser válida
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('evaluaciones.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Evaluación
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
    const evaluacionInfo = document.getElementById('evaluacion_info');
    const alumnoInfo = document.getElementById('alumno_info');
    const cursoInfo = document.getElementById('curso_info');
    const validaciones = document.getElementById('validaciones');
    const evaluacionDetails = document.getElementById('evaluacion_details');
    const alumnoDetails = document.getElementById('alumno_details');
    const cursoDetails = document.getElementById('curso_details');
    const validacionesDetails = document.getElementById('validaciones_details');

    // Función para actualizar información de la evaluación
    function updateEvaluacionInfo() {
        const alumnoOption = alumnoSelect.options[alumnoSelect.selectedIndex];
        const cursoOption = cursoSelect.options[cursoSelect.selectedIndex];
        
        if (alumnoSelect.value && cursoSelect.value) {
            const alumnoText = alumnoOption.text;
            const cursoText = cursoOption.text;
            const docente = cursoOption.getAttribute('data-docente');
            
            evaluacionDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Alumno:</strong> ${alumnoText}
                </div>
                <div class="mb-2">
                    <strong>Curso:</strong> ${cursoText}
                </div>
                <div class="mb-2">
                    <strong>Docente:</strong> ${docente}
                </div>
            `;
            evaluacionInfo.style.display = 'block';
        } else {
            evaluacionInfo.style.display = 'none';
        }
    }

    // Cargar alumnos cuando se selecciona un curso
    cursoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const cursoText = selectedOption.text;
            const docente = selectedOption.getAttribute('data-docente');
            const alumnosCount = selectedOption.getAttribute('data-alumnos');
            
            // Mostrar información del curso
            cursoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Curso:</strong> ${cursoText}
                </div>
                <div class="mb-2">
                    <strong>Docente:</strong> ${docente}
                </div>
                <div class="mb-2">
                    <strong>Alumnos inscritos:</strong> ${alumnosCount}
                </div>
                <div class="mb-2">
                    <strong>Estado:</strong> 
                    <span class="badge bg-success">Activo</span>
                </div>
            `;
            cursoInfo.style.display = 'block';
            
            // Cargar alumnos del curso
            console.log('Cargando alumnos para curso_id:', this.value);
            
            // Obtener el token CSRF del meta tag
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            console.log('CSRF Token:', token ? 'Presente' : 'Ausente');
            
            fetch(`/evaluaciones/alumnos-by-curso?curso_id=${this.value}`, {
                method: 'GET',
                credentials: 'same-origin',
                headers: {
                    'Accept': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': token
                }
            })
                .then(response => {
                    console.log('Response status:', response.status);
                    console.log('Response headers:', response.headers);
                    
                    if (!response.ok) {
                        throw new Error(`HTTP error! status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(alumnos => {
                    alumnoSelect.innerHTML = '<option value="">Selecciona un alumno</option>';
                    
                    if (alumnos.length === 0) {
                        alumnoSelect.innerHTML = '<option value="">No hay alumnos inscritos en este curso</option>';
                        alumnoSelect.disabled = true;
                    } else {
                        alumnos.forEach(alumno => {
                            const option = document.createElement('option');
                            option.value = alumno.id;
                            option.textContent = `${alumno.apellido}, ${alumno.nombre}`;
                            option.setAttribute('data-dni', alumno.dni);
                            option.setAttribute('data-email', alumno.email);
                            alumnoSelect.appendChild(option);
                        });
                        alumnoSelect.disabled = false;
                    }
                })
                .catch(error => {
                    console.error('Error cargando alumnos:', error);
                    console.error('Error details:', error.message);
                    alumnoSelect.innerHTML = '<option value="">Error cargando alumnos: ' + error.message + '</option>';
                    alumnoSelect.disabled = true;
                });
        } else {
            cursoInfo.style.display = 'none';
            alumnoSelect.innerHTML = '<option value="">Primero selecciona un curso</option>';
            alumnoSelect.disabled = true;
        }
        updateEvaluacionInfo();
    });

    // Mostrar información del alumno seleccionado
    alumnoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        
        if (this.value) {
            const alumnoText = selectedOption.text;
            const dni = selectedOption.getAttribute('data-dni');
            const email = selectedOption.getAttribute('data-email');
            
            alumnoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Alumno:</strong> ${alumnoText}
                </div>
                <div class="mb-2">
                    <strong>DNI:</strong> ${dni}
                </div>
                <div class="mb-2">
                    <strong>Email:</strong> ${email}
                </div>
                <div class="mb-2">
                    <strong>Estado:</strong> 
                    <span class="badge bg-success">Activo</span>
                </div>
            `;
            alumnoInfo.style.display = 'block';
        } else {
            alumnoInfo.style.display = 'none';
        }
        updateEvaluacionInfo();
    });

    // Validaciones en tiempo real
    function validateForm() {
        const errors = [];
        
        if (!cursoSelect.value) {
            errors.push('Debe seleccionar un curso');
        }
        
        if (!alumnoSelect.value) {
            errors.push('Debe seleccionar un alumno');
        }
        
        if (errors.length > 0) {
            validacionesDetails.innerHTML = `
                <div class="alert alert-warning mb-0">
                    <ul class="mb-0">
                        ${errors.map(error => `<li>${error}</li>`).join('')}
                    </ul>
                </div>
            `;
            validaciones.style.display = 'block';
        } else {
            validaciones.style.display = 'none';
        }
    }

    // Ejecutar validaciones cuando cambien los selects
    cursoSelect.addEventListener('change', validateForm);
    alumnoSelect.addEventListener('change', validateForm);
    
    // Validación inicial
    validateForm();
});
</script>
@endsection