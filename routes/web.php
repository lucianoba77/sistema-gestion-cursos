<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\InscripcionController;
use App\Http\Controllers\EvaluacionController;
use App\Http\Controllers\ArchivoAdjuntoController;
use App\Http\Controllers\DocenteGestionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');
    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');
    
    Route::get('/alumnos/search', [AlumnoController::class, 'search'])->name('alumnos.search');
    Route::get('/docentes/search', [DocenteController::class, 'search'])->name('docentes.search');
    Route::get('/cursos/search', [CursoController::class, 'search'])->name('cursos.search');
    Route::get('/inscripciones/search', [InscripcionController::class, 'search'])->name('inscripciones.search');
    Route::get('/evaluaciones/search', [EvaluacionController::class, 'search'])->name('evaluaciones.search');
    Route::get('/archivos/search', [ArchivoAdjuntoController::class, 'search'])->name('archivos.search');
    
    Route::resource('alumnos', AlumnoController::class);
    Route::resource('docentes', DocenteController::class);
    Route::resource('cursos', CursoController::class);
    Route::resource('inscripciones', InscripcionController::class)->parameters(['inscripciones' => 'inscripcion']);
    
    // Rutas específicas de evaluaciones ANTES del resource
    Route::get('/evaluaciones/alumnos-by-curso', [EvaluacionController::class, 'getAlumnosByCurso'])->name('evaluaciones.alumnos-by-curso');
    Route::get('/evaluaciones/filtrar/curso', [EvaluacionController::class, 'filtrarPorCurso'])->name('evaluaciones.filtrar-curso');
    Route::get('/evaluaciones/filtrar/alumno', [EvaluacionController::class, 'filtrarPorAlumno'])->name('evaluaciones.filtrar-alumno');
    
    Route::resource('evaluaciones', EvaluacionController::class)->parameters(['evaluaciones' => 'evaluacion']);
    Route::resource('archivos', ArchivoAdjuntoController::class);
    
    Route::post('/alumnos/{alumno}/toggle-status', [AlumnoController::class, 'toggleStatus'])->name('alumnos.toggle-status');
    Route::get('/alumnos/filtrar/estado', [AlumnoController::class, 'filtrarPorEstado'])->name('alumnos.filtrar-estado');
    Route::post('/docentes/{docente}/toggle-status', [DocenteController::class, 'toggleStatus'])->name('docentes.toggle-status');
    Route::get('/docentes/filtrar/estado', [DocenteController::class, 'filtrarPorEstado'])->name('docentes.filtrar-estado');
    Route::post('/cursos/{curso}/cambiar-estado', [CursoController::class, 'cambiarEstado'])->name('cursos.cambiar-estado');
    Route::get('/cursos/filtrar/estado', [CursoController::class, 'filtrarPorEstado'])->name('cursos.filtrar-estado');
    Route::post('/inscripciones/{inscripcion}/cambiar-estado', [InscripcionController::class, 'cambiarEstado'])->name('inscripciones.cambiar-estado');
    Route::get('/inscripciones/filtrar/estado', [InscripcionController::class, 'filtrarPorEstado'])->name('inscripciones.filtrar-estado');
    Route::get('/archivos/{archivo}/download', [ArchivoAdjuntoController::class, 'download'])->name('archivos.download');
    Route::get('/archivos/filtrar/tipo', [ArchivoAdjuntoController::class, 'filtrarPorTipo'])->name('archivos.filtrar-tipo');
    Route::get('/archivos/filtrar/curso', [ArchivoAdjuntoController::class, 'filtrarPorCurso'])->name('archivos.filtrar-curso');
    
    Route::get('/reportes', function () {
        return view('reportes.index');
    })->name('reportes.index');
    
    Route::get('/estadisticas', function () {
        return view('estadisticas.index');
    })->name('estadisticas.index');
    
    // Rutas específicas por rol
    Route::prefix('admin')->name('admin.')->middleware(['role.admin'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'adminDashboard'])->name('dashboard');
    });
    
    Route::prefix('coordinador')->name('coordinador.')->middleware(['role.coordinador'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'coordinadorDashboard'])->name('dashboard');
    });
    
    Route::prefix('docente')->name('docente.')->middleware(['role.docente'])->group(function () {
        Route::get('/dashboard', [AuthController::class, 'docenteDashboard'])->name('dashboard');
        
        Route::get('/mis-cursos', [DocenteGestionController::class, 'misCursos'])->name('mis-cursos');
        
        Route::get('/cursos/{curso}/alumnos', [DocenteGestionController::class, 'alumnosCurso'])->name('alumnos-curso');
        
        Route::get('/cursos/{curso}/asistencias', [DocenteGestionController::class, 'cargarAsistencias'])->name('cargar-asistencias');
        Route::post('/cursos/{curso}/asistencias', [DocenteGestionController::class, 'guardarAsistencias'])->name('guardar-asistencias');
        
        Route::get('/cursos/{curso}/evaluaciones', [DocenteGestionController::class, 'cargarEvaluaciones'])->name('cargar-evaluaciones');
        Route::post('/cursos/{curso}/evaluaciones', [DocenteGestionController::class, 'guardarEvaluaciones'])->name('guardar-evaluaciones');
        
        Route::post('/inscripciones/{inscripcion}/cambiar-estado', [DocenteGestionController::class, 'cambiarEstadoAlumno'])->name('cambiar-estado-alumno');
        
        Route::resource('archivos', ArchivoAdjuntoController::class)->only(['index', 'create', 'store', 'destroy']);
    });
});
