<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InscripcionRequest extends FormRequest
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
        return [
            'alumno_id' => 'required|exists:alumnos,id',
            'curso_id' => 'required|exists:cursos,id',
            'fecha_inscripcion' => 'required|date|before_or_equal:today',
            'estado' => 'required|in:activo,aprobado,desaprobado',
            'nota_final' => 'nullable|numeric|min:1|max:10',
            'asistencias' => 'required|integer|min:0|max:20',
            'observaciones' => 'nullable|string|max:500',
            'evaluado_por_docente' => 'boolean',
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
            'alumno_id.required' => 'El alumno es obligatorio.',
            'alumno_id.exists' => 'El alumno seleccionado no existe.',
            'curso_id.required' => 'El curso es obligatorio.',
            'curso_id.exists' => 'El curso seleccionado no existe.',
            'fecha_inscripcion.required' => 'La fecha de inscripción es obligatoria.',
            'fecha_inscripcion.date' => 'La fecha de inscripción debe ser una fecha válida.',
            'fecha_inscripcion.before_or_equal' => 'La fecha de inscripción no puede ser futura.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser: activo, aprobado o desaprobado.',
            'nota_final.numeric' => 'La nota final debe ser un número.',
            'nota_final.min' => 'La nota final debe ser al menos 1.',
            'nota_final.max' => 'La nota final no puede ser mayor a 10.',
            'asistencias.required' => 'Las asistencias son obligatorias.',
            'asistencias.integer' => 'Las asistencias deben ser un número entero.',
            'asistencias.min' => 'Las asistencias no pueden ser negativas.',
            'asistencias.max' => 'Las asistencias no pueden ser mayores a 20.',
            'observaciones.max' => 'Las observaciones no pueden superar los 500 caracteres.',
        ];
    }
} 