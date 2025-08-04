@extends('layouts.app')

@section('title', 'Editar Alumno')

@section('content')
<div class="container-fluid">
    <!-- Header con logo y título -->
    <div class="d-flex align-items-center mb-4">
        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="me-3" style="height: 50px; margin-top: 10px; margin-bottom: 10px;">
        <div>
            <h1 class="h3 mb-0">Editar Alumno</h1>
            <p class="text-muted mb-0">Modificar información del alumno</p>
        </div>
    </div>

    <!-- Tarjeta principal -->
    <div class="card shadow-sm">
        <div class="card-header bg-white">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-edit me-2 text-primary"></i>
                        {{ $alumno->nombre_completo }}
                    </h5>
                </div>
                <div class="col-md-6 text-end">
                    <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Volver
                    </a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <form action="{{ route('alumnos.update', $alumno) }}" method="POST">
                @csrf
                @method('PUT')
                
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
                                       value="{{ old('nombre', $alumno->nombre) }}" 
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
                                       value="{{ old('apellido', $alumno->apellido) }}" 
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
                                       value="{{ old('dni', $alumno->dni) }}" 
                                       placeholder="12345678"
                                       required>
                                @error('dni')
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
                                       value="{{ old('email', $alumno->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">
                                    <i class="fas fa-calendar me-2"></i>Fecha de Nacimiento <span class="text-danger">*</span>
                                </label>
                                <input type="date" 
                                       class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                       id="fecha_nacimiento" 
                                       name="fecha_nacimiento" 
                                       value="{{ old('fecha_nacimiento', $alumno->fecha_nacimiento->format('Y-m-d')) }}" 
                                       required>
                                @error('fecha_nacimiento')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">
                                    <i class="fas fa-phone me-2"></i>Teléfono <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('telefono') is-invalid @enderror" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="{{ old('telefono', $alumno->telefono) }}" 
                                       placeholder="+54 11 1234-5678"
                                       required>
                                @error('telefono')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="genero" class="form-label">
                                    <i class="fas fa-venus-mars me-2"></i>Género <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('genero') is-invalid @enderror" 
                                        id="genero" 
                                        name="genero" 
                                        required>
                                    <option value="">Selecciona un género</option>
                                    <option value="masculino" {{ old('genero', $alumno->genero) == 'masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="femenino" {{ old('genero', $alumno->genero) == 'femenino' ? 'selected' : '' }}>Femenino</option>
                                    <option value="otro" {{ old('genero', $alumno->genero) == 'otro' ? 'selected' : '' }}>Otro</option>
                                </select>
                                @error('genero')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="activo" class="form-label">
                                    <i class="fas fa-toggle-on me-2"></i>Estado
                                </label>
                                <div class="form-check form-switch">
                                    <input class="form-check-input" 
                                           type="checkbox" 
                                           id="activo" 
                                           name="activo" 
                                           value="1" 
                                           {{ old('activo', $alumno->activo) ? 'checked' : '' }}>
                                    <label class="form-check-label" for="activo">
                                        Alumno activo
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="direccion" class="form-label">
                                    <i class="fas fa-map-marker-alt me-2"></i>Dirección <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('direccion') is-invalid @enderror" 
                                          id="direccion" 
                                          name="direccion" 
                                          rows="3" 
                                          required>{{ old('direccion', $alumno->direccion) }}</textarea>
                                @error('direccion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Panel lateral -->
                    <div class="col-md-4">
                        <!-- Información actual -->
                        <div class="card border-info">
                            <div class="card-header bg-info text-white">
                                <h6 class="mb-0">
                                    <i class="fas fa-info-circle me-2"></i>Información Actual
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="mb-2">
                                    <strong>Edad:</strong> {{ $alumno->edad }} años
                                </div>
                                <div class="mb-2">
                                    <strong>Estado:</strong> 
                                    @if($alumno->activo)
                                        <span class="badge bg-success">Activo</span>
                                    @else
                                        <span class="badge bg-danger">Inactivo</span>
                                    @endif
                                </div>
                                <div class="mb-2">
                                    <strong>Inscripciones:</strong> {{ $alumno->inscripciones->count() }}
                                </div>
                                <div class="mb-2">
                                    <strong>Evaluaciones:</strong> {{ $alumno->evaluaciones->count() }}
                                </div>
                                <div>
                                    <strong>Puede inscribirse:</strong> 
                                    @if($alumno->puedeInscribirse())
                                        <span class="badge bg-success">Sí</span>
                                    @else
                                        <span class="badge bg-danger">No</span>
                                    @endif
                                </div>
                            </div>
                        </div>

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
                                        DNI único en el sistema
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Email único y válido
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Edad mínima 16 años
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Máximo 5 cursos activos
                                    </li>
                                    <li>
                                        <i class="fas fa-check-circle text-success me-2"></i>
                                        Solo activos pueden inscribirse
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
                                        Creado: {{ $alumno->created_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li class="mb-2">
                                        <i class="fas fa-edit text-info me-2"></i>
                                        Última modificación: {{ $alumno->updated_at->format('d/m/Y H:i') }}
                                    </li>
                                    <li>
                                        <i class="fas fa-id-badge text-info me-2"></i>
                                        ID: {{ $alumno->id }}
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
                            <a href="{{ route('alumnos.show', $alumno) }}" class="btn btn-outline-secondary">
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
    // Formatear DNI automáticamente
    const dniInput = document.getElementById('dni');
    dniInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 8) {
            value = value.substring(0, 8);
        }
        this.value = value;
    });

    // Formatear teléfono automáticamente
    const telefonoInput = document.getElementById('telefono');
    telefonoInput.addEventListener('input', function() {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 0) {
            if (value.length <= 2) {
                value = '+54 ' + value;
            } else if (value.length <= 4) {
                value = '+54 ' + value.substring(0, 2) + ' ' + value.substring(2);
            } else if (value.length <= 8) {
                value = '+54 ' + value.substring(0, 2) + ' ' + value.substring(2, 6) + '-' + value.substring(6);
            } else {
                value = '+54 ' + value.substring(0, 2) + ' ' + value.substring(2, 6) + '-' + value.substring(6, 10);
            }
        }
        this.value = value;
    });

    // Validar fecha de nacimiento
    const fechaInput = document.getElementById('fecha_nacimiento');
    fechaInput.addEventListener('change', function() {
        const fecha = new Date(this.value);
        const hoy = new Date();
        const edad = hoy.getFullYear() - fecha.getFullYear();
        const mes = hoy.getMonth() - fecha.getMonth();
        
        if (mes < 0 || (mes === 0 && hoy.getDate() < fecha.getDate())) {
            edad--;
        }
        
        if (edad < 16) {
            this.setCustomValidity('El alumno debe tener al menos 16 años');
        } else {
            this.setCustomValidity('');
        }
    });
});
</script>
@endsection 