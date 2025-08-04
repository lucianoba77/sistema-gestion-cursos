<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Usuario Administrador
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@cursos.com',
            'password' => Hash::make('admin123'),
            'rol' => 'admin',
        ]);

        // Usuario Coordinador
        User::create([
            'name' => 'Coordinador',
            'email' => 'coordinador@cursos.com',
            'password' => Hash::make('coord123'),
            'rol' => 'coordinador',
        ]);

        // Usuarios adicionales para pruebas
        User::create([
            'name' => 'Juan Pérez',
            'email' => 'juan@cursos.com',
            'password' => Hash::make('password'),
            'rol' => 'admin',
        ]);

        User::create([
            'name' => 'María García',
            'email' => 'maria@cursos.com',
            'password' => Hash::make('password'),
            'rol' => 'coordinador',
        ]);
    }
}
