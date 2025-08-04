<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained('cursos')->onDelete('cascade');
            $table->date('fecha_inscripcion');
            $table->enum('estado', ['activo', 'aprobado', 'desaprobado'])->default('activo');
            $table->decimal('nota_final', 3, 1)->nullable();
            $table->integer('asistencias')->default(0);
            $table->text('observaciones')->nullable();
            $table->boolean('evaluado_por_docente')->default(false);
            $table->timestamps();
            
            // Índice único para evitar duplicados
            $table->unique(['alumno_id', 'curso_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inscripciones');
    }
};
