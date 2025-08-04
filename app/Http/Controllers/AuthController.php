<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Docente;
use App\Models\Curso;
use App\Models\Alumno;
use App\Models\Inscripcion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

/**
 * Controlador para autenticación y gestión de usuarios del sistema
 * Maneja login, logout, registro y dashboards por rol
 */
class AuthController extends Controller
{
    public function showLogin()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            switch ($user->rol) {
                case 'admin':
                    return redirect('/admin/dashboard');
                case 'coordinador':
                    return redirect('/coordinador/dashboard');
                case 'docente':
                    return redirect('/docente/dashboard');
                default:
                    return redirect('/dashboard');
            }
        }

        return back()->withErrors(['email' => 'Credenciales inválidas']);
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }

    public function showRegister()
    {
        if (Auth::check()) {
            return redirect('/dashboard');
        }
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'rol' => 'required|in:admin,coordinador,docente'
        ]);

        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return back()->withErrors(['rol' => 'No tienes permisos para crear usuarios']);
        }

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'rol' => $request->input('rol'),
        ]);

        return redirect('/users')->with('success', 'Usuario creado exitosamente');
    }



    public function adminDashboard()
    {
        if (!Auth::check() || !Auth::user()->isAdmin()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $stats = $this->getDashboardStats();

        return view('admin.dashboard', compact('user', 'stats'));
    }

    public function coordinadorDashboard()
    {
        if (!Auth::check() || !Auth::user()->isCoordinador()) {
            return redirect('/login');
        }

        $user = Auth::user();
        $stats = $this->getDashboardStats();

        return view('coordinador.dashboard', compact('user', 'stats'));
    }

    public function docenteDashboard()
    {
        if (!Auth::check() || !Auth::user()->isDocente()) {
            return redirect('/login');
        }

        $user = Auth::user();
        
        // Obtener el docente correspondiente al usuario
        $docente = Docente::where('email', $user->email)->first();
        
        if (!$docente) {
            return redirect('/login')->withErrors(['error' => 'Docente no encontrado']);
        }

        // Obtener cursos activos del docente
        $cursos = $docente->cursosActivos()->withCount('inscripciones as total_alumnos')->get();

        return view('docente.dashboard', compact('user', 'cursos', 'docente'));
    }

    private function getDashboardStats()
    {
        return [
            'total_users' => User::count(),
            'total_alumnos' => Alumno::activos()->count(),
            'total_docentes' => Docente::activos()->count(),
            'total_cursos' => Curso::activos()->count(),
            'cursos_activos' => Curso::activos()->count(),
            'total_inscripciones' => Inscripcion::activas()->count(),
            'inscripciones' => Inscripcion::count(),
            'inscripciones_pendientes' => Inscripcion::where('estado', 'pendiente')->count(),
        ];
    }

    public function profile()
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $user = Auth::user();
        return view('auth.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        if (!Auth::check()) {
            return redirect('/login');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'current_password' => 'nullable|string',
            'new_password' => 'nullable|string|min:8|confirmed'
        ]);

        $user = Auth::user();

        if ($request->input('current_password')) {
            if (!Hash::check($request->input('current_password'), $user->password)) {
                return back()->withErrors(['current_password' => 'Contraseña actual incorrecta']);
            }
        }

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if ($request->input('new_password')) {
            $user->password = Hash::make($request->input('new_password'));
        }

        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil actualizado exitosamente');
    }
}
