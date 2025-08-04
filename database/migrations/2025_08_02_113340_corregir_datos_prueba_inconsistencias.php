<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        echo "🔧 Corrigiendo inconsistencias en datos de prueba...\n\n";

        // 1. Corregir alumnos menores de 16 años
        echo "📝 Corrigiendo fechas de nacimiento de alumnos menores de 16 años...\n";
        $alumnosMenores = DB::table('alumnos')
            ->whereRaw('TIMESTAMPDIFF(YEAR, fecha_nacimiento, CURDATE()) < 16')
            ->get();

        foreach ($alumnosMenores as $alumno) {
            // Cambiar fecha de nacimiento para que tengan 18 años
            $nuevaFecha = date('Y-m-d', strtotime('-18 years'));
            DB::table('alumnos')
                ->where('id', $alumno->id)
                ->update(['fecha_nacimiento' => $nuevaFecha]);
            
            echo "  ✅ Alumno {$alumno->nombre} {$alumno->apellido}: fecha corregida a {$nuevaFecha}\n";
        }

        // 2. Corregir evaluaciones para alumnos no inscritos activamente
        echo "\n📝 Corrigiendo evaluaciones inconsistentes...\n";
        
        // Primero, identificar las evaluaciones problemáticas
        $evaluacionesInconsistentes = DB::table('evaluaciones as e')
            ->leftJoin('inscripciones as i', function($join) {
                $join->on('i.alumno_id', '=', 'e.alumno_id')
                     ->on('i.curso_id', '=', 'e.curso_id')
                     ->where('i.estado', '=', 'activo');
            })
            ->whereNull('i.id')
            ->select('e.id', 'e.alumno_id', 'e.curso_id', 'e.fecha')
            ->get();

        foreach ($evaluacionesInconsistentes as $evaluacion) {
            // Verificar si el alumno está inscrito en el curso con estado diferente a 'activo'
            $inscripcion = DB::table('inscripciones')
                ->where('alumno_id', $evaluacion->alumno_id)
                ->where('curso_id', $evaluacion->curso_id)
                ->first();

            if ($inscripcion) {
                // Cambiar el estado de la inscripción a 'activo'
                DB::table('inscripciones')
                    ->where('id', $inscripcion->id)
                    ->update(['estado' => 'activo']);
                
                echo "  ✅ Evaluación ID {$evaluacion->id}: inscripción cambiada a 'activo'\n";
            } else {
                // Crear una nueva inscripción activa
                DB::table('inscripciones')->insert([
                    'alumno_id' => $evaluacion->alumno_id,
                    'curso_id' => $evaluacion->curso_id,
                    'estado' => 'activo',
                    'fecha_inscripcion' => $evaluacion->fecha,
                    'asistencias' => 15, // Valor por defecto
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                echo "  ✅ Evaluación ID {$evaluacion->id}: nueva inscripción creada\n";
            }
        }

        // 3. Corregir docente inactivo con cursos activos
        echo "\n📝 Corrigiendo docente inactivo con cursos activos...\n";
        $docenteInactivo = DB::table('docentes')
            ->where('activo', false)
            ->whereExists(function($query) {
                $query->select(DB::raw(1))
                      ->from('cursos')
                      ->whereColumn('cursos.docente_id', 'docentes.id')
                      ->where('cursos.estado', 'activo');
            })
            ->first();

        if ($docenteInactivo) {
            // Activar el docente
            DB::table('docentes')
                ->where('id', $docenteInactivo->id)
                ->update(['activo' => true]);
            
            echo "  ✅ Docente {$docenteInactivo->nombre} {$docenteInactivo->apellido}: activado\n";
        }

        echo "\n✅ Todas las inconsistencias han sido corregidas.\n";
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        echo "⚠️  Esta migración no puede ser revertida automáticamente.\n";
        echo "   Los datos corregidos se mantendrán en la base de datos.\n";
    }
};
