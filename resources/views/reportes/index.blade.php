@extends('layouts.app')

@section('title', 'Reportes')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    Reportes del Sistema
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-file-alt me-2"></i>
                        Reportes Disponibles
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-users fa-3x text-primary mb-3"></i>
                                    <h5 class="card-title">Reporte de Alumnos</h5>
                                    <p class="card-text">Listado completo de alumnos con sus estados y cursos.</p>
                                    <a href="{{ route('alumnos.index') }}" class="btn btn-primary">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-book fa-3x text-success mb-3"></i>
                                    <h5 class="card-title">Reporte de Cursos</h5>
                                    <p class="card-text">Información detallada de todos los cursos y sus estados.</p>
                                    <a href="{{ route('cursos.index') }}" class="btn btn-success">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-clipboard-list fa-3x text-warning mb-3"></i>
                                    <h5 class="card-title">Reporte de Inscripciones</h5>
                                    <p class="card-text">Estado de todas las inscripciones y asistencias.</p>
                                    <a href="{{ route('inscripciones.index') }}" class="btn btn-warning">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-star fa-3x text-info mb-3"></i>
                                    <h5 class="card-title">Reporte de Evaluaciones</h5>
                                    <p class="card-text">Calificaciones y evaluaciones de todos los alumnos.</p>
                                    <a href="{{ route('evaluaciones.index') }}" class="btn btn-info">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-file-alt fa-3x text-secondary mb-3"></i>
                                    <h5 class="card-title">Reporte de Archivos</h5>
                                    <p class="card-text">Listado de todos los archivos adjuntos del sistema.</p>
                                    <a href="{{ route('archivos.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <div class="card-body text-center">
                                    <i class="fas fa-chalkboard-teacher fa-3x text-danger mb-3"></i>
                                    <h5 class="card-title">Reporte de Docentes</h5>
                                    <p class="card-text">Información de docentes y sus cursos asignados.</p>
                                    <a href="{{ route('docentes.index') }}" class="btn btn-danger">
                                        <i class="fas fa-eye me-2"></i>Ver Reporte
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 