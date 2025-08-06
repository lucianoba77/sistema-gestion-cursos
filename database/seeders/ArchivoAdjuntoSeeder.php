<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ArchivoAdjunto;
use App\Models\Curso;
use Carbon\Carbon;

class ArchivoAdjuntoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cursos = Curso::activos()->get();

        if ($cursos->isEmpty()) {
            $this->command->warn('No hay cursos activos para crear archivos adjuntos');
            return;
        }

        // Crear archivos adjuntos usando solo los cursos disponibles
        $archivos = [
            // Matemáticas Avanzadas
            [
                'curso_id' => $cursos->first()->id,
                'titulo' => 'Guía de Álgebra Lineal',
                'archivo_url' => '/archivos/guia-algebra-lineal.pdf',
                'tipo' => 'guia',
                'fecha_subida' => Carbon::create(2024, 3, 5, 13, 0, 0),
            ],
            [
                'curso_id' => $cursos->first()->id,
                'titulo' => 'Ejercicios de Cálculo',
                'archivo_url' => '/archivos/ejercicios-calculo.pdf',
                'tipo' => 'material',
                'fecha_subida' => Carbon::create(2024, 3, 10, 17, 0, 0),
            ],
            // Literatura Argentina
            [
                'curso_id' => $cursos->skip(1)->first()->id,
                'titulo' => 'Antología de Borges',
                'archivo_url' => '/archivos/antologia-borges.pdf',
                'tipo' => 'material',
                'fecha_subida' => Carbon::create(2024, 3, 20, 12, 0, 0),
            ],
            [
                'curso_id' => $cursos->skip(1)->first()->id,
                'titulo' => 'Tarea de Análisis Literario',
                'archivo_url' => '/archivos/tarea-analisis-literario.pdf',
                'tipo' => 'tarea',
                'fecha_subida' => Carbon::create(2024, 4, 15, 19, 0, 0),
            ],
            // Historia de América Latina
            [
                'curso_id' => $cursos->skip(2)->first()->id,
                'titulo' => 'Mapa de América Colonial',
                'archivo_url' => '/archivos/mapa-america-colonial.jpg',
                'tipo' => 'material',
                'fecha_subida' => Carbon::create(2024, 4, 5, 14, 0, 0),
            ],
            // Biología Molecular
            [
                'curso_id' => $cursos->skip(3)->first()->id,
                'titulo' => 'Protocolo de Laboratorio',
                'archivo_url' => '/archivos/protocolo-laboratorio.pdf',
                'tipo' => 'guia',
                'fecha_subida' => Carbon::create(2024, 3, 15, 16, 0, 0),
            ],
            // Inglés Conversacional
            [
                'curso_id' => $cursos->skip(4)->first()->id,
                'titulo' => 'Guía de Pronunciación',
                'archivo_url' => '/archivos/guia-pronunciacion.pdf',
                'tipo' => 'guia',
                'fecha_subida' => Carbon::create(2024, 3, 25, 18, 0, 0),
            ],
            // Programación Web
            [
                'curso_id' => $cursos->skip(5)->first()->id,
                'titulo' => 'Manual de HTML y CSS',
                'archivo_url' => '/archivos/manual-html-css.pdf',
                'tipo' => 'material',
                'fecha_subida' => Carbon::create(2024, 4, 20, 13, 0, 0),
            ],
        ];

        foreach ($archivos as $archivo) {
            ArchivoAdjunto::create($archivo);
        }

        $this->command->info('Archivos adjuntos de prueba creados exitosamente');
    }
} 