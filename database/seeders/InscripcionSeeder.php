<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Inscripcion;
use App\Models\Alumno;
use App\Models\Curso;
use Carbon\Carbon;

class InscripcionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = Alumno::activos()->get();
        $cursos = Curso::activos()->get();

        if ($alumnos->isEmpty() || $cursos->isEmpty()) {
            $this->command->warn('No hay alumnos o cursos activos para crear inscripciones');
            return;
        }

        // Crear inscripciones de prueba
        $inscripciones = [
            // Alumno 1 - Curso 1
            [
                'alumno_id' => $alumnos->first()->id,
                'curso_id' => $cursos->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(30),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 15,
                'observaciones' => 'Alumno con buen rendimiento',
                'evaluado_por_docente' => false,
            ],
            // Alumno 1 - Curso 2
            [
                'alumno_id' => $alumnos->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(25),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 12,
                'observaciones' => 'Asistencia regular',
                'evaluado_por_docente' => false,
            ],
            // Alumno 2 - Curso 1
            [
                'alumno_id' => $alumnos->skip(1)->first()->id,
                'curso_id' => $cursos->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(28),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 18,
                'observaciones' => 'Excelente asistencia',
                'evaluado_por_docente' => false,
            ],
            // Alumno 2 - Curso 3
            [
                'alumno_id' => $alumnos->skip(1)->first()->id,
                'curso_id' => $cursos->skip(2)->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(20),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 8,
                'observaciones' => 'Baja asistencia',
                'evaluado_por_docente' => false,
            ],
            // Alumno 3 - Curso 2
            [
                'alumno_id' => $alumnos->skip(2)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(22),
                'estado' => 'aprobado',
                'nota_final' => 8.5,
                'asistencias' => 19,
                'observaciones' => 'Curso completado exitosamente',
                'evaluado_por_docente' => true,
            ],
            // Alumno 4 - Curso 1
            [
                'alumno_id' => $alumnos->skip(3)->first()->id,
                'curso_id' => $cursos->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(15),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 10,
                'observaciones' => 'Rendimiento aceptable',
                'evaluado_por_docente' => false,
            ],
            // Alumno 5 - Curso 4
            [
                'alumno_id' => $alumnos->skip(4)->first()->id,
                'curso_id' => $cursos->skip(3)->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(35),
                'estado' => 'desaprobado',
                'nota_final' => 4.0,
                'asistencias' => 6,
                'observaciones' => 'No alcanzó los objetivos mínimos',
                'evaluado_por_docente' => true,
            ],
            // Alumno 6 - Curso 2
            [
                'alumno_id' => $alumnos->skip(5)->first()->id,
                'curso_id' => $cursos->skip(1)->first()->id,
                'fecha_inscripcion' => Carbon::now()->subDays(18),
                'estado' => 'activo',
                'nota_final' => null,
                'asistencias' => 14,
                'observaciones' => 'Progreso satisfactorio',
                'evaluado_por_docente' => false,
            ],
        ];

        foreach ($inscripciones as $inscripcion) {
            Inscripcion::create($inscripcion);
        }

        $this->command->info('Inscripciones de prueba creadas exitosamente');
    }
} 