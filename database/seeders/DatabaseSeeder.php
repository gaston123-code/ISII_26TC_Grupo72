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
            'nombre' => 'Admin',
            'apellido' => 'AutoRent',
            'dni' => '00000001',
            'email' => 'admin@autorent.com',
            'contrasena' => Hash::make('Admin1234!'),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Cliente de prueba ────────────────────────────────────
        DB::table('clientes')->insertOrIgnore([
            'nombre' => 'Martín',
            'apellido' => 'González',
            'dni' => '30123456',
            'telefono' => '3794000000',
            'direccion' => 'Av. Corrientes 1234',
            'email' => 'martin.gonzalez@gmail.com',
            'contrasena' => Hash::make('Cliente1234!'),
            'licencia' => 'LIC-001',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Autos de ejemplo ─────────────────────────────────────
        $autos = [
            ['precio' => 25000, 'anio' => 2023, 'descripcion' => 'Compacto económico ideal para ciudad', 'id_modelo' => 1, 'id_estadoAuto' => 1],   // Gol
            ['precio' => 32000, 'anio' => 2024, 'descripcion' => 'Sedán moderno con excelente equipamiento', 'id_modelo' => 2, 'id_estadoAuto' => 1],   // Polo
            ['precio' => 45000, 'anio' => 2024, 'descripcion' => 'SUV familiar con gran espacio interior', 'id_modelo' => 3, 'id_estadoAuto' => 1],   // EcoSport
            ['precio' => 55000, 'anio' => 2023, 'descripcion' => 'Pick-up robusta para todo terreno', 'id_modelo' => 4, 'id_estadoAuto' => 1],   // Ranger
            ['precio' => 28000, 'anio' => 2024, 'descripcion' => 'Hatchback ágil con bajo consumo', 'id_modelo' => 5, 'id_estadoAuto' => 1],   // Onix
            ['precio' => 40000, 'anio' => 2023, 'descripcion' => 'Sedán premium con tecnología avanzada', 'id_modelo' => 6, 'id_estadoAuto' => 1],   // Corolla
            ['precio' => 60000, 'anio' => 2024, 'descripcion' => 'Pick-up líder en potencia y confort', 'id_modelo' => 7, 'id_estadoAuto' => 1],   // Hilux
            ['precio' => 22000, 'anio' => 2023, 'descripcion' => 'Compacto versátil con buen rendimiento', 'id_modelo' => 8, 'id_estadoAuto' => 1],   // Sandero
        ];
        foreach ($autos as $auto) {
            DB::table('autos')->insertOrIgnore(array_merge($auto, ['created_at' => now(), 'updated_at' => now()]));
        }

        // ── Clientes adicionales ─────────────────────────────────
        DB::table('clientes')->insertOrIgnore([
            'nombre' => 'Laura',
            'apellido' => 'Fernández',
            'dni' => '32654789',
            'telefono' => '3794111111',
            'direccion' => 'San Martín 567',
            'email' => 'laura.fernandez@gmail.com',
            'contrasena' => Hash::make('Cliente1234!'),
            'licencia' => 'LIC-002',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        DB::table('clientes')->insertOrIgnore([
            'nombre' => 'Carlos',
            'apellido' => 'López',
            'dni' => '28987654',
            'telefono' => '3794222222',
            'direccion' => 'Belgrano 890',
            'email' => 'carlos.lopez@gmail.com',
            'contrasena' => Hash::make('Cliente1234!'),
            'licencia' => 'LIC-003',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // ── Alquileres de ejemplo ────────────────────────────────
        // Estados: 1=Pendiente, 2=Confirmado, 3=Activo, 4=Finalizado, 5=Cancelado

        // Alquiler 1: Finalizado (Martín alquiló el Gol la semana pasada)
        DB::table('alquileres')->insertOrIgnore([
            'id_reserva' => 1,
            'fecha_retiro' => now()->subDays(10)->format('Y-m-d'),
            'fecha_devolucion' => now()->subDays(7)->format('Y-m-d'),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '18:00',
            'identificador_unico' => 'RES-2026-0001',
            'firma_digital' => null,
            'precioTotal' => 75000.00,  // 3 días x $25.000
            'id_cliente' => 1,  // Martín
            'id_auto' => 1,  // Gol
            'id_estadoAlquiler' => 4,  // Finalizado
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(7),
        ]);

        // Alquiler 2: Activo (Laura tiene el Corolla ahora)
        DB::table('alquileres')->insertOrIgnore([
            'id_reserva' => 2,
            'fecha_retiro' => now()->subDays(2)->format('Y-m-d'),
            'fecha_devolucion' => now()->addDays(3)->format('Y-m-d'),
            'hora_retiro' => '10:00',
            'hora_devolucion' => '10:00',
            'identificador_unico' => 'RES-2026-0002',
            'firma_digital' => null,
            'precioTotal' => 200000.00,  // 5 días x $40.000
            'id_cliente' => 2,  // Laura
            'id_auto' => 6,  // Corolla
            'id_estadoAlquiler' => 3,  // Activo
            'created_at' => now()->subDays(3),
            'updated_at' => now()->subDays(2),
        ]);
        // Marcar Corolla como Alquilado
        DB::table('autos')->where('id_auto', 6)->update(['id_estadoAuto' => 2]);

        // Alquiler 3: Confirmado (Carlos reservó la Hilux para la próxima semana)
        DB::table('alquileres')->insertOrIgnore([
            'id_reserva' => 3,
            'fecha_retiro' => now()->addDays(5)->format('Y-m-d'),
            'fecha_devolucion' => now()->addDays(8)->format('Y-m-d'),
            'hora_retiro' => '08:00',
            'hora_devolucion' => '18:00',
            'identificador_unico' => 'RES-2026-0003',
            'firma_digital' => null,
            'precioTotal' => 180000.00,  // 3 días x $60.000
            'id_cliente' => 3,  // Carlos
            'id_auto' => 7,  // Hilux
            'id_estadoAlquiler' => 2,  // Confirmado
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        // Alquiler 4: Pendiente (Martín quiere la EcoSport)
        DB::table('alquileres')->insertOrIgnore([
            'id_reserva' => 4,
            'fecha_retiro' => now()->addDays(3)->format('Y-m-d'),
            'fecha_devolucion' => now()->addDays(5)->format('Y-m-d'),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '17:00',
            'identificador_unico' => 'RES-2026-0004',
            'firma_digital' => null,
            'precioTotal' => 90000.00,  // 2 días x $45.000
            'id_cliente' => 1,  // Martín
            'id_auto' => 3,  // EcoSport
            'id_estadoAlquiler' => 1,  // Pendiente
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Alquiler 5: Cancelado (Laura había reservado el Polo pero canceló)
        DB::table('alquileres')->insertOrIgnore([
            'id_reserva' => 5,
            'fecha_retiro' => now()->addDays(1)->format('Y-m-d'),
            'fecha_devolucion' => now()->addDays(4)->format('Y-m-d'),
            'hora_retiro' => '11:00',
            'hora_devolucion' => '11:00',
            'identificador_unico' => 'RES-2026-0005',
            'firma_digital' => null,
            'precioTotal' => 96000.00,  // 3 días x $32.000
            'id_cliente' => 2,  // Laura
            'id_auto' => 2,  // Polo
            'id_estadoAlquiler' => 5,  // Cancelado
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(1),
        ]);

        // ── Pagos ────────────────────────────────────────────────
        // Pago del alquiler 1 (Finalizado - pagado con tarjeta)
        DB::table('pagos')->insertOrIgnore([
            'id_pago' => 1,
            'monto' => 75000.00,
            'medio_pago' => 'Tarjeta',
            'fecha_pago' => now()->subDays(10)->format('Y-m-d'),
            'id_reserva' => 1,
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);

        // Pago del alquiler 2 (Activo - pagado con transferencia)
        DB::table('pagos')->insertOrIgnore([
            'id_pago' => 2,
            'monto' => 200000.00,
            'medio_pago' => 'Transferencia',
            'fecha_pago' => now()->subDays(2)->format('Y-m-d'),
            'id_reserva' => 2,
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        // Pago del alquiler 3 (Confirmado - pagado en efectivo)
        DB::table('pagos')->insertOrIgnore([
            'id_pago' => 3,
            'monto' => 180000.00,
            'medio_pago' => 'Efectivo',
            'fecha_pago' => now()->subDays(1)->format('Y-m-d'),
            'id_reserva' => 3,
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);

        $this->command->info('✅ Datos iniciales cargados correctamente.');
    }
}
