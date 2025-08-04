<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class AlumnoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $alumnoId = $this->route('alumno');
        
        return [
            'nombre' => 'required|string|max:255',
            'apellido' => 'required|string|max:255',
            'dni' => 'required|string|max:20|unique:alumnos,dni' . ($alumnoId ? ",{$alumnoId->id}" : ''),
            'email' => 'required|email|unique:alumnos,email' . ($alumnoId ? ",{$alumnoId->id}" : ''),
            'fecha_nacimiento' => 'required|date|before_or_equal:' . Carbon::now()->subYears(16)->format('Y-m-d'),
            'telefono' => 'required|string|max:20',
            'direccion' => 'required|string|max:500',
            'genero' => 'required|in:masculino,femenino,otro',
            'activo' => 'boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre es obligatorio.',
            'apellido.required' => 'El apellido es obligatorio.',
            'dni.required' => 'El DNI es obligatorio.',
            'dni.unique' => 'El DNI ya está registrado.',
            'email.required' => 'El email es obligatorio.',
            'email.email' => 'El email debe tener un formato válido.',
            'email.unique' => 'El email ya está registrado.',
            'fecha_nacimiento.required' => 'La fecha de nacimiento es obligatoria.',
            'fecha_nacimiento.before_or_equal' => 'El alumno debe tener al menos 16 años.',
            'telefono.required' => 'El teléfono es obligatorio.',
            'direccion.required' => 'La dirección es obligatoria.',
            'genero.required' => 'El género es obligatorio.',
            'genero.in' => 'El género debe ser masculino, femenino u otro.',
        ];
    }
}
