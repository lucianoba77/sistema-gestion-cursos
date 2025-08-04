@extends('layouts.app')

@section('title', 'Estadísticas')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-flex align-items-center justify-content-between">
                <h4 class="mb-0">
                    <i class="fas fa-chart-line me-2"></i>
                    Estadísticas del Sistema
                </h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-3 mb-4">
            <div class="card bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Total Alumnos</h4>
                            <h2 class="mb-0">60</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-users fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Total Cursos</h4>
                            <h2 class="mb-0">15</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Total Docentes</h4>
                            <h2 class="mb-0">5</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-chalkboard-teacher fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-3 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h4 class="card-title">Inscripciones</h4>
                            <h2 class="mb-0">40</h2>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clipboard-list fa-2x"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-pie me-2"></i>
                        Estado de Cursos
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-success">8</h4>
                                <small class="text-muted">Activos</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-warning">5</h4>
                                <small class="text-muted">Finalizados</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <h4 class="text-danger">2</h4>
                                <small class="text-muted">Cancelados</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-md-6 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        Estado de Inscripciones
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-primary">25</h4>
                                <small class="text-muted">Activas</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="border-end">
                                <h4 class="text-success">10</h4>
                                <small class="text-muted">Aprobadas</small>
                            </div>
                        </div>
                        <div class="col-4">
                            <div>
                                <h4 class="text-danger">5</h4>
                                <small class="text-muted">Desaprobadas</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        Información del Sistema
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6>Desarrollado por:</h6>
                            <p class="text-muted">Julio Barrenechea</p>
                            
                            <h6>Framework:</h6>
                            <p class="text-muted">Laravel 12.21.0</p>
                            
                            <h6>Base de Datos:</h6>
                            <p class="text-muted">MySQL</p>
                        </div>
                        <div class="col-md-6">
                            <h6>Fecha:</h6>
                            <p class="text-muted">Agosto de 2025</p>
                            
                            <h6>Patrón de Arquitectura:</h6>
                            <p class="text-muted">MVC + Singleton</p>
                            
                            <h6>Frontend:</h6>
                            <p class="text-muted">Bootstrap 5 + Font Awesome</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 