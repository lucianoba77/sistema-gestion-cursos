<?php

namespace App\Http\Controllers;

use App\Models\Evaluacion;
use App\Models\Alumno;
use App\Models\Curso;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para gestión de evaluaciones del sistema
 * Maneja CRUD completo, búsqueda y filtrado
 */
class EvaluacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            if (!$user->puedeGestionarEvaluaciones()) {
                abort(403, 'No tienes permisos para gestionar evaluaciones. Solo administradores y coordinadores pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    public function index(): View
    {
        $evaluaciones = Evaluacion::with(['alumno', 'curso.docente'])
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function create(): View
    {
        // Obtener solo cursos que tienen alumnos inscritos
        $cursos = Curso::activos()
            ->whereHas('inscripciones', function($query) {
                $query->where('estado', 'activo');
            })
            ->withCount(['inscripciones' => function($query) {
                $query->where('estado', 'activo');
            }])
            ->orderBy('titulo')
            ->get();
        
        $alumnos = collect(); // Inicialmente vacío, se cargará por AJAX
        
        return view('evaluaciones.create', compact('cursos', 'alumnos'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'descripcion' => 'required|string|max:255',
            'nota' => 'required|numeric|min:1|max:10',
            'fecha' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Validar que el alumno esté inscrito en el curso
        $inscripcion = \App\Models\Inscripcion::where('alumno_id', $request->alumno_id)
            ->where('curso_id', $request->curso_id)
            ->first();

        if (!$inscripcion) {
            return back()->withErrors(['curso_id' => 'El alumno no está inscrito en este curso.'])->withInput();
        }

        $evaluacion = Evaluacion::create($request->all());

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación creada exitosamente.');
    }

    public function show(Evaluacion $evaluacion): View
    {
        $evaluacion->load(['alumno', 'curso.docente']);
        
        return view('evaluaciones.show', compact('evaluacion'));
    }

    public function edit(Evaluacion $evaluacion): View
    {
        $alumnos = Alumno::activos()->orderBy('apellido')->orderBy('nombre')->get();
        
        // Cargar los cursos donde el alumno está inscrito, incluyendo el curso actual de la evaluación
        $cursos = Curso::with('docente')->where(function($query) use ($evaluacion) {
            $query->whereHas('inscripciones', function($subQuery) use ($evaluacion) {
                $subQuery->where('alumno_id', $evaluacion->alumno_id);
            })->orWhere('id', $evaluacion->curso_id);
        })->orderBy('titulo')->get();
        
        return view('evaluaciones.edit', compact('evaluacion', 'alumnos', 'cursos'));
    }

    public function update(Request $request, Evaluacion $evaluacion): RedirectResponse
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'descripcion' => 'required|string|max:255',
            'nota' => 'required|numeric|min:1|max:10',
            'fecha' => 'required|date|before_or_equal:today',
            'observaciones' => 'nullable|string|max:500',
        ]);

        // Validar que el alumno esté inscrito en el curso (si cambió)
        if ($request->alumno_id != $evaluacion->alumno_id || $request->curso_id != $evaluacion->curso_id) {
            $inscripcion = \App\Models\Inscripcion::where('alumno_id', $request->alumno_id)
                ->where('curso_id', $request->curso_id)
                ->first();

            if (!$inscripcion) {
                return back()->withErrors(['curso_id' => 'El alumno no está inscrito en este curso.'])->withInput();
            }
        }

        $evaluacion->update($request->all());

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación actualizada exitosamente.');
    }

    public function destroy(Evaluacion $evaluacion): RedirectResponse
    {
        $evaluacion->delete();

        return redirect()->route('evaluaciones.index')
            ->with('success', 'Evaluación eliminada exitosamente.');
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $evaluaciones = Evaluacion::with(['alumno', 'curso.docente'])
            ->where(function($query) use ($search) {
                $query->where('descripcion', 'like', '%' . $search . '%')
                      ->orWhereHas('alumno', function($subQuery) use ($search) {
                          $subQuery->where('nombre', 'like', '%' . $search . '%')
                                   ->orWhere('apellido', 'like', '%' . $search . '%');
                      })
                      ->orWhereHas('curso', function($subQuery) use ($search) {
                          $subQuery->where('titulo', 'like', '%' . $search . '%');
                      });
            })
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('evaluaciones.index', compact('evaluaciones', 'search'));
    }

    public function filtrarPorCurso(Request $request): View
    {
        $request->validate([
            'filtro' => 'required|in:activos,finalizados'
        ]);

        $query = Evaluacion::with(['alumno', 'curso.docente']);

        switch ($request->filtro) {
            case 'activos':
                $query = $query->whereHas('curso', function($subQuery) {
                    $subQuery->where('estado', 'activo');
                });
                break;
            case 'finalizados':
                $query = $query->whereHas('curso', function($subQuery) {
                    $subQuery->where('estado', 'finalizado');
                });
                break;
        }

        $evaluaciones = $query->orderBy('fecha', 'desc')->paginate(10);

        return view('evaluaciones.index', compact('evaluaciones'));
    }

    public function filtrarPorAlumno(Request $request): View
    {
        $request->validate([
            'alumno_id' => 'required|exists:alumnos,id'
        ]);

        $evaluaciones = Evaluacion::with(['alumno', 'curso.docente'])
            ->where('alumno_id', $request->alumno_id)
            ->orderBy('fecha', 'desc')
            ->paginate(10);

        return view('evaluaciones.index', compact('evaluaciones'));
    }

    // Método para obtener alumnos de un curso específico (para AJAX)
    public function getAlumnosByCurso(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id'
        ]);

        $alumnos = Alumno::whereHas('inscripciones', function($query) use ($request) {
            $query->where('curso_id', $request->curso_id)
                  ->where('estado', 'activo');
        })
        ->orderBy('apellido')
        ->orderBy('nombre')
        ->get();

        return response()->json($alumnos);
    }
}
