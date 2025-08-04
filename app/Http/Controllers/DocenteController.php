<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Http\Requests\DocenteRequest;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador para gestión de docentes del sistema
 * Maneja CRUD completo, búsqueda y filtrado por estado
 */
class DocenteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            if (!$user->puedeGestionarDocentes()) {
                abort(403, 'No tienes permisos para gestionar docentes. Solo administradores pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    public function index(): View
    {
        $docentes = Docente::with('cursos')
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('docentes.index', compact('docentes'));
    }

    public function create(): View
    {
        return view('docentes.create');
    }

    public function store(DocenteRequest $request): RedirectResponse
    {
        $docente = Docente::create($request->validated());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente creado exitosamente.');
    }

    public function show(Docente $docente): View
    {
        $docente->load(['cursos.inscripciones']);
        
        return view('docentes.show', compact('docente'));
    }

    public function edit(Docente $docente): View
    {
        return view('docentes.edit', compact('docente'));
    }

    public function update(DocenteRequest $request, Docente $docente): RedirectResponse
    {
        $docente->update($request->validated());

        return redirect()->route('docentes.index')
            ->with('success', 'Docente actualizado exitosamente.');
    }

    public function destroy(Docente $docente): RedirectResponse
    {
        // Verificar si el docente tiene cursos asignados (activos o inactivos)
        if ($docente->cursos()->exists()) {
            return redirect()->route('docentes.index')
                ->with('error', 'No se puede eliminar un docente que tenga cursos asignados. Primero debe desasignar todos los cursos.');
        }

        // Verificar si el docente tiene inscripciones relacionadas
        if ($docente->cursos()->whereHas('inscripciones')->exists()) {
            return redirect()->route('docentes.index')
                ->with('error', 'No se puede eliminar un docente que tenga cursos con inscripciones. Primero debe finalizar o cancelar los cursos.');
        }

        $docente->delete();

        return redirect()->route('docentes.index')
            ->with('success', 'Docente eliminado exitosamente.');
    }

    public function toggleStatus(Docente $docente): RedirectResponse
    {
        $docente->update(['activo' => !$docente->activo]);

        $status = $docente->activo ? 'activado' : 'desactivado';
        return redirect()->route('docentes.index')
            ->with('success', "Docente {$status} exitosamente.");
    }

    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $docentes = Docente::with('cursos')
            ->where(function($query) use ($search) {
                $query->where('nombre', 'like', '%' . $search . '%')
                      ->orWhere('apellido', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%')
                      ->orWhere('especialidad', 'like', '%' . $search . '%');
            })
            ->orderBy('apellido')
            ->orderBy('nombre')
            ->paginate(10);

        return view('docentes.index', compact('docentes', 'search'));
    }

    public function filtrarPorEstado(Request $request): View
    {
        $request->validate([
            'estado' => 'required|in:activo,inactivo,todos'
        ]);

        $query = Docente::with('cursos');

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

        $docentes = $query->orderBy('apellido')->orderBy('nombre')->paginate(10);

        return view('docentes.index', compact('docentes'));
    }
}
