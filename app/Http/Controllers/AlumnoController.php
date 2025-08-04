<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Http\Requests\AlumnoRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para gestión de alumnos del sistema
 * Maneja CRUD completo, búsqueda y filtrado por estado
 */
class AlumnoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            if (!$user->puedeGestionarAlumnos()) {
                abort(403, 'No tienes permisos para gestionar alumnos. Solo administradores y coordinadores pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    public function index(): View
    {
        $alumnos = Alumno::with('inscripciones.curso')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('alumnos.index', compact('alumnos'));
    }

    public function create(): View
    {
        return view('alumnos.create');
    }

    public function store(AlumnoRequest $request): RedirectResponse
    {
        $alumno = Alumno::create($request->validated());

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno creado exitosamente.');
    }

    public function show(Alumno $alumno): View
    {
        $alumno->load(['inscripciones.curso', 'evaluaciones.curso']);
        
        return view('alumnos.show', compact('alumno'));
    }

    public function edit(Alumno $alumno): View
    {
        return view('alumnos.edit', compact('alumno'));
    }

    public function update(AlumnoRequest $request, Alumno $alumno): RedirectResponse
    {
        $alumno->update($request->validated());

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno actualizado exitosamente.');
    }

    public function destroy(Alumno $alumno): RedirectResponse
    {
        if ($alumno->inscripciones()->whereHas('curso', function($query) {
            $query->where('estado', 'activo');
        })->exists()) {
            return redirect()->route('alumnos.index')
                ->with('error', 'No se puede eliminar un alumno con cursos activos.');
        }

        $alumno->delete();

        return redirect()->route('alumnos.index')
            ->with('success', 'Alumno eliminado exitosamente.');
    }

    public function toggleStatus(Alumno $alumno): RedirectResponse
    {
        $alumno->update(['activo' => !$alumno->activo]);

        $status = $alumno->activo ? 'activado' : 'desactivado';
        return redirect()->route('alumnos.index')
            ->with('success', "Alumno {$status} exitosamente.");
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $alumnos = Alumno::with('inscripciones.curso')
            ->where(function($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                      ->orWhere('apellido', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('dni', 'like', '%' . $search . '%');
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('alumnos.index', compact('alumnos', 'search'));
    }

    public function filtrarPorEstado(Request $request): View
    {
        $request->validate([
            'estado' => 'required|in:activo,inactivo,todos'
        ]);

        $query = Alumno::with('inscripciones.curso');

        switch ($request->estado) {
            case 'activo':
                $query = $query->activos();
                break;
            case 'inactivo':
                $query = $query->inactivos();
                break;
            case 'todos':
            default:
                // No aplicar filtro, mostrar todos
                break;
        }

        $alumnos = $query->orderBy('apellido')->orderBy('nombre')->paginate(10);

        return view('alumnos.index', compact('alumnos'));
    }
}
