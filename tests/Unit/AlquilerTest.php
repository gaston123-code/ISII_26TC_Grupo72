<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Alquiler;
use App\Models\Auto;
use App\Models\Cliente;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\EstadoAuto;
use App\Models\EstadoAlquiler;
use App\States\MantenimientoEstadoAuto;
use App\States\DisponibleEstadoAuto;
use App\States\OcupadoEstadoAuto;
use App\States\PendienteEstadoAlquiler;
use Carbon\Carbon;

class AlquilerTest extends TestCase
{
    use RefreshDatabase;

    /**
    * Helper para crear marcas y modelos (sin cambios de estado). */
    private function createMarcaYModelo()
    {
        $marca = Marca::create(['nombre_marca' => 'MarcaPrueba']);
        $modelo  = Modelo::create(['nombre_modelo' => 'ModeloNeg', 'id_marca' => $marca->id_marca]);
        return [$marca, $modelo];
    }

    /**
    * Helper que crea los registros de estados en la BD (necesario para FK) y devuelve instancias de estado.
    */
    private function createEstadosYObjetos()
    {
        // Registros en tabla EstadoAuto (FK) - use firstOrCreate to avoid duplicates
        EstadoAuto::firstOrCreate(['estado_auto' => 'Disponible']);
        EstadoAuto::firstOrCreate(['estado_auto' => 'Alquilado']);
        EstadoAuto::firstOrCreate(['estado_auto' => 'Mantenimiento']);
        // Registros en tabla EstadoAlquiler (FK) - ensure Cancelado gets id 5, use firstOrCreate
        EstadoAlquiler::firstOrCreate(['estado_alquiler' => 'Pendiente']);
        EstadoAlquiler::firstOrCreate(['estado_alquiler' => 'Confirmado']);
        EstadoAlquiler::firstOrCreate(['estado_alquiler' => 'Activo']);
        EstadoAlquiler::firstOrCreate(['estado_alquiler' => 'Finalizado']);
        EstadoAlquiler::firstOrCreate(['estado_alquiler' => 'Cancelado']);

        // Instancias de objetos de estado (State pattern)
        $disponibleAuto   = new DisponibleEstadoAuto();
        $mantenimientoAuto = new MantenimientoEstadoAuto();
        $ocupadoAuto = new OcupadoEstadoAuto();
        $pendienteAlquiler = new PendienteEstadoAlquiler();
        $canceladoAlquiler = new \App\States\CanceladoEstadoAlquiler();

        return [
            'disponibleAuto'   => $disponibleAuto,
            'mantenimientoAuto'=> $mantenimientoAuto,
            'ocupadoAuto'      => $ocupadoAuto,
            'pendienteAlquiler'=> $pendienteAlquiler,
            'canceladoAlquiler'=> $canceladoAlquiler,
        ];
    }

    /**
     * GRUPO 1: Pruebas unitarias para Alquiler::reservar($data)
     */

