<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Evaluaciones - Sistema de Gestión</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .card {
            border: none;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
            border-radius: 1rem;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 1rem 1rem 0 0 !important;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5a6fd8 0%, #6a4190 100%);
        }
        .logo {
            max-width: 200px;
            margin-bottom: 1rem;
        }
        .evaluacion-form {
            background: #f8f9fa;
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }
        .nota-input {
            max-width: 80px;
        }
        .descripcion-input {
            min-width: 200px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header text-center py-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="logo">
                        <h4 class="mb-0">
                            <i class="fas fa-star me-2"></i>
                            Cargar Evaluaciones
                        </h4>
                        <p class="mb-0 mt-2">{{ $curso->titulo }}</p>
                    </div>
                    
                    <div class="card-body p-4">
                        <!-- Información del curso -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5><i class="fas fa-info-circle me-2"></i>Información del Curso</h5>
                                <p><strong>Estado:</strong> 
                                    <span class="badge bg-{{ $curso->estado === 'activo' ? 'success' : ($curso->estado === 'finalizado' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($curso->estado) }}
                                    </span>
                                </p>
                                <p><strong>Modalidad:</strong> {{ ucfirst($curso->modalidad) }}</p>
                                <p><strong>Alumnos:</strong> {{ count($inscripciones) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-calendar me-2"></i>Instrucciones</h5>
                                <p><strong>Rango de notas:</strong> 1-10</p>
                                <p><strong>Descripción:</strong> Obligatoria</p>
                                <p><strong>Fecha:</strong> Obligatoria</p>
                                <p><strong>Observaciones:</strong> Opcional</p>
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

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Formulario de evaluaciones -->
                        @if(count($inscripciones) > 0)
                            <form method="POST" action="{{ route('docente.guardar-evaluaciones', $curso) }}">
                                @csrf
                                
                                <div class="row">
                                    @foreach($inscripciones as $inscripcion)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="evaluacion-form">
                                                <div class="d-flex align-items-center mb-3">
                                                    <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                        {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->alumno->apellido, 0, 1)) }}
                                                    </div>
                                                    <div>
                                                        <div class="fw-medium">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</div>
                                                        <small class="text-muted">{{ $inscripcion->alumno->email }}</small>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Descripción de la evaluación *</label>
                                                    <input type="text" 
                                                           name="evaluaciones[{{ $inscripcion->id }}][descripcion]" 
                                                           class="form-control descripcion-input"
                                                           placeholder="Ej: Examen parcial, Trabajo práctico..."
                                                           required>
                                                </div>
                                                
                                                <div class="row mb-3">
                                                    <div class="col-6">
                                                        <label class="form-label">Nota *</label>
                                                        <input type="number" 
                                                               name="evaluaciones[{{ $inscripcion->id }}][nota]" 
                                                               min="1" 
                                                               max="10" 
                                                               step="0.1"
                                                               class="form-control nota-input"
                                                               placeholder="1-10"
                                                               required>
                                                    </div>
                                                    <div class="col-6">
                                                        <label class="form-label">Fecha *</label>
                                                        <input type="date" 
                                                               name="evaluaciones[{{ $inscripcion->id }}][fecha]" 
                                                               class="form-control"
                                                               value="{{ date('Y-m-d') }}"
                                                               required>
                                                    </div>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="form-label">Observaciones</label>
                                                    <textarea name="evaluaciones[{{ $inscripcion->id }}][observaciones]" 
                                                              class="form-control"
                                                              rows="2"
                                                              placeholder="Comentarios adicionales..."></textarea>
                                                </div>
                                                
                                                <!-- Estado actual -->
                                                <div class="text-center">
                                                    <span class="badge bg-{{ $inscripcion->estado === 'activo' ? 'success' : ($inscripcion->estado === 'aprobado' ? 'primary' : 'danger') }}">
                                                        Estado: {{ ucfirst($inscripcion->estado) }}
                                                    </span>
                                                    @if($inscripcion->evaluaciones->count() > 0)
                                                        <br>
                                                        <small class="text-muted">
                                                            Evaluaciones previas: {{ $inscripcion->evaluaciones->count() }}
                                                        </small>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Guardar Evaluaciones
                                    </button>
                                    
                                    <a href="{{ route('docente.alumnos-curso', $curso) }}" class="btn btn-outline-secondary">
                                        <i class="fas fa-arrow-left me-2"></i>Volver
                                    </a>
                                </div>
                            </form>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5>No hay alumnos inscritos</h5>
                                <p class="text-muted">Este curso aún no tiene alumnos inscritos.</p>
                                <a href="{{ route('docente.alumnos-curso', $curso) }}" class="btn btn-primary">
                                    <i class="fas fa-arrow-left me-2"></i>Volver
                                </a>
                            </div>
                        @endif

                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('docente.mis-cursos') }}" class="btn btn-outline-primary">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Mis Cursos
                            </a>
                            
                            <a href="{{ route('archivos.create') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-upload me-2"></i>Cargar Archivos
                            </a>
                            
                            <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 