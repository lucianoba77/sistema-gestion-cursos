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
        Schema::create('archivos_adjuntos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->nullable()->constrained('cursos')->onDelete('cascade');
            $table->string('titulo');
            $table->string('archivo_url');
            $table->enum('tipo', ['tarea', 'material', 'guia'])->notNull();
            $table->timestamp('fecha_subida')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archivos_adjuntos');
    }
};
