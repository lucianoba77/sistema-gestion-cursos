@extends('layouts.app')

@section('title', 'Mi Perfil')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user-edit me-2"></i>Editar Perfil
                    </h5>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-triangle me-2"></i>Por favor corrige los siguientes errores:
                            <ul class="mb-0 mt-2">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('profile.update') }}">
                        @csrf
                        @method('PUT')

                        <h6 class="mb-3">
                            <i class="fas fa-user me-2"></i>Información Personal
                        </h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-2"></i>Nombre Completo
                                </label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user['name']) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-2"></i>Correo Electrónico
                                </label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user['email']) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">
                            <i class="fas fa-lock me-2"></i>Cambiar Contraseña
                        </h6>
                        <p class="text-muted small">Deja en blanco si no quieres cambiar la contraseña</p>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="current_password" class="form-label">Contraseña Actual</label>
                                <input type="password" 
                                       class="form-control @error('current_password') is-invalid @enderror" 
                                       id="current_password" 
                                       name="current_password">
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password" class="form-label">Nueva Contraseña</label>
                                <input type="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       id="password" 
                                       name="password">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                                <input type="password" 
                                       class="form-control" 
                                       id="password_confirmation" 
                                       name="password_confirmation">
                            </div>
                        </div>

                        <div class="d-flex justify-content-end gap-2">
                            <a href="{{ $user->isAdmin() ? route('admin.dashboard') : ($user->isCoordinador() ? route('coordinador.dashboard') : route('docente.dashboard')) }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-2"></i>Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Información del usuario -->
            <div class="card shadow-sm">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>Información del Usuario
                    </h6>
                </div>
                <div class="card-body text-center">
                    <div class="avatar-lg bg-primary text-white rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3">
                        {{ strtoupper(substr($user['name'], 0, 1)) }}
                    </div>
                    <h5 class="mb-1">{{ $user['name'] }}</h5>
                    <p class="text-muted mb-2">{{ $user['email'] }}</p>
                    
                                          @if($user['rol'] === 'admin')
                        <span class="badge bg-danger">
                            <i class="fas fa-crown me-1"></i>Administrador
                        </span>
                                          @elseif($user['rol'] === 'coordinador')
                        <span class="badge bg-warning text-dark">
                            <i class="fas fa-users-cog me-1"></i>Coordinador
                        </span>
                                          @elseif($user['rol'] === 'docente')
                        <span class="badge bg-info">
                            <i class="fas fa-chalkboard-teacher me-1"></i>Docente
                        </span>
                    @endif

                    <hr>

                    <div class="text-start">
                        <p class="mb-1">
                            <i class="fas fa-calendar-alt me-2 text-muted"></i>
                            <strong>Miembro desde:</strong><br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y') }}</small>
                        </p>
                        
                        <p class="mb-0">
                            <i class="fas fa-clock me-2 text-muted"></i>
                            <strong>Última actualización:</strong><br>
                            <small class="text-muted">{{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i') }}</small>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Consejos de seguridad -->
            <div class="card shadow-sm mt-3">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-shield-alt me-2"></i>Consejos de Seguridad
                    </h6>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Usa contraseñas fuertes
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            No compartas tus credenciales
                        </li>
                        <li class="mb-2">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Cierra sesión al terminar
                        </li>
                        <li class="mb-0">
                            <i class="fas fa-check-circle text-success me-2"></i>
                            Actualiza tu información regularmente
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 