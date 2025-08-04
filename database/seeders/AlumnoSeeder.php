<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumno;

class AlumnoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alumnos = [
            [
                'nombre' => 'María',
                'apellido' => 'García',
                'dni' => '12345678',
                'email' => 'maria.garcia@email.com',
                'fecha_nacimiento' => '1995-03-15',
                'telefono' => '011-1234-5678',
                'direccion' => 'Av. Santa Fe 1234, CABA',
                'genero' => 'femenino',
                'activo' => true,
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'dni' => '23456789',
                'email' => 'juan.perez@email.com',
                'fecha_nacimiento' => '1998-07-22',
                'telefono' => '011-2345-6789',
                'direccion' => 'Calle Corrientes 567, CABA',
                'genero' => 'masculino',
                'activo' => true,
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'López',
                'dni' => '34567890',
                'email' => 'ana.lopez@email.com',
                'fecha_nacimiento' => '1996-11-08',
                'telefono' => '011-3456-7890',
                'direccion' => 'Belgrano 890, CABA',
                'genero' => 'femenino',
                'activo' => true,
            ],
            [
                'nombre' => 'Carlos',
                'apellido' => 'Rodríguez',
                'dni' => '45678901',
                'email' => 'carlos.rodriguez@email.com',
                'fecha_nacimiento' => '1997-05-12',
                'telefono' => '011-4567-8901',
                'direccion' => 'Palermo 234, CABA',
                'genero' => 'masculino',
                'activo' => true,
            ],
            [
                'nombre' => 'Laura',
                'apellido' => 'Martínez',
                'dni' => '56789012',
                'email' => 'laura.martinez@email.com',
                'fecha_nacimiento' => '1999-09-30',
                'telefono' => '011-5678-9012',
                'direccion' => 'Recoleta 456, CABA',
                'genero' => 'femenino',
                'activo' => true,
            ],
            [
                'nombre' => 'Roberto',
                'apellido' => 'Fernández',
                'dni' => '67890123',
                'email' => 'roberto.fernandez@email.com',
                'fecha_nacimiento' => '1994-12-03',
                'telefono' => '011-6789-0123',
                'direccion' => 'Villa Crespo 789, CABA',
                'genero' => 'masculino',
                'activo' => true,
            ],
            [
                'nombre' => 'Patricia',
                'apellido' => 'González',
                'dni' => '78901234',
                'email' => 'patricia.gonzalez@email.com',
                'fecha_nacimiento' => '1996-02-18',
                'telefono' => '011-7890-1234',
                'direccion' => 'San Telmo 321, CABA',
                'genero' => 'femenino',
                'activo' => true,
            ],
            [
                'nombre' => 'Diego',
                'apellido' => 'Silva',
                'dni' => '89012345',
                'email' => 'diego.silva@email.com',
                'fecha_nacimiento' => '1998-08-25',
                'telefono' => '011-8901-2345',
                'direccion' => 'La Boca 654, CABA',
                'genero' => 'masculino',
                'activo' => false,
            ],
            [
                'nombre' => 'Sofía',
                'apellido' => 'Torres',
                'dni' => '90123456',
                'email' => 'sofia.torres@email.com',
                'fecha_nacimiento' => '1997-04-10',
                'telefono' => '011-9012-3456',
                'direccion' => 'Puerto Madero 987, CABA',
                'genero' => 'femenino',
                'activo' => true,
            ],
            [
                'nombre' => 'Miguel',
                'apellido' => 'Ruiz',
                'dni' => '01234567',
                'email' => 'miguel.ruiz@email.com',
                'fecha_nacimiento' => '1995-10-07',
                'telefono' => '011-0123-4567',
                'direccion' => 'Caballito 147, CABA',
                'genero' => 'masculino',
                'activo' => true,
            ],
        ];

        foreach ($alumnos as $alumno) {
            Alumno::create($alumno);
        }
    }
}
