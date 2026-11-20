<?php

namespace Database\Seeders;

use App\Models\Departamento;
use App\Models\Empleado;
use App\Models\Turno;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@turnopro.com',
            'role' => 'admin',
        ]);

        Turno::create(['nombre' => 'Mañana', 'tipo' => 'AM', 'hora_inicio' => '06:00', 'hora_fin' => '14:00']);
        Turno::create(['nombre' => 'Medio dia', 'tipo' => 'MID', 'hora_inicio' => '10:00', 'hora_fin' => '18:00']);
        Turno::create(['nombre' => 'Tarde', 'tipo' => 'PM', 'hora_inicio' => '14:00', 'hora_fin' => '22:00']);

        $avsec = Departamento::create(['nombre' => 'AVSEC']);

        $nombresPuestos = [
            'Puerta Principal',
            'Rayos X',
            'Mostrador principal',
            'Maquina ETD',
            'Custodio 1',
            'Custodio 2',
            'Remota',
            'Check In',
            'Limpieza 1',
            'Limpieza 2',
        ];

        $puestos = [];
        foreach ($nombresPuestos as $nombre) {
            $puestos[$nombre] = $avsec->puestos()->create(['nombre' => $nombre]);
        }

        $empleados = [
            ['Juan', 'Pérez', 'juan.perez@turnopro.com', 'Puerta Principal'],
            ['María', 'López', 'maria.lopez@turnopro.com', 'Rayos X'],
            ['Carlos', 'Hernández', 'carlos.hernandez@turnopro.com', 'Rayos X'],
            ['Ana', 'García', 'ana.garcia@turnopro.com', 'Mostrador principal'],
            ['Luis', 'Martínez', 'luis.martinez@turnopro.com', 'Maquina ETD'],
            ['Sofía', 'Rodríguez', 'sofia.rodriguez@turnopro.com', 'Custodio 1'],
            ['José', 'Morales', 'jose.morales@turnopro.com', 'Custodio 1'],
            ['Carmen', 'Castillo', 'carmen.castillo@turnopro.com', 'Custodio 2'],
            ['Pedro', 'Ramírez', 'pedro.ramirez@turnopro.com', 'Remota'],
            ['Lucía', 'Gómez', 'lucia.gomez@turnopro.com', 'Check In'],
            ['Miguel', 'Torres', 'miguel.torres@turnopro.com', 'Limpieza 1'],
            ['Rosa', 'Díaz', 'rosa.diaz@turnopro.com', 'Limpieza 1'],
            ['Jorge', 'Cruz', 'jorge.cruz@turnopro.com', 'Limpieza 2'],
        ];

        foreach ($empleados as [$nombre, $apellido, $correo, $puesto]) {
            Empleado::create([
                'nombre' => $nombre,
                'apellido' => $apellido,
                'correo' => $correo,
                'puesto_id' => $puestos[$puesto]->id,
            ]);
        }
    }
}
