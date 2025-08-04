@extends('layouts.app')

@section('title', 'Editar Archivo')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.png') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Editar Archivo</h1>
            <p class="text-muted mb-0">Modificar información del archivo adjunto</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        {{ $archivo->nombre_archivo }}
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
            <form action="{{ route('archivos.update', $archivo) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <!-- Información del archivo -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="archivo" class="form-label">
                                    <i class="fas fa-upload me-2"></i>Nuevo Archivo (opcional)
                                </label>
                                <input type="file" 
                                       class="form-control @error('archivo') is-invalid @enderror" 
                                       id="archivo" 
                                       name="archivo" 
                                       accept=".pdf,.docx,.ppt,.jpg,.jpeg,.png">
                                @error('archivo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Deja vacío para mantener el archivo actual. Formatos permitidos: PDF, DOCX, DOC, PPT, JPG, PNG (Máximo 10MB)
                                </div>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Descripción <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('descripcion') is-invalid @enderror" 
                                       id="descripcion" 
                                       name="descripcion" 
                                       value="{{ old('descripcion', $archivo->titulo) }}" 
                                       placeholder="Ej: Material de estudio, Evaluación, etc."
                                       required>
                                @error('descripcion')
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
                                    <option value="material" {{ old('tipo', $archivo->tipo) == 'material' ? 'selected' : '' }}>Material</option>
                                    <option value="tarea" {{ old('tipo', $archivo->tipo) == 'tarea' ? 'selected' : '' }}>Tarea</option>
                                    <option value="guia" {{ old('tipo', $archivo->tipo) == 'guia' ? 'selected' : '' }}>Guía</option>
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
                                                {{ old('curso_id', $archivo->curso_id) == $curso->id ? 'selected' : '' }}
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
                                          placeholder="Observaciones adicionales sobre el archivo...">{{ old('observaciones', $archivo->observaciones) }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <!-- Información del archivo actual -->
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-file me-2"></i>Archivo Actual
                                </h6>
                            </div>
                            <div class="card-body text-center">
                                <i class="{{ $archivo->icono }} fa-3x mb-3"></i>
                                <h6>{{ $archivo->nombre_archivo }}</h6>
                                <p class="text-muted">{{ $archivo->tamaño_formateado }}</p>
                                <small class="text-muted">{{ strtoupper($archivo->extension) }}</small>
                            </div>
                        </div>

                        <!-- Información de asociación actual -->
                        @if($archivo->curso)
                            <div class="card border-info mt-3">
                                <div class="card-header bg-info text-white">
                                    <h6 class="mb-0">
                                        <i class="fas fa-link me-2"></i>Asociación Actual
                                    </h6>
                                </div>
                                <div class="card-body">
                                    <div class="mb-2">
                                        <strong>Curso:</strong> {{ $archivo->curso->titulo }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Docente:</strong> {{ $archivo->curso->docente->nombre_completo }}
                                    </div>
                                    <small class="text-muted">
                                        @if($archivo->tipo === 'evaluacion')
                                            Archivo de evaluación del curso
                                        @else
                                            Archivo asociado al curso
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @endif

                        <!-- Validaciones -->
                        <div class="card border-warning mt-3">
                            <div class="card-header bg-warning text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-exclamation-triangle me-2"></i>Validaciones
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Solo formatos: PDF, DOCX, PPT, JPG, PNG
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Tamaño máximo: 10MB
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Descripción obligatoria
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Solo admin/coordinador
                                    </li>
                                </ul>
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
                                        <i class="fas fa-clock text-info me-2"></i>
                                        Subido: {{ $archivo->created_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-edit text-info me-2"></i>
                                        Modificado: {{ $archivo->updated_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li>
                                        <i class="fas fa-id-badge text-info me-2"></i>
                                        ID: {{ $archivo->id }}
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
                                <i class="fas fa-save me-2"></i>Guardar Cambios
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
    const tipoSelect = document.getElementById('tipo');
    const cursoContainer = document.getElementById('curso_container');
    const cursoSelect = document.getElementById('curso_id');

    // Mostrar/ocultar campos según el tipo seleccionado
    tipoSelect.addEventListener('change', function() {
        if (this.value === 'tarea' || this.value === 'guia') {
            cursoContainer.style.display = 'block';
        } else {
            cursoContainer.style.display = 'none';
        }
    });

    // Validar el archivo
    archivoInput.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const sizeInMB = file.size / (1024 * 1024);
            
            if (sizeInMB > 10) {
                alert('El archivo es muy grande. El tamaño máximo es 10MB.');
                this.value = '';
                return;
            }

            const extension = file.name.split('.').pop().toLowerCase();
            const allowedExtensions = ['pdf', 'docx', 'ppt', 'jpg', 'jpeg', 'png'];
            
            if (!allowedExtensions.includes(extension)) {
                alert('Formato de archivo no permitido. Solo se permiten: PDF, DOCX, PPT, JPG, PNG');
                this.value = '';
                return;
            }
        }
    });

    // Trigger inicial para mostrar campos si hay valores preseleccionados
    if (tipoSelect.value) {
        tipoSelect.dispatchEvent(new Event('change'));
    }
});
</script>
@endsection 