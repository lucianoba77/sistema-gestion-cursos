<?php

namespace App\Http\Controllers;

use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Curso;
use App\Http\Requests\InscripcionRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para gestión de inscripciones del sistema
 * Maneja CRUD completo, búsqueda y filtrado por estado
 */
class InscripcionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            if (!$user->puedeGestionarInscripciones()) {
                abort(403, 'No tienes permisos para gestionar inscripciones. Solo administradores y coordinadores pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    public function index(): View
    {
        $inscripciones = Inscripcion::with(['alumno', 'curso.docente'])
            ->orderBy('fecha_inscripcion', 'desc')
            ->paginate(10);

        return view('inscripciones.index', compact('inscripciones'));
    }

    public function create(): View
    {
        $alumnos = Alumno::activos()->orderBy('apellido')->orderBy('nombre')->get();
        $cursos = Curso::activos()->orderBy('titulo')->get();
        
        return view('inscripciones.create', compact('alumnos', 'cursos'));
    }

    public function store(InscripcionRequest $request): RedirectResponse
    {
        // Verificar que el alumno no esté ya inscrito en el curso
        $inscripcionExistente = Inscripcion::where('alumno_id', $request->alumno_id)
            ->where('curso_id', $request->curso_id)
            ->first();

        if ($inscripcionExistente) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['curso_id' => 'El alumno ya está inscrito en este curso.']);
        }

        // Verificar cupos disponibles
        $curso = Curso::find($request->curso_id);
        if ($curso->cupos_disponibles <= 0) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['curso_id' => 'El curso no tiene cupos disponibles.']);
        }

        $inscripcion = Inscripcion::create($request->validated());

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción creada exitosamente.');
    }

    public function show(Inscripcion $inscripcion): View
    {
        $inscripcion->load(['alumno', 'curso.docente', 'evaluaciones']);
        
        return view('inscripciones.show', compact('inscripcion'));
    }

    public function edit(Inscripcion $inscripcion): View
    {
        $alumnos = Alumno::activos()->orderBy('apellido')->orderBy('nombre')->get();
        $cursos = Curso::activos()->orderBy('titulo')->get();
        
        return view('inscripciones.edit', compact('inscripcion', 'alumnos', 'cursos'));
    }

    public function update(InscripcionRequest $request, Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->update($request->validated());

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción actualizada exitosamente.');
    }

    public function destroy(Inscripcion $inscripcion): RedirectResponse
    {
        $inscripcion->delete();

        return redirect()->route('inscripciones.index')
            ->with('success', 'Inscripción eliminada exitosamente.');
    }

    public function cambiarEstado(Request $request, Inscripcion $inscripcion): RedirectResponse
    {
        $request->validate([
            'estado' => 'required|in:activo,aprobado,desaprobado,retirado'
        ]);

        $nuevoEstado = $request->estado;

        // Validar que el alumno tenga al menos el porcentaje mínimo de asistencia para ser aprobado
        if ($nuevoEstado === 'aprobado') {
            $totalClases = config('app.total_clases_curso', 20);
            $porcentajeMinimo = config('app.porcentaje_asistencia_minimo', 75);
            $porcentajeAsistencia = ($inscripcion->asistencias / $totalClases) * 100;
            
            if ($porcentajeAsistencia < $porcentajeMinimo) {
                $clasesMinimas = ceil(($totalClases * $porcentajeMinimo) / 100);
                return redirect()->route('inscripciones.index')
                    ->with('error', "No se puede aprobar al alumno. Tiene {$inscripcion->asistencias}/{$totalClases} asistencias ({$porcentajeAsistencia}%). Se requiere al menos {$porcentajeMinimo}% de asistencia ({$clasesMinimas} clases).");
            }
        }

        $inscripcion->update(['estado' => $nuevoEstado]);

        return redirect()->route('inscripciones.index')
            ->with('success', "Estado de la inscripción cambiado a '{$nuevoEstado}' exitosamente.");
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $inscripciones = Inscripcion::with(['alumno', 'curso.docente'])
            ->where(function($query) use ($search) {
                $query->whereHas('alumno', function($subQuery) use ($search) {
                    $subQuery->where('nombre', 'like', '%' . $search . '%')
                             ->orWhere('apellido', 'like', '%' . $search . '%')
                             ->orWhere('email', 'like', '%' . $search . '%');
                })
                ->orWhereHas('curso', function($subQuery) use ($search) {
                    $subQuery->where('titulo', 'like', '%' . $search . '%');
                });
            })
            ->orderBy('fecha_inscripcion', 'desc')
            ->paginate(10);

        return view('inscripciones.index', compact('inscripciones', 'search'));
    }

    public function filtrarPorEstado(Request $request): View
    {
        $request->validate([
            'estado' => 'required|in:activo,aprobado,desaprobado,todos'
        ]);

        $query = Inscripcion::with(['alumno', 'curso.docente']);

        switch ($request->estado) {
            case 'activo':
                $query = $query->activas();
                break;
            case 'aprobado':
                $query = $query->aprobadas();
                break;
            case 'desaprobado':
$query = $query->where('estado', 'desaprobado');
                break;
            case 'todos':
            default:
                // No aplicar filtro, mostrar todos
                break;
        }

        $inscripciones = $query->orderBy('fecha_inscripcion', 'desc')->paginate(10);

        return view('inscripciones.index', compact('inscripciones'));
    }
}
