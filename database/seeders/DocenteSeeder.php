<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Docente;

class DocenteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $docentes = [
            [
                'nombre' => 'Dr. Carlos',
                'apellido' => 'Rodríguez',
                'dni' => '12345678',
                'email' => 'carlos.rodriguez@cursos.com',
                'especialidad' => 'Matemáticas',
                'telefono' => '011-1234-5678',
                'direccion' => 'Av. Corrientes 1234, CABA',
                'activo' => true,
            ],
            [
                'nombre' => 'Lic. Ana',
                'apellido' => 'Martínez',
                'dni' => '23456789',
                'email' => 'ana.martinez@cursos.com',
                'especialidad' => 'Literatura',
                'telefono' => '011-2345-6789',
                'direccion' => 'Calle Florida 567, CABA',
                'activo' => true,
            ],
            [
                'nombre' => 'Prof. Roberto',
                'apellido' => 'López',
                'dni' => '34567890',
                'email' => 'roberto.lopez@cursos.com',
                'especialidad' => 'Historia',
                'telefono' => '011-3456-7890',
                'direccion' => 'Belgrano 890, CABA',
                'activo' => true,
            ],
            [
                'nombre' => 'Ing. Patricia',
                'apellido' => 'Fernández',
                'dni' => '45678901',
                'email' => 'patricia.fernandez@cursos.com',
                'especialidad' => 'Informática',
                'telefono' => '011-4567-8901',
                'direccion' => 'Palermo 234, CABA',
                'activo' => true,
            ],
            [
                'nombre' => 'Mg. Diego',
                'apellido' => 'González',
                'dni' => '56789012',
                'email' => 'diego.gonzalez@cursos.com',
                'especialidad' => 'Física',
                'telefono' => '011-5678-9012',
                'direccion' => 'Recoleta 456, CABA',
                'activo' => true,
            ],
            [
                'nombre' => 'Lic. Laura',
                'apellido' => 'Silva',
                'dni' => '67890123',
                'email' => 'laura.silva@cursos.com',
                'especialidad' => 'Psicología',
                'telefono' => '011-6789-0123',
                'direccion' => 'Villa Crespo 789, CABA',
                'activo' => false,
            ],
        ];

        foreach ($docentes as $docente) {
            Docente::create($docente);
        }
    }
}
