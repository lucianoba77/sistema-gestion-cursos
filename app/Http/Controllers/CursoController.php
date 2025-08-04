<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Docente;
use App\Http\Requests\CursoRequest;
use App\Http\Requests\CursoUpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para gestión de cursos del sistema
 * Maneja CRUD completo, búsqueda y filtrado por estado
 */
class CursoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            if (!$user->puedeGestionarCursos()) {
                abort(403, 'No tienes permisos para gestionar cursos. Solo administradores pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    public function index(): View
    {
        $cursos = Curso::with(['docente', 'inscripciones'])
            ->orderBy('titulo')
            ->paginate(10);

        return view('cursos.index', compact('cursos'));
    }

    public function create(): View
    {
        $docentes = Docente::activos()->orderBy('apellido')->orderBy('nombre')->get();
        return view('cursos.create', compact('docentes'));
    }

    public function store(CursoRequest $request): RedirectResponse
    {
        $curso = Curso::create($request->validated());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso creado exitosamente.');
    }

    public function show(Curso $curso): View
    {
        $curso->load(['docente', 'inscripciones.alumno', 'evaluaciones.alumno']);
        
        return view('cursos.show', compact('curso'));
    }

    public function edit(Curso $curso): View
    {
        $docentes = Docente::activos()->orderBy('apellido')->orderBy('nombre')->get();
        return view('cursos.edit', compact('curso', 'docentes'));
    }

    public function update(CursoUpdateRequest $request, Curso $curso): RedirectResponse
    {
        $curso->update($request->validated());

        return redirect()->route('cursos.index')
            ->with('success', 'Curso actualizado exitosamente.');
    }

    public function destroy(Curso $curso): RedirectResponse
    {
        if ($curso->inscripciones()->exists()) {
            return redirect()->route('cursos.index')
                ->with('error', 'No se puede eliminar un curso con inscripciones.');
        }

        $curso->delete();

        return redirect()->route('cursos.index')
            ->with('success', 'Curso eliminado exitosamente.');
    }

    public function cambiarEstado(Curso $curso): RedirectResponse
    {
        $nuevoEstado = $curso->estado === 'activo' ? 'finalizado' : 'activo';
        $curso->update(['estado' => $nuevoEstado]);

        return redirect()->route('cursos.index')
            ->with('success', "Estado del curso cambiado a '{$nuevoEstado}' exitosamente.");
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $cursos = Curso::with(['docente', 'inscripciones'])
            ->where(function($query) use ($search) {
                $query->where('titulo', 'like', '%' . $search . '%')
                      ->orWhere('descripcion', 'like', '%' . $search . '%')
                      ->orWhereHas('docente', function($subQuery) use ($search) {
                          $subQuery->where('nombre', 'like', '%' . $search . '%')
                                   ->orWhere('apellido', 'like', '%' . $search . '%');
                      });
            })
            ->orderBy('titulo')
            ->paginate(10);

        return view('cursos.index', compact('cursos', 'search'));
    }

    public function filtrarPorEstado(Request $request): View
    {
        $request->validate([
            'estado' => 'required|in:activo,finalizado,cancelado,todos'
        ]);

        $query = Curso::with(['docente', 'inscripciones']);

        switch ($request->estado) {
            case 'activo':
                $query = $query->activos();
                break;
            case 'finalizado':
                $query = $query->finalizados();
                break;
            case 'cancelado':
                $query = $query->cancelados();
                break;
            case 'todos':
            default:
                // No aplicar filtro, mostrar todos
                break;
        }

        $cursos = $query->orderBy('titulo')->paginate(10);

        return view('cursos.index', compact('cursos'));
    }
}
