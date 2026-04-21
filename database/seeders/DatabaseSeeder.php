<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * DatabaseSeeder — Pobla las tablas con datos iniciales.
 * Ejecutar con: php artisan db:seed
 */
class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Marcas ────────────────────────────────────────────────
        $marcas = ['Volkswagen', 'Ford', 'Chevrolet', 'Toyota', 'Renault', 'Peugeot'];
        foreach ($marcas as $marca) {
            DB::table('marcas')->insertOrIgnore(['nombre_marca' => $marca, 'created_at' => now(), 'updated_at' => now()]);
        }

        // ── Modelos ───────────────────────────────────────────────
        $modelos = [
            ['nombre_modelo' => 'Gol', 'id_marca' => 1],
            ['nombre_modelo' => 'Polo', 'id_marca' => 1],
            ['nombre_modelo' => 'EcoSport', 'id_marca' => 2],
            ['nombre_modelo' => 'Ranger', 'id_marca' => 2],
            ['nombre_modelo' => 'Onix', 'id_marca' => 3],
            ['nombre_modelo' => 'Corolla', 'id_marca' => 4],
            ['nombre_modelo' => 'Hilux', 'id_marca' => 4],
            ['nombre_modelo' => 'Sandero', 'id_marca' => 5],
        ];
        foreach ($modelos as $modelo) {
            DB::table('modelos')->insertOrIgnore(array_merge($modelo, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ── Estado Autos ──────────────────────────────────────────
        $estadosAuto = ['Disponible', 'Alquilado', 'Mantenimiento', 'Fuera de servicio'];
        foreach ($estadosAuto as $estado) {
            DB::table('estado_autos')->insertOrIgnore(['estado_auto' => $estado, 'created_at' => now(), 'updated_at' => now()]);
        }

        // ── Estado Alquileres ─────────────────────────────────────
        $estadosAlquiler = ['Pendiente', 'Confirmado', 'Activo', 'Finalizado', 'Cancelado'];
        foreach ($estadosAlquiler as $estado) {
            DB::table('estado_alquileres')->insertOrIgnore(['estado_alquiler' => $estado, 'created_at' => now(), 'updated_at' => now()]);
        }

        // ── Administrador por defecto ─────────────────────────────
        DB::table('administradores')->insertOrIgnore([
            'nombre'      => 'Admin',
            'apellido'    => 'AutoRent',
            'dni'         => '00000001',
            'email'       => 'admin@autorent.com',
            'contrasena'  => Hash::make('Admin1234!'),
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);

        $this->command->info('✅ Datos iniciales cargados correctamente.');
    }
}
