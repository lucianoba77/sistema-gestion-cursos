<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Carga de Archivos - Sistema de Gestión</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
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
    </style>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6">
                <div class="card">
                    <div class="card-header text-center py-4">
                        <img src="{{ asset('images/logo.svg') }}" alt="Logo" class="logo">
                        <h4 class="mb-0">
                            <i class="fas fa-upload me-2"></i>
                            Carga de Archivos
                        </h4>
                        <p class="mb-0 mt-2">Sistema de Gestión de Cursos</p>
                    </div>
                    
                    <div class="card-body p-4">
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

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                <strong>Error:</strong>
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Información del usuario -->
                        <div class="text-center mb-4">
                            <div class="d-flex align-items-center justify-content-center mb-3">
                                <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-3">
                                    {{ strtoupper(substr($user['name'], 0, 1)) }}
                                </div>
                                <div class="text-start">
                                    <h6 class="mb-0">{{ $user['name'] }}</h6>
                                    <small class="text-muted">Docente</small>
                                </div>
                            </div>
                        </div>

                        <!-- Formulario de carga -->
                        <form action="{{ route('docente.archivos.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            
                            <div class="mb-3">
                                <label for="archivo" class="form-label">
                                    <i class="fas fa-file me-2"></i>Seleccionar Archivo
                                </label>
                                <input type="file" 
                                       class="form-control @error('archivo') is-invalid @enderror" 
                                       id="archivo" 
                                       name="archivo" 
                                       accept=".pdf,.docx,.ppt,.jpg,.jpeg,.png"
                                       required>
                                <div class="form-text">
                                    Formatos permitidos: PDF, DOCX, PPT, JPG, PNG (máximo 10MB)
                                </div>
                                @error('archivo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="descripcion" class="form-label">
                                    <i class="fas fa-tag me-2"></i>Descripción del Archivo
                                </label>
                                <input type="text" 
                                       class="form-control @error('descripcion') is-invalid @enderror" 
                                       id="descripcion" 
                                       name="descripcion" 
                                       value="{{ old('descripcion') }}" 
                                       placeholder="Ej: Material de estudio, Guía práctica, etc."
                                       required>
                                @error('descripcion')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="tipo" class="form-label">
                                    <i class="fas fa-folder me-2"></i>Tipo de Archivo
                                </label>
                                <select class="form-select @error('tipo') is-invalid @enderror" 
                                        id="tipo" 
                                        name="tipo" 
                                        required>
                                    <option value="">Seleccionar tipo...</option>
                                    <option value="material">Material</option>
                                    <option value="tarea">Tarea</option>
                                    <option value="guia">Guía</option>
                                </select>
                                @error('tipo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3" id="curso_container">
                                <label for="curso_id" class="form-label">
                                    <i class="fas fa-graduation-cap me-2"></i>Curso Asociado <span class="text-danger">*</span>
                                </label>
                                <select class="form-select @error('curso_id') is-invalid @enderror" 
                                        id="curso_id" 
                                        name="curso_id"
                                        required>
                                    <option value="">Seleccionar curso...</option>
                                    @foreach($cursos as $curso)
                                        <option value="{{ $curso->id }}" {{ old('curso_id') == $curso->id ? 'selected' : '' }}>
                                            {{ $curso->titulo }} - {{ $curso->docente->nombre }} {{ $curso->docente->apellido }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('curso_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="observaciones" class="form-label">
                                    <i class="fas fa-comment me-2"></i>Observaciones (Opcional)
                                </label>
                                <textarea class="form-control @error('observaciones') is-invalid @enderror" 
                                          id="observaciones" 
                                          name="observaciones" 
                                          rows="3" 
                                          placeholder="Información adicional sobre el archivo...">{{ old('observaciones') }}</textarea>
                                @error('observaciones')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="fas fa-upload me-2"></i>Subir Archivo
                                </button>
                            </div>
                        </form>
                        
                        <!-- Botones de acción -->
                        <div class="mt-3">
                            <div class="row">
                                <div class="col-6">
                                    <a href="{{ route('docente.archivos.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-arrow-left me-2"></i>Volver
                                    </a>
                                </div>
                                <div class="col-6">
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-secondary w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i>Cerrar Sesión
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // Validación de archivo
        document.getElementById('archivo').addEventListener('change', function() {
            const file = this.files[0];
            const allowedTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document', 'application/vnd.ms-powerpoint', 'image/jpeg', 'image/png'];
            const maxSize = 10 * 1024 * 1024; // 10MB
            
            if (file) {
                if (!allowedTypes.includes(file.type)) {
                    alert('Error: Solo se permiten archivos PDF, DOCX, PPT, JPG y PNG.');
                    this.value = '';
                    return;
                }
                
                if (file.size > maxSize) {
                    alert('Error: El archivo es demasiado grande. Máximo 10MB.');
                    this.value = '';
                    return;
                }
            }
        });

        // Validación de formulario
        document.querySelector('form').addEventListener('submit', function(e) {
            const cursoSelect = document.getElementById('curso_id');
            const tipoSelect = document.getElementById('tipo');
            
            if (!cursoSelect.value) {
                e.preventDefault();
                alert('Error: Debes seleccionar un curso. Todos los archivos deben estar asociados a un curso.');
                return;
            }
            
            if (!tipoSelect.value) {
                e.preventDefault();
                alert('Error: Debes seleccionar un tipo de archivo.');
                return;
            }
        });
    </script>
</body>
</html> 