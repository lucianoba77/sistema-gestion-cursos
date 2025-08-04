@extends('layouts.app')

@section('title', 'Crear Nuevo Docente')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Crear Nuevo Docente</h1>
            <p class="text-muted mb-0">Completa la información del docente</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-plus-circle me-2 text-primary"></i>
                        Información del Docente
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('docentes.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <!-- Información personal -->
                    <div class="col-md-8">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('nombre') is-invalid @enderror" 
                                       id="nombre" 
                                       name="nombre" 
                                       value="{{ old('nombre') }}" 
                                       placeholder="Ej: Juan Carlos"
                                       required>
                                @error('nombre')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">
                                    <i class="fas fa-user me-2"></i>Apellido <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('apellido') is-invalid @enderror" 
                                       id="apellido" 
                                       name="apellido" 
                                       value="{{ old('apellido') }}" 
                                       placeholder="Ej: Rodríguez"
                                       required>
                                @error('apellido')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">
                                    <i class="fas fa-id-card me-2"></i>DNI <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('dni') is-invalid @enderror" 
                                       id="dni" 
                                       name="dni" 
                                       value="{{ old('dni') }}" 
                                       placeholder="Ej: 12345678"
                                       maxlength="8"
                                       required>
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="especialidad" class="form-label">
                                    <i class="fas fa-graduation-cap me-2"></i>Especialidad <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('especialidad') is-invalid @enderror" 
                                       id="especialidad" 
                                       name="especialidad" 
                                       value="{{ old('especialidad') }}" 
                                       placeholder="Ej: Matemáticas"
                                       required>
                                @error('especialidad')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Email <span class="text-danger">*</span>
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email') }}" 
                                       placeholder="Ej: juan.rodriguez@email.com"
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="tel" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono') }}" 
                                       placeholder="Ej: 011-1234-5678"
                                       required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="direccion" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Dirección <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" 
                                          name="direccion" 
                                          rows="3" 
                                          placeholder="Ej: Av. Corrientes 1234, CABA"
                                          required>{{ old('direccion') }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <!-- Información adicional -->
                        <div class="card border-secondary">
                            <div class="card-header bg-secondary text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Información Adicional
                                </h6>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled mb-0">
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        El docente se creará con estado "Activo"
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Podrá ser asignado a cursos inmediatamente
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Se validará que el DNI y email sean únicos
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Máximo 3 cursos activos por docente
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Validaciones -->
                        <div class="card border-info mt-3">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-shield-alt me-2"></i>Validaciones
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>DNI:</strong> 8 dígitos numéricos
                                    </small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Email:</strong> Formato válido requerido
                                    </small>
                                </div>
                                <div class="mb-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Teléfono:</strong> Formato: 011-1234-5678
                                    </small>
                                </div>
                                <div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        <strong>Especialidad:</strong> Campo obligatorio
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de acción -->
                <div class="row mt-4">
                    <div class="col-12">
                        <hr>
                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ route('docentes.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Crear Docente
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
    const dniInput = document.getElementById('dni');
    const telefonoInput = document.getElementById('telefono');

    // Validar DNI (solo números, máximo 8 dígitos)
    dniInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
        if (this.value.length > 8) {
            this.value = this.value.slice(0, 8);
        }
    });

    // Formatear teléfono
    telefonoInput.addEventListener('input', function() {
        let value = this.value.replace(/[^0-9]/g, '');
        if (value.length >= 10) {
            value = value.slice(0, 2) + '-' + value.slice(2, 6) + '-' + value.slice(6, 10);
        } else if (value.length >= 6) {
            value = value.slice(0, 2) + '-' + value.slice(2, 6) + '-' + value.slice(6);
        } else if (value.length >= 2) {
            value = value.slice(0, 2) + '-' + value.slice(2);
        }
        this.value = value;
    });
});
</script>
@endsection