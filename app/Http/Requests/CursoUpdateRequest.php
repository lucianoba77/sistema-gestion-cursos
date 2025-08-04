<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CursoUpdateRequest extends FormRequest
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
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
            'estado' => 'required|in:activo,finalizado,cancelado',
            'modalidad' => 'required|in:presencial,virtual,hibrido',
            'aula_virtual' => 'string|max:255|required_if:modalidad,virtual,hibrido',
            'cupos_maximos' => 'required|integer|min:1|max:100',
            'docente_id' => 'required|exists:docentes,id|docente_activo|docente_max_cursos_edit',
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
            'titulo.required' => 'El título es obligatorio.',
            'descripcion.required' => 'La descripción es obligatoria.',
            'fecha_inicio.required' => 'La fecha de inicio es obligatoria.',
            'fecha_fin.required' => 'La fecha de fin es obligatoria.',
            'fecha_fin.after' => 'La fecha de fin debe ser posterior a la fecha de inicio.',
            'estado.required' => 'El estado es obligatorio.',
            'estado.in' => 'El estado debe ser activo, finalizado o cancelado.',
            'modalidad.required' => 'La modalidad es obligatoria.',
            'modalidad.in' => 'La modalidad debe ser presencial, virtual o híbrido.',
            'aula_virtual.required_if' => 'El aula virtual es obligatoria para modalidades virtual o híbrido.',
            'cupos_maximos.required' => 'Los cupos máximos son obligatorios.',
            'cupos_maximos.integer' => 'Los cupos máximos deben ser un número entero.',
            'cupos_maximos.min' => 'Los cupos máximos deben ser al menos 1.',
            'cupos_maximos.max' => 'Los cupos máximos no pueden superar 100.',
            'docente_id.required' => 'El docente es obligatorio.',
            'docente_id.exists' => 'El docente seleccionado no existe.',
            'docente_id.docente_activo' => 'No se pueden asignar cursos a docentes inactivos.',
            'docente_id.docente_max_cursos_edit' => 'El docente ya tiene el máximo de cursos activos permitidos (3).',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->addExtension('docente_activo', function ($attribute, $value, $parameters, $validator) {
            $docente = \App\Models\Docente::find($value);
            return $docente && $docente->activo;
        });

        $validator->addExtension('docente_max_cursos_edit', function ($attribute, $value, $parameters, $validator) {
            $docente = \App\Models\Docente::find($value);
            if (!$docente || !$docente->activo) {
                return false;
            }
            
            // Obtener el curso que se está editando
            $cursoId = $this->route('curso')->id;
            
            // Contar cursos activos excluyendo el curso actual
            $cursosActivos = $docente->cursos()
                ->where('estado', 'activo')
                ->where('id', '!=', $cursoId)
                ->count();
            
            return $cursosActivos < 3;
        });
    }
} 