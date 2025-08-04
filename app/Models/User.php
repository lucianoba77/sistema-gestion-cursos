<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // Métodos para verificar roles
    public function isAdmin()
    {
        return $this->rol === 'admin';
    }

    public function isCoordinador()
    {
        return $this->rol === 'coordinador';
    }

    public function isDocente()
    {
        return $this->rol === 'docente';
    }

    public function puedeGestionarDocentes()
    {
        return $this->isAdmin();
    }

    public function puedeGestionarCursos()
    {
        return $this->isAdmin();
    }

    public function puedeGestionarAlumnos()
    {
        return $this->isAdmin() || $this->isCoordinador();
    }

    public function puedeGestionarInscripciones()
    {
        return $this->isAdmin() || $this->isCoordinador();
    }

    public function puedeGestionarEvaluaciones()
    {
        return $this->isAdmin() || $this->isCoordinador() || $this->isDocente();
    }

    public function puedeGestionarArchivos()
    {
        return $this->isAdmin() || $this->isDocente();
    }
}
