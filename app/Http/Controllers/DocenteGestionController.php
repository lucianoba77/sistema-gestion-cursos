<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Inscripcion;
use App\Models\Evaluacion;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class DocenteGestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!Auth::check() || !Auth::user()->isDocente()) {
                abort(403, 'Acceso denegado. Solo los docentes pueden acceder a esta sección.');
            }
            return $next($request);
        });
    }

    /**
     * Mostrar los cursos del docente
     */
    public function misCursos()
    {
        $user = Auth::user();
        
        // Buscar el docente en la tabla docentes por email
        $docente = Docente::where('email', $user->email)->first();
        
        if (!$docente) {
            return redirect()->route('archivos.create')
                ->with('error', 'No tienes cursos asignados. Contacta al administrador.');
        }
        
        $cursos = $docente->cursosActivos()->withCount('inscripciones as total_alumnos')->get();

        return view('docente.mis-cursos', compact('cursos', 'docente', 'user'));
    }

    /**
     * Mostrar alumnos inscritos en un curso específico
     */
    public function alumnosCurso(Curso $curso): View
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para acceder a este curso.');
        }

        $inscripciones = $curso->inscripciones()->with('alumno')->get();

        return view('docente.alumnos-curso', compact('curso', 'inscripciones', 'docente'));
    }

    /**
     * Mostrar formulario para cargar asistencias
     */
    public function cargarAsistencias(Curso $curso): View
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para acceder a este curso.');
        }

        $inscripciones = $curso->inscripciones()->with('alumno')->get();

        return view('docente.cargar-asistencias', compact('curso', 'inscripciones', 'docente'));
    }

    /**
     * Guardar asistencias de los alumnos
     */
    public function guardarAsistencias(Request $request, Curso $curso): RedirectResponse
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para acceder a este curso.');
        }

        $request->validate([
            'asistencias.*' => 'required|integer|min:0|max:20'
        ]);

        $inscripciones = $curso->inscripciones;

        foreach ($inscripciones as $inscripcion) {
            $asistencias = $request->input("asistencias.{$inscripcion->id}", 0);
            $inscripcion->update(['asistencias' => $asistencias]);
        }

        return redirect()->route('docente.alumnos-curso', $curso)
            ->with('success', 'Asistencias guardadas exitosamente');
    }

    /**
     * Mostrar formulario para cargar evaluaciones
     */
    public function cargarEvaluaciones(Curso $curso): View
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para acceder a este curso.');
        }

        $inscripciones = $curso->inscripciones()->with(['alumno', 'evaluaciones'])->get();

        return view('docente.cargar-evaluaciones', compact('curso', 'inscripciones', 'docente'));
    }

    /**
     * Guardar evaluaciones de los alumnos
     */
    public function guardarEvaluaciones(Request $request, Curso $curso): RedirectResponse
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para acceder a este curso.');
        }

        $request->validate([
            'evaluaciones.*.descripcion' => 'required|string|max:255',
            'evaluaciones.*.nota' => 'required|numeric|min:1|max:10',
            'evaluaciones.*.fecha' => 'required|date',
            'evaluaciones.*.observaciones' => 'nullable|string|max:500'
        ]);

        $inscripciones = $curso->inscripciones;

        foreach ($inscripciones as $inscripcion) {
            $evaluacionData = $request->input("evaluaciones.{$inscripcion->id}");
            
            if ($evaluacionData) {
                Evaluacion::create([
                    'alumno_id' => $inscripcion->alumno_id,
                    'curso_id' => $curso->id,
                    'descripcion' => $evaluacionData['descripcion'],
                    'nota' => $evaluacionData['nota'],
                    'fecha' => $evaluacionData['fecha'],
                    'observaciones' => $evaluacionData['observaciones'] ?? null
                ]);

                // Marcar la inscripción como evaluada
                $inscripcion->update(['evaluado_por_docente' => true]);
            }
        }

        return redirect()->route('docente.alumnos-curso', $curso)
            ->with('success', 'Evaluaciones guardadas exitosamente');
    }

    /**
     * Cambiar estado de un alumno en un curso
     */
    public function cambiarEstadoAlumno(Request $request, Inscripcion $inscripcion): RedirectResponse
    {
        // Buscar el docente en la tabla docentes por email
        $user = Auth::user();
        $docente = Docente::where('email', $user->email)->first();
        
        // Verificar que el docente sea el dueño del curso
        if (!$docente || $inscripcion->curso->docente_id != $docente->id) {
            abort(403, 'No tienes permisos para modificar esta inscripción.');
        }

        $request->validate([
            'estado' => 'required|in:activo,aprobado,desaprobado'
        ]);

        $nuevoEstado = $request->estado;

        // Validar que el alumno tenga al menos el porcentaje mínimo de asistencia para ser aprobado
        if ($nuevoEstado === 'aprobado') {
            $totalClases = config('app.total_clases_curso', 20);
            $porcentajeMinimo = config('app.porcentaje_asistencia_minimo', 75);
            $porcentajeAsistencia = ($inscripcion->asistencias / $totalClases) * 100;
            
            if ($porcentajeAsistencia < $porcentajeMinimo) {
                $clasesMinimas = ceil(($totalClases * $porcentajeMinimo) / 100);
                return redirect()->route('docente.alumnos-curso', $inscripcion->curso)
                    ->with('error', "No se puede aprobar al alumno. Tiene {$inscripcion->asistencias}/{$totalClases} asistencias ({$porcentajeAsistencia}%). Se requiere al menos {$porcentajeMinimo}% de asistencia ({$clasesMinimas} clases).");
            }
        }

        $inscripcion->update(['estado' => $nuevoEstado]);

        return redirect()->route('docente.alumnos-curso', $inscripcion->curso)
            ->with('success', 'Estado del alumno actualizado exitosamente');
    }
}
