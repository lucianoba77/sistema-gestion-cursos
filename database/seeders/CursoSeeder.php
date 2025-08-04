<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Curso;
use App\Models\Docente;

class CursoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docentes = Docente::where('activo', true)->get();

        if ($docentes->count() == 0) {
            $this->command->error('No hay docentes activos para asignar cursos.');
            return;
        }

        $cursos = [
            [
                'titulo' => 'Matemáticas Avanzadas',
                'descripcion' => 'Curso de matemáticas para nivel avanzado, incluyendo cálculo diferencial e integral.',
                'fecha_inicio' => '2024-03-01',
                'fecha_fin' => '2024-06-30',
                'estado' => 'activo',
                'modalidad' => 'presencial',
                'aula_virtual' => null,
                'cupos_maximos' => 25,
                'docente_id' => $docentes->where('especialidad', 'Matemáticas')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Literatura Contemporánea',
                'descripcion' => 'Análisis de obras literarias contemporáneas y técnicas de escritura creativa.',
                'fecha_inicio' => '2024-03-15',
                'fecha_fin' => '2024-07-15',
                'estado' => 'activo',
                'modalidad' => 'hibrido',
                'aula_virtual' => 'https://meet.google.com/literatura-contemporanea',
                'cupos_maximos' => 20,
                'docente_id' => $docentes->where('especialidad', 'Literatura')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Historia Argentina',
                'descripcion' => 'Estudio de la historia argentina desde la independencia hasta la actualidad.',
                'fecha_inicio' => '2024-02-01',
                'fecha_fin' => '2024-05-31',
                'estado' => 'finalizado',
                'modalidad' => 'presencial',
                'aula_virtual' => null,
                'cupos_maximos' => 30,
                'docente_id' => $docentes->where('especialidad', 'Historia')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Programación Web',
                'descripcion' => 'Desarrollo web con HTML, CSS, JavaScript y frameworks modernos.',
                'fecha_inicio' => '2024-04-01',
                'fecha_fin' => '2024-08-31',
                'estado' => 'activo',
                'modalidad' => 'virtual',
                'aula_virtual' => 'https://zoom.us/j/programacion-web',
                'cupos_maximos' => 35,
                'docente_id' => $docentes->where('especialidad', 'Informática')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Física Cuántica',
                'descripcion' => 'Introducción a los principios fundamentales de la física cuántica.',
                'fecha_inicio' => '2024-05-01',
                'fecha_fin' => '2024-09-30',
                'estado' => 'activo',
                'modalidad' => 'hibrido',
                'aula_virtual' => 'https://teams.microsoft.com/fisica-cuantica',
                'cupos_maximos' => 15,
                'docente_id' => $docentes->where('especialidad', 'Física')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Psicología Social',
                'descripcion' => 'Estudio de la interacción entre individuos y grupos sociales.',
                'fecha_inicio' => '2024-01-15',
                'fecha_fin' => '2024-04-15',
                'estado' => 'cancelado',
                'modalidad' => 'presencial',
                'aula_virtual' => null,
                'cupos_maximos' => 25,
                'docente_id' => $docentes->where('especialidad', 'Psicología')->first()->id ?? $docentes->first()->id,
            ],
            [
                'titulo' => 'Inglés Avanzado',
                'descripcion' => 'Curso de inglés para nivel avanzado con enfoque en conversación y escritura.',
                'fecha_inicio' => '2024-06-01',
                'fecha_fin' => '2024-10-31',
                'estado' => 'activo',
                'modalidad' => 'virtual',
                'aula_virtual' => 'https://meet.google.com/ingles-avanzado',
                'cupos_maximos' => 20,
                'docente_id' => $docentes->first()->id,
            ],
            [
                'titulo' => 'Arte Digital',
                'descripcion' => 'Creación de arte digital usando herramientas y software especializado.',
                'fecha_inicio' => '2024-07-01',
                'fecha_fin' => '2024-11-30',
                'estado' => 'activo',
                'modalidad' => 'hibrido',
                'aula_virtual' => 'https://discord.gg/arte-digital',
                'cupos_maximos' => 18,
                'docente_id' => $docentes->first()->id,
            ],
        ];

        foreach ($cursos as $curso) {
            Curso::create($curso);
        }
    }
}
