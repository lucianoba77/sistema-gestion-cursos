<?php

namespace App\Http\Controllers;

use App\Models\ArchivoAdjunto;
use App\Models\Curso;
use App\Models\Docente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ArchivoAdjuntoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            $user = Auth::user();
            
            // Solo administradores y docentes pueden gestionar archivos
            if (!$user->puedeGestionarArchivos()) {
                abort(403, 'No tienes permisos para gestionar archivos. Solo administradores y docentes pueden realizar esta acción.');
            }
            
            return $next($request);
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $archivos = ArchivoAdjunto::with(['curso.docente'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('archivos.index', compact('archivos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $user = Auth::user();
        
        // Si es docente, obtener solo sus cursos
        if ($user->isDocente()) {
            // Obtener el docente correspondiente al usuario
            $docente = Docente::where('email', $user->email)->first();
            
            if ($docente) {
                // Obtener solo los cursos del docente
                $cursos = $docente->cursosActivos()->orderBy('titulo')->get();
            } else {
                $cursos = collect();
            }
            
            return view('archivos.create-docente', compact('cursos', 'user'));
        }
        
        // Para admin y coordinador, mostrar todos los cursos
        $cursos = Curso::activos()->orderBy('titulo')->get();
        
        return view('archivos.create', compact('cursos', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:tarea,material,guia',
            'archivo' => 'required|file|mimes:pdf,docx,ppt,jpg,jpeg,png|max:10240'
        ]);

        $user = Auth::user();
        
        // Si es docente, verificar que el curso le pertenece
        if ($user->isDocente()) {
            $docente = Docente::where('email', $user->email)->first();
            $curso = Curso::find($request->curso_id);
            
            if (!$docente || !$curso || $curso->docente_id != $docente->id) {
                return back()->withErrors(['curso_id' => 'No tienes permisos para subir archivos a este curso.']);
            }
        }

        try {
            $archivo = $request->file('archivo');
            $nombreArchivo = time() . '_' . $archivo->getClientOriginalName();
            $ruta = $archivo->storeAs('archivos', $nombreArchivo, 'public');

            ArchivoAdjunto::create([
                'curso_id' => $request->curso_id,
                'titulo' => $request->descripcion,
                'archivo_url' => $ruta,
                'tipo' => $request->tipo,
                'fecha_subida' => now()
            ]);

            // Redirigir según el rol del usuario
            if ($user->isDocente()) {
                return redirect()->route('docente.archivos.index')
                    ->with('success', 'Archivo subido exitosamente.');
            } else {
                return redirect()->route('archivos.index')
                    ->with('success', 'Archivo subido exitosamente.');
            }

        } catch (\Exception $e) {
            Log::error('Error al subir archivo: ' . $e->getMessage());
            return back()->withErrors(['archivo' => 'Error al subir el archivo. Inténtalo de nuevo.']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ArchivoAdjunto $archivo): View
    {
        return view('archivos.show', compact('archivo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ArchivoAdjunto $archivo): View
    {
        $user = Auth::user();
        
        // Si es docente, obtener solo sus cursos
        if ($user->isDocente()) {
            $docente = Docente::where('email', $user->email)->first();
            
            if ($docente) {
                $cursos = $docente->cursosActivos()->orderBy('titulo')->get();
            } else {
                $cursos = collect();
            }
        } else {
            // Para admin y coordinador, mostrar todos los cursos
            $cursos = Curso::activos()->orderBy('titulo')->get();
        }
        
        return view('archivos.edit', compact('archivo', 'cursos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ArchivoAdjunto $archivo): RedirectResponse
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'descripcion' => 'required|string|max:255',
            'tipo' => 'required|in:tarea,material,guia',
            'archivo' => 'nullable|file|mimes:pdf,docx,ppt,jpg,jpeg,png|max:10240'
        ]);

        try {
            $archivo->curso_id = $request->curso_id;
            $archivo->titulo = $request->descripcion;
            $archivo->tipo = $request->tipo;

            if ($request->hasFile('archivo')) {
                // Eliminar archivo anterior
                if ($archivo->archivo_url && Storage::disk('public')->exists($archivo->archivo_url)) {
                    Storage::disk('public')->delete($archivo->archivo_url);
                }

                // Subir nuevo archivo
                $nuevoArchivo = $request->file('archivo');
                $nombreArchivo = time() . '_' . $nuevoArchivo->getClientOriginalName();
                $ruta = $nuevoArchivo->storeAs('archivos', $nombreArchivo, 'public');
                $archivo->archivo_url = $ruta;
            }

            $archivo->save();

            return redirect()->route('archivos.index')
                ->with('success', 'Archivo actualizado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al actualizar archivo: ' . $e->getMessage());
            return back()->withErrors(['archivo' => 'Error al actualizar el archivo. Inténtalo de nuevo.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ArchivoAdjunto $archivo): RedirectResponse
    {
        try {
            // Eliminar archivo físico
            if ($archivo->archivo_url && Storage::disk('public')->exists($archivo->archivo_url)) {
                Storage::disk('public')->delete($archivo->archivo_url);
            }

            $archivo->delete();

            return redirect()->route('archivos.index')
                ->with('success', 'Archivo eliminado exitosamente.');

        } catch (\Exception $e) {
            Log::error('Error al eliminar archivo: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error al eliminar el archivo. Inténtalo de nuevo.']);
        }
    }

    /**
     * Download the specified file.
     */
    public function download(ArchivoAdjunto $archivo)
    {
        if (!Storage::disk('public')->exists($archivo->archivo_url)) {
            abort(404, 'Archivo no encontrado.');
        }

        return Storage::disk('public')->download($archivo->archivo_url);
    }

    /**
     * Search files by title or description.
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:3'
        ]);

        $search = $request->q;

        $archivos = ArchivoAdjunto::with(['curso.docente'])
            ->where(function($query) use ($search) {
                $query->where('titulo', 'like', '%' . $search . '%')
                      ->orWhereHas('curso', function($subQuery) use ($search) {
                          $subQuery->where('titulo', 'like', '%' . $search . '%');
                      });
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('archivos.index', compact('archivos', 'search'));
    }

    /**
     * Filter files by type.
     */
    public function filtrarPorTipo(Request $request): View
    {
        $request->validate([
            'tipo' => 'required|in:tarea,material,guia'
        ]);

        $archivos = ArchivoAdjunto::with(['curso.docente'])
            ->where('tipo', $request->tipo)
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('archivos.index', compact('archivos'));
    }
}
