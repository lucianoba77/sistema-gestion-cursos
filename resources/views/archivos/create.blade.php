@extends('layouts.app')

@section('title', 'Subir Archivo Adjunto')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Subir Archivo Adjunto</h1>
            <p class="text-muted mb-0">Adjunta un archivo al sistema</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Información del Archivo
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('archivos.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('archivos.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="row">
                    <!-- Información del archivo -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="archivo" class="form-label">
                                    <i class="fas fa-upload me-2"></i>Seleccionar Archivo <span class="text-danger">*</span>
                                </label>
                                <input type="file" 
                                       class="form-control @error('archivo') is-invalid @enderror" 
                                       id="archivo" 
                                       name="archivo" 
                                       accept=".pdf,.docx,.ppt,.jpg,.jpeg,.png"
                                       required>
                                @error('archivo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Formatos permitidos: PDF, DOCX, PPT, JPG, PNG (Máximo 10MB)
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="titulo" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Título <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('titulo') is-invalid @enderror" 
                                       id="titulo" 
                                       name="titulo" 
                                       value="{{ old('titulo') }}" 
                                       placeholder="Ej: Guía de Álgebra, Tarea de Cálculo, etc."
                                       required>
                                @error('titulo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-folder me-2"></i>Tipo <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Selecciona un tipo</option>
                                    <option value="material">Material</option>
                                    <option value="tarea">Tarea</option>
                                    <option value="guia">Guía</option>
                                </select>
                                @error('tipo')
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
                                                {{ old('curso_id') == $curso->id ? 'selected' : '' }}
                                                data-docente="{{ $curso->docente->nombre }} {{ $curso->docente->apellido }}"
                                                data-modalidad="{{ $curso->modalidad }}">
                                            {{ $curso->titulo }} - {{ $curso->docente->nombre }} {{ $curso->docente->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
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
                                          placeholder="Observaciones adicionales sobre el archivo...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <!-- Información del archivo seleccionado -->
                        <div class="card border-primary" id="archivo_info" style="display: none;">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-file me-2"></i>Información del Archivo
                                </h6>
                            </div>
                            <div class="card-body">
                                <div id="archivo_details"></div>
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
                                        Tamaño máximo: 10MB
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Formatos seguros permitidos
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        <strong>Todos los archivos se asocian a un curso</strong>
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Título y curso obligatorios
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
                            <a href="{{ route('archivos.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-upload me-2"></i>Subir Archivo
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
    const archivoInput = document.getElementById('archivo');
    const tipoSelect = document.getElementById('tipo');
    const cursoSelect = document.getElementById('curso_id');
    const archivoInfo = document.getElementById('archivo_info');
    const archivoDetails = document.getElementById('archivo_details');
    const cursoInfo = document.getElementById('curso_info');
    const cursoDetails = document.getElementById('curso_details');
    const validaciones = document.getElementById('validaciones');
    const validacionesDetails = document.getElementById('validaciones_details');

    // Mostrar información del curso seleccionado
    cursoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        if (this.value) {
            const docente = selectedOption.getAttribute('data-docente');
            const modalidad = selectedOption.getAttribute('data-modalidad');
            
            cursoDetails.innerHTML = `
                <div class="mb-2">
                    <strong>Docente:</strong> ${docente}
                </div>
                <div class="mb-2">
                    <strong>Modalidad:</strong> ${modalidad}
                </div>
                <small class="text-muted">Archivo asociado al curso</small>
            `;
            cursoInfo.style.display = 'block';
        } else {
            cursoInfo.style.display = 'none';
        }
        validarArchivo();
    });

    // Validar el archivo
    function validarArchivo() {
        const file = archivoInput.files[0];
        const tipo = tipoSelect.value;
        const curso = cursoSelect.value;
        
        let validacionesHTML = '';
        let hayProblemas = false;

        if (file) {
            const sizeInMB = file.size / (1024 * 1024);
            
            if (sizeInMB > 10) {
                validacionesHTML += '<div class="alert alert-danger mb-2"><i class="fas fa-exclamation-triangle me-1"></i>El archivo es muy grande (máximo 10MB)</div>';
                hayProblemas = true;
            }

            if (sizeInMB > 8) {
                validacionesHTML += '<div class="alert alert-warning mb-2"><i class="fas fa-info-circle me-1"></i>El archivo es grande, puede tardar en subirse</div>';
            }
        }

        if (!curso) {
            validacionesHTML += '<div class="alert alert-warning mb-2"><i class="fas fa-info-circle me-1"></i>Selecciona un curso (obligatorio para todos los archivos)</div>';
        }

        if (hayProblemas || validacionesHTML) {
            validacionesDetails.innerHTML = validacionesHTML;
            validaciones.style.display = 'block';
        } else {
            validaciones.style.display = 'none';
        }
    }

    // Trigger inicial para mostrar información si hay valores preseleccionados
    if (tipoSelect.value) {
        tipoSelect.dispatchEvent(new Event('change'));
    }
    if (cursoSelect.value) {
        cursoSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection