<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alumnos del Curso - Sistema de Gestión</title>
    
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
        .alumno-card {
            transition: transform 0.2s;
        }
        .alumno-card:hover {
            transform: translateY(-2px);
        }
        .porcentaje-asistencia {
            font-size: 0.9rem;
            font-weight: bold;
        }
        .estado-badge {
            font-size: 0.8rem;
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
                            <i class="fas fa-users me-2"></i>
                            Alumnos del Curso
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
                                <p><strong>Alumnos inscritos:</strong> {{ count($inscripciones) }}</p>
                            </div>
                            <div class="col-md-6">
                                <h5><i class="fas fa-calendar me-2"></i>Fechas</h5>
                                <p><strong>Inicio:</strong> {{ $curso->fecha_inicio->format('d/m/Y') }}</p>
                                <p><strong>Fin:</strong> {{ $curso->fecha_fin->format('d/m/Y') }}</p>
                                <p><strong>Cupos:</strong> {{ count($inscripciones) }}/{{ $curso->cupos_maximos }}</p>
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

                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-circle me-2"></i>
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Botones de acción -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h5><i class="fas fa-user-graduate me-2"></i>Lista de Alumnos</h5>
                            <div class="btn-group" role="group">
                                <a href="{{ route('docente.cargar-asistencias', $curso) }}" 
                                   class="btn btn-success">
                                    <i class="fas fa-clipboard-check me-2"></i>Cargar Asistencias
                                </a>
                                <a href="{{ route('docente.cargar-evaluaciones', $curso) }}" 
                                   class="btn btn-warning">
                                    <i class="fas fa-star me-2"></i>Cargar Evaluaciones
                                </a>
                            </div>
                        </div>

                        <!-- Lista de alumnos -->
                        @if($inscripciones->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead class="table-light">
                                        <tr>
                                            <th>Alumno</th>
                                            <th>Email</th>
                                            <th>Asistencias</th>
                                            <th>Porcentaje</th>
                                            <th>Estado</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($inscripciones as $inscripcion)
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                                            {{ strtoupper(substr($inscripcion->alumno->nombre, 0, 1)) }}
                                                        </div>
                                                        <div>
                                                            <strong>{{ $inscripcion->alumno->nombre }} {{ $inscripcion->alumno->apellido }}</strong>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $inscripcion->alumno->email }}</td>
                                                <td>
                                                    <span class="badge bg-{{ $inscripcion->asistencias >= 15 ? 'success' : ($inscripcion->asistencias >= 10 ? 'warning' : 'danger') }}">
                                                        {{ $inscripcion->asistencias }}/20
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="progress" style="height: 20px;">
                                                        @php
                                                            $porcentaje = ($inscripcion->asistencias / 20) * 100;
                                                        @endphp
                                                        <div class="progress-bar bg-{{ $porcentaje >= 75 ? 'success' : ($porcentaje >= 50 ? 'warning' : 'danger') }}" 
                                                             style="width: {{ $porcentaje }}%">
                                                            {{ number_format($porcentaje, 1) }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="badge bg-{{ $inscripcion->estado === 'activo' ? 'success' : ($inscripcion->estado === 'aprobado' ? 'primary' : ($inscripcion->estado === 'desaprobado' ? 'danger' : 'secondary')) }}">
                                                        {{ ucfirst($inscripcion->estado) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <button type="button" class="btn btn-outline-primary btn-sm dropdown-toggle" data-bs-toggle="dropdown">
                                                            Acciones
                                                        </button>
                                                        <ul class="dropdown-menu">
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('docente.cargar-asistencias', $curso->id) }}">
                                                                    <i class="fas fa-clipboard-check me-2"></i>Tomar Asistencia
                                                                </a>
                                                            </li>
                                                            <li>
                                                                <a class="dropdown-item" href="{{ route('docente.cargar-evaluaciones', $curso->id) }}">
                                                                    <i class="fas fa-star me-2"></i>Calificar
                                                                </a>
                                                            </li>
                                                            <li><hr class="dropdown-divider"></li>
                                                            <li>
                                                                <form action="{{ route('docente.cambiar-estado-alumno', $inscripcion->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="estado" value="aprobado">
                                                                    <button type="submit" class="dropdown-item text-success">
                                                                        <i class="fas fa-check me-2"></i>Aprobar
                                                                    </button>
                                                                </form>
                                                            </li>
                                                            <li>
                                                                <form action="{{ route('docente.cambiar-estado-alumno', $inscripcion->id) }}" method="POST" class="d-inline">
                                                                    @csrf
                                                                    <input type="hidden" name="estado" value="desaprobado">
                                                                    <button type="submit" class="dropdown-item text-danger">
                                                                        <i class="fas fa-times me-2"></i>Desaprobar
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fas fa-users fa-3x text-muted mb-3"></i>
                                <h5>No hay alumnos inscritos</h5>
                                <p class="text-muted">Este curso no tiene alumnos inscritos actualmente.</p>
                            </div>
                        @endif

                        <!-- Botones de navegación -->
                        <div class="d-flex justify-content-center gap-3 mt-4">
                            <a href="{{ route('docente.mis-cursos') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Volver a Mis Cursos
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