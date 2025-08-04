<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cargar Asistencias - Sistema de Gestión</title>
    
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
        .asistencia-input {
            max-width: 80px;
        }
        .porcentaje-display {
            font-weight: bold;
            font-size: 0.9rem;
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
                            <i class="fas fa-clipboard-check me-2"></i>
                            Cargar Asistencias
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
                                <p><strong>Total de clases:</strong> 20</p>
                                <p><strong>Asistencia mínima:</strong> 75% (15 clases)</p>
                                <p><strong>Rango válido:</strong> 0-20</p>
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

                        <!-- Formulario de asistencias -->
                        @if(count($inscripciones) > 0)
                            <form method="POST" action="{{ route('docente.guardar-asistencias', $curso) }}">
                                @csrf
                                
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead class="table-dark">
                                            <tr>
                                                <th>Alumno</th>
                                                <th>Email</th>
                                                <th>Asistencias Actuales</th>
                                                <th>Nuevas Asistencias</th>
                                                <th>% Asistencia</th>
                                                <th>Estado</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($inscripciones as $inscripcion)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                                {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}{{ strtoupper(substr($inscripcion->alumno->apellido, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <div class="fw-medium">{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</div>
                                                                <small class="text-muted">DNI: {{ $inscripcion->alumno->dni ?? 'N/A' }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $inscripcion->alumno->email }}</td>
                                                    <td>
                                                        <span class="badge bg-info">{{ $inscripcion->asistencias ?? 0 }}/20</span>
                                                    </td>
                                                    <td>
                                                        <input type="number" 
                                                               name="asistencias[{{ $inscripcion->id }}]" 
                                                               value="{{ $inscripcion->asistencias ?? 0 }}"
                                                               min="0" 
                                                               max="20" 
                                                               class="form-control asistencia-input"
                                                               onchange="calcularPorcentaje(this, {{ $inscripcion->id }})"
                                                               required>
                                                    </td>
                                                    <td>
                                                        @php
                                                            $asistencias = $inscripcion->asistencias ?? 0;
                                                            $porcentaje = ($asistencias / 20) * 100;
                                                            $color = $porcentaje >= 75 ? 'success' : ($porcentaje >= 50 ? 'warning' : 'danger');
                                                        @endphp
                                                        <span id="porcentaje-{{ $inscripcion->id }}" 
                                                              class="badge bg-{{ $color }} porcentaje-display">
                                                            {{ number_format($porcentaje, 1) }}%
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-{{ $inscripcion->estado === 'activo' ? 'success' : ($inscripcion->estado === 'aprobado' ? 'primary' : 'danger') }}">
                                                            {{ ucfirst($inscripcion->estado) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>

                                <!-- Botones de acción -->
                                <div class="d-flex justify-content-center gap-3 mt-4">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save me-2"></i>Guardar Asistencias
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
                            
                                                                <a href="{{ route('docente.archivos.create') }}" class="btn btn-outline-secondary">
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
    
    <script>
        function calcularPorcentaje(input, inscripcionId) {
            const asistencias = parseInt(input.value) || 0;
            const totalClases = 20;
            const porcentaje = (asistencias / totalClases) * 100;
            
            let color = 'danger';
            if (porcentaje >= 75) {
                color = 'success';
            } else if (porcentaje >= 50) {
                color = 'warning';
            }
            
            const porcentajeElement = document.getElementById(`porcentaje-${inscripcionId}`);
            porcentajeElement.className = `badge bg-${color} porcentaje-display`;
            porcentajeElement.textContent = porcentaje.toFixed(1) + '%';
        }
    </script>
</body>
</html> 