    public function test_reservar_crea_alquiler_y_bloquea_auto()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();

        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'descripcion' => 'Auto de prueba',
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'telefono' => '12345678',
            'direccion' => 'Calle Falsa 123',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);

        $fechaRetiro = Carbon::today()->addDays(1)->toDateString();
        $fechaDevolucion = Carbon::today()->addDays(3)->toDateString();

        $alquiler = Alquiler::reservar([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => $fechaRetiro,
            'fecha_devolucion' => $fechaDevolucion,
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
        ]);

        $this->assertNotNull($alquiler->id_reserva);
        $this->assertEquals('Pendiente', $alquiler->estadoAlquiler->estado_alquiler);
        $this->assertEquals('Alquilado', $alquiler->auto->refresh()->estadoAuto->estado_auto);
    }

    public function test_reservar_con_auto_inexistente_lanza_excepcion()
    {
        $states = $this->createEstadosYObjetos();
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'telefono' => '12345678',
            'direccion' => 'Calle Falsa 123',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Alquiler::reservar([
            'id_auto' => 9999, // Inexistente
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
        ]);
    }

    public function test_reservar_con_cliente_inexistente_lanza_excepcion()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'descripcion' => 'Auto de prueba',
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        $this->expectException(\Illuminate\Database\QueryException::class);

        Alquiler::reservar([
            'id_auto' => $auto->id_auto,
            'id_cliente' => 9999, // Inexistente
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
        ]);
    }

    /**
     * GRUPO 2: Pruebas unitarias para Alquiler->cancelarReserva()
     */

    public function test_cancelar_reserva_correctamente()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'descripcion' => 'Auto de prueba',
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['ocupadoAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'telefono' => '12345678',
            'direccion' => 'Calle Falsa 123',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);
        $alquiler = Alquiler::create([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
            'id_estadoAlquiler' => 1, // Pendiente
        ]);

        $resultado = $alquiler->cancelarReserva();

        $this->assertTrue($resultado);
        // Verify that the alquiler is marked as Cancelado via state name
        $this->assertEquals('Cancelado', $alquiler->refresh()->estadoAlquiler->estado_alquiler);
        // Verify that the auto is set to Disponible state
        $this->assertEquals('Disponible', $auto->refresh()->estadoAuto->estado_auto);
    }

    public function test_cancelar_reserva_ya_cancelada()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);
        $alquiler = Alquiler::create([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
            'id_estadoAlquiler' => 5, // Cancelado
        ]);

        $resultado = $alquiler->cancelarReserva();

        $this->assertTrue($resultado);
        $this->assertEquals(5, $alquiler->fresh()->id_estadoAlquiler);
        $this->assertEquals(1, $auto->fresh()->id_estadoAuto);
    }

    public function test_cancelar_reserva_con_auto_en_mantenimiento()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['mantenimientoAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);
        $alquiler = Alquiler::create([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
            'id_estadoAlquiler' => 1, // Pendiente
        ]);

        $resultado = $alquiler->cancelarReserva();

        $this->assertTrue($resultado);
        $this->assertEquals(5, $alquiler->fresh()->id_estadoAlquiler);
        // Nota: Bajo la lógica actual, el estado del auto se cambia forzadamente a Disponible (1).
        $this->assertEquals(1, $auto->fresh()->id_estadoAuto);
    }

    public function test_cancelar_reserva_con_auto_invalido_no_falla()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['ocupadoAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);

        $alquiler = Alquiler::create([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => Carbon::today()->addDays(1)->toDateString(),
            'fecha_devolucion' => Carbon::today()->addDays(3)->toDateString(),
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 200.00,
            'id_estadoAlquiler' => 1, // Pendiente
        ]);

        // Simular que la relación con el auto retorna null (relación desvinculada)
        $alquiler->setRelation('auto', null);

        $resultado = $alquiler->cancelarReserva();

        $this->assertTrue($resultado);
        $this->assertEquals(5, $alquiler->fresh()->id_estadoAlquiler);
    }

    /**
     * GRUPO 3: Pruebas unitarias para Alquiler::verificarConsulta(...)
     */

    public function test_verificar_consulta_detecta_autos_ocupados_y_excluye_cancelados()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto1 = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto1->setState($states['ocupadoAuto']);
        $auto2 = Auto::create([
            'precio' => 120.00,
            'anio' => 2021,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto2->setState($states['disponibleAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);

        // Reserva A activa para Auto 1 (Solapada)
        Alquiler::create([
            'id_auto' => $auto1->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => '2026-06-10',
            'fecha_devolucion' => '2026-06-15',
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 500.00,
            'id_estadoAlquiler' => 1, // Pendiente
        ]);

        // Reserva B cancelada para Auto 2 (No debe figurar ocupado)
        Alquiler::create([
            'id_auto' => $auto2->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => '2026-06-20',
            'fecha_devolucion' => '2026-06-25',
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 600.00,
            'id_estadoAlquiler' => 5, // Cancelado
        ]);

        $ocupados = Alquiler::verificarConsulta('2026-06-12', '2026-06-14', '09:00', '09:00');

        $this->assertContains($auto1->id_auto, $ocupados);
        $this->assertNotContains($auto2->id_auto, $ocupados);
    }

    public function test_verificar_consulta_en_limite_de_fecha_solapada()
    {
        $states = $this->createEstadosYObjetos();
        list($marca, $modelo) = $this->createMarcaYModelo();
        $auto = Auto::create([
            'precio' => 100.00,
            'anio' => 2020,
            'id_modelo' => $modelo->id_modelo,
        ]);
        $auto->setState($states['ocupadoAuto']);
        $cliente = Cliente::create([
            'nombre' => 'Juan',
            'apellido' => 'Perez',
            'dni' => '12345678',
            'email' => 'juan@example.com',
            'contrasena' => 'secret',
        ]);

        // Alquiler del 1 al 5
        Alquiler::create([
            'id_auto' => $auto->id_auto,
            'id_cliente' => $cliente->id_cliente,
            'fecha_retiro' => '2026-06-01',
            'fecha_devolucion' => '2026-06-05',
            'hora_retiro' => '09:00',
            'hora_devolucion' => '09:00',
            'precioTotal' => 400.00,
            'id_estadoAlquiler' => 1,
        ]);

        // Consulta del 5 al 10 (coincide en el límite de fecha 5)
        $ocupados = Alquiler::verificarConsulta('2026-06-05', '2026-06-10', '09:00', '09:00');

        $this->assertContains($auto->id_auto, $ocupados);
    }

    public function test_verificar_consulta_sin_reservas_retorna_vacio()
    {
        $states = $this->createEstadosYObjetos();
        $ocupados = Alquiler::verificarConsulta('2026-09-01', '2026-09-05', '09:00', '09:00');
        $this->assertEmpty($ocupados);
    }
}
