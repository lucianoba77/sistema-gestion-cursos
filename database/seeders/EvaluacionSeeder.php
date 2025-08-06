<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Evaluacion;
use App\Models\Alumno;
use App\Models\Curso;
use Carbon\Carbon;

class EvaluacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = Alumno::activos()->get();
        $cursos = Curso::activos()->get();

        if ($alumnos->isEmpty() || $cursos->isEmpty()) {
            $this->command->warn('No hay alumnos o cursos activos para crear evaluaciones');
            return;
        }

        // Crear evaluaciones usando solo los alumnos disponibles
        $evaluaciones = [
            // Matemáticas Avanzadas
            [
                'alumno_id' => $alumnos->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Primer Parcial - Álgebra',
                'nota' => 8.5,
                'fecha' => Carbon::create(2024, 4, 15),
            ],
            [
                'alumno_id' => $alumnos->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Segundo Parcial - Cálculo',
                'nota' => 8.0,
                'fecha' => Carbon::create(2024, 5, 20),
            ],
            [
                'alumno_id' => $alumnos->skip(1)->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Primer Parcial - Álgebra',
                'nota' => 7.8,
                'fecha' => Carbon::create(2024, 4, 15),
            ],
            [
                'alumno_id' => $alumnos->skip(1)->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Segundo Parcial - Cálculo',
                'nota' => 7.5,
                'fecha' => Carbon::create(2024, 5, 20),
            ],
            [
                'alumno_id' => $alumnos->skip(2)->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Primer Parcial - Álgebra',
                'nota' => 4.2,
                'fecha' => Carbon::create(2024, 4, 15),
            ],
            [
                'alumno_id' => $alumnos->skip(3)->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Primer Parcial - Álgebra',
                'nota' => 9.1,
                'fecha' => Carbon::create(2024, 4, 15),
            ],
            [
                'alumno_id' => $alumnos->skip(3)->first()->id,
                'curso_id' => $cursos->first()->id,
                'descripcion' => 'Segundo Parcial - Cálculo',
                'nota' => 9.0,
                'fecha' => Carbon::create(2024, 5, 20),
            ],
            // Literatura Argentina
            [
                'alumno_id' => $alumnos->skip(4)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'descripcion' => 'Análisis Literario - Borges',
                'nota' => 8.0,
                'fecha' => Carbon::create(2024, 5, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(5)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'descripcion' => 'Análisis Literario - Borges',
                'nota' => 7.5,
                'fecha' => Carbon::create(2024, 5, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(6)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'descripcion' => 'Análisis Literario - Borges',
                'nota' => 3.8,
                'fecha' => Carbon::create(2024, 5, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(7)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'descripcion' => 'Análisis Literario - Borges',
                'nota' => 8.8,
                'fecha' => Carbon::create(2024, 5, 10),
            ],
            // Historia de América Latina
            [
                'alumno_id' => $alumnos->skip(8)->first()->id,
                'curso_id' => $cursos->skip(2)->first()->id,
                'descripcion' => 'Examen - Período Colonial',
                'nota' => 7.9,
                'fecha' => Carbon::create(2024, 6, 15),
            ],
            // Biología Molecular
            [
                'alumno_id' => $alumnos->first()->id,
                'curso_id' => $cursos->skip(3)->first()->id,
                'descripcion' => 'Laboratorio - ADN',
                'nota' => 9.2,
                'fecha' => Carbon::create(2024, 6, 20),
            ],
            [
                'alumno_id' => $alumnos->skip(1)->first()->id,
                'curso_id' => $cursos->skip(3)->first()->id,
                'descripcion' => 'Laboratorio - ADN',
                'nota' => 8.7,
                'fecha' => Carbon::create(2024, 6, 20),
            ],
            [
                'alumno_id' => $alumnos->skip(2)->first()->id,
                'curso_id' => $cursos->skip(3)->first()->id,
                'descripcion' => 'Laboratorio - ADN',
                'nota' => 3.9,
                'fecha' => Carbon::create(2024, 6, 20),
            ],
            [
                'alumno_id' => $alumnos->skip(3)->first()->id,
                'curso_id' => $cursos->skip(3)->first()->id,
                'descripcion' => 'Laboratorio - ADN',
                'nota' => 7.8,
                'fecha' => Carbon::create(2024, 6, 20),
            ],
            // Inglés Conversacional
            [
                'alumno_id' => $alumnos->skip(4)->first()->id,
                'curso_id' => $cursos->skip(4)->first()->id,
                'descripcion' => 'Examen Oral - Conversación',
                'nota' => 8.4,
                'fecha' => Carbon::create(2024, 7, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(5)->first()->id,
                'curso_id' => $cursos->skip(4)->first()->id,
                'descripcion' => 'Examen Oral - Conversación',
                'nota' => 7.9,
                'fecha' => Carbon::create(2024, 7, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(6)->first()->id,
                'curso_id' => $cursos->skip(4)->first()->id,
                'descripcion' => 'Examen Oral - Conversación',
                'nota' => 4.1,
                'fecha' => Carbon::create(2024, 7, 10),
            ],
            [
                'alumno_id' => $alumnos->skip(7)->first()->id,
                'curso_id' => $cursos->skip(4)->first()->id,
                'descripcion' => 'Examen Oral - Conversación',
                'nota' => 8.6,
                'fecha' => Carbon::create(2024, 7, 10),
            ],
        ];

        foreach ($evaluaciones as $evaluacion) {
            Evaluacion::create($evaluacion);
        }

        $this->command->info('Evaluaciones de prueba creadas exitosamente');
    }
} 