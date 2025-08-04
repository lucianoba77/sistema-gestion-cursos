@extends('layouts.app')

@section('title', 'Crear Nueva Inscripción')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Crear Nueva Inscripción</h1>
            <p class="text-muted mb-0">Inscribe un alumno en un curso</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Información de la Inscripción
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('inscripciones.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Información de la inscripción -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="alumno_id" class="form-label">
                                    <i class="fas fa-user me-2"></i>Alumno <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('alumno_id') is-invalid @enderror" 
                                        id="alumno_id" 
                                        name="alumno_id" 
                                        required>
                                    <option value="">Selecciona un alumno</option>
                                    @foreach($alumnos as $alumno)
                                        <option value="{{ $alumno->id }}" 
                                                {{ old('alumno_id', request('alumno_id')) == $alumno->id ? 'selected' : '' }}
                                                data-email="{{ $alumno->email }}"
                                                data-telefono="{{ $alumno->telefono }}">
                                            {{ $alumno->apellido }}, {{ $alumno->nombre }} - {{ $alumno->dni }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('alumno_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="curso_id" class="form-label">
                                    <i class="fas fa-graduation-cap me-2"></i>Curso <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('curso_id') is-invalid @enderror" 
                                        id="curso_id" 
                                        name="curso_id" 
                                        required>
                                    <option value="">Selecciona un curso</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" 
                                                {{ old('curso_id', request('curso_id')) == $curso->id ? 'selected' : '' }}
                                                data-cupos="{{ $curso->cupos_maximos }}"
                                                data-inscriptos="{{ $curso->inscripciones->count() }}"
                                                data-docente="{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}"
                                                data-modalidad="{{ $curso->modalidad }}"
                                                data-fechas="{{ $curso->fecha_inicio->format('d/m/Y') }} - {{ $curso->fecha_fin->format('d/m/Y') }}">
                                            {{ $curso->titulo }} - {{ $curso->docente->nombre }} {{ $curso->docente->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_inscripcion" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha de Inscripción <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha_inscripcion') is-invalid @enderror" 
                                       id="fecha_inscripcion" 
                                       name="fecha_inscripcion" 
                                       value="{{ old('fecha_inscripcion', date('Y-m-d')) }}" 
                                       required>
                                @error('fecha_inscripcion')
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
                                    <option value="activo" {{ old('estado') == 'activo' ? 'selected' : '' }}>Activo</option>
                                    <option value="aprobado" {{ old('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="desaprobado" {{ old('estado') == 'desaprobado' ? 'selected' : '' }}>Desaprobado</option>
                                </select>
                                @error('estado')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="asistencias" class="form-label">
                                    <i class="fas fa-calendar-check me-2"></i>Asistencias
                                </label>
                                <input type="number" 
                                       class="form-control @error('asistencias') is-invalid @enderror" 
                                       id="asistencias" 
                                       name="asistencias" 
                                       value="{{ old('asistencias', 0) }}" 
                                       min="0"
                                       max="20">
                                @error('asistencias')
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
                                          placeholder="Observaciones adicionales sobre la inscripción...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <!-- Información del alumno seleccionado -->
                        <div class="card border-primary" id="alumno_info" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-user me-2"></i>Información del Alumno
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="alumno_details"></div>
                            </div>
                        </div>

                        <!-- Información del curso seleccionado -->
                        <div class="card border-info mt-3" id="curso_info" style="display: none;">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-graduation-cap me-2"></i>Información del Curso
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="curso_details"></div>
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
                                        La inscripción se creará con estado "Activo"
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Se validará la disponibilidad de cupos
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Se verificará que el alumno no esté ya inscrito
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Se controlará que el curso esté activo
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
                            <a href="{{ route('inscripciones.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Inscripción
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
            const email = selectedOption.getAttribute('data-email');
            const telefono = selectedOption.getAttribute('data-telefono');
            alumnoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Email:</strong> ${email}
                </div>
                <div class="mb-2">
                    <strong>Teléfono:</strong> ${telefono}
                </div>
                <small class="text-muted">Alumno activo y disponible</small>
            `;
            alumnoInfo.style.display = 'block';
        } else {
            alumnoInfo.style.display = 'none';
        }
        validarInscripcion();
    });

    // Mostrar información del curso seleccionado
    cursoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const cupos = selectedOption.getAttribute('data-cupos');
            const inscriptos = selectedOption.getAttribute('data-inscriptos');
            const docente = selectedOption.getAttribute('data-docente');
            const modalidad = selectedOption.getAttribute('data-modalidad');
            const fechas = selectedOption.getAttribute('data-fechas');
            const cuposDisponibles = parseInt(cupos) - parseInt(inscriptos);
            
            cursoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Docente:</strong> ${docente}
                </div>
                <div class="mb-2">
                    <strong>Modalidad:</strong> ${modalidad}
                </div>
                <div class="mb-2">
                    <strong>Fechas:</strong> ${fechas}
                </div>
                <div class="mb-2">
                    <strong>Cupos:</strong> ${inscriptos}/${cupos} (${cuposDisponibles} disponibles)
                </div>
            `;
            cursoInfo.style.display = 'block';
        } else {
            cursoInfo.style.display = 'none';
        }
        validarInscripcion();
    });

    // Validar la inscripción
    function validarInscripcion() {
        if (alumnoSelect.value && cursoSelect.value) {
            const cursoOption = cursoSelect.options[cursoSelect.selectedIndex];
            const cupos = parseInt(cursoOption.getAttribute('data-cupos'));
            const inscriptos = parseInt(cursoOption.getAttribute('data-inscriptos'));
            const cuposDisponibles = cupos - inscriptos;
            
            let validacionesHTML = '';
            let hayProblemas = false;

            if (cuposDisponibles <= 0) {
                validacionesHTML += '<div class="alert alert-danger mb-2"><i class="fas fa-exclamation-triangle me-1"></i>No hay cupos disponibles</div>';
                hayProblemas = true;
            }

            if (cuposDisponibles <= 2) {
                validacionesHTML += '<div class="alert alert-warning mb-2"><i class="fas fa-info-circle me-1"></i>Quedan pocos cupos disponibles</div>';
            }

            if (hayProblemas) {
                validacionesDetails.innerHTML = validacionesHTML;
                validaciones.style.display = 'block';
            } else {
                validaciones.style.display = 'none';
            }
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