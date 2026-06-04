<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Auto;
use App\Models\Marca;
use App\Models\Modelo;
use App\Models\Cliente;
use App\Models\EstadoAuto;
use App\Models\EstadoAlquiler;
use App\Models\Alquiler;
use App\States\DisponibleEstadoAuto;
use App\States\OcupadoEstadoAuto;
use App\States\MantenimientoEstadoAuto;

/**
 * Pruebas unitarias para la administración de autos (registro, modificación y eliminación).
 */
class AdminAutosTest extends TestCase
{
    use RefreshDatabase;

    /** Helper para crear los estados de Auto y de Alquiler. */
    private function createEstados()
    {
        EstadoAuto::create(['estado_auto' => 'Disponible']); // id 1
        EstadoAuto::create(['estado_auto' => 'Alquilado']); // id 2
        EstadoAuto::create(['estado_auto' => 'Mantenimiento']); // id 3
        EstadoAuto::create(['estado_auto' => 'Fuera de servicio']); // id 4

        EstadoAlquiler::create(['estado_alquiler' => 'Pendiente']); // id 1
        EstadoAlquiler::create(['estado_alquiler' => 'Confirmado']); // id 2
        EstadoAlquiler::create(['estado_alquiler' => 'Activo']); // id 3
        EstadoAlquiler::create(['estado_alquiler' => 'Finalizado']); // id 4
        EstadoAlquiler::create(['estado_alquiler' => 'Cancelado']); // id 5
    }

    private function createEstadosYObjetos()
    {
        // Ensure estados exist
        $this->createEstados();
        $disponibleAuto = new DisponibleEstadoAuto();
        $ocupadoAuto = new OcupadoEstadoAuto();
        $mantenimientoAuto = new MantenimientoEstadoAuto();
        return [
            'disponibleAuto' => $disponibleAuto,
            'ocupadoAuto' => $ocupadoAuto,
            'mantenimientoAuto' => $mantenimientoAuto,
        ];
    }

    /** Helper para crear Marca y Modelo. */
    private function setupData()
    {
        $marca  = Marca::create(['nombre_marca' => 'MarcaPrueba']);
        $modelo = Modelo::create([
            'nombre_modelo' => 'ModeloPrueba',
            'id_marca'      => $marca->id_marca,
        ]);
        return [$modelo];
    }

    // ---------------------------------------------------------------------
    // REGISTRO DE AUTOS (copia de los test originales)
    // ---------------------------------------------------------------------
    public function test_registrar_auto_crea_registro_con_estado_correcto()
    {
        $states = $this->createEstadosYObjetos();
        list($modelo) = $this->setupData();

        $auto = Auto::create([
            'precio'        => 150.00,
            'anio'         => 2021,
            'descripcion'   => 'Auto registrado en test',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        $this->assertNotNull($auto->id_auto);
        $this->assertEquals('Disponible', $auto->estadoAuto->estado_auto);
        $this->assertEquals(150.00, $auto->precio);
    }

    public function test_registrar_auto_con_modelo_inexistente_lanza_excepcion()
    {
        $states = $this->createEstadosYObjetos();
        $this->expectException(\Illuminate\Database\QueryException::class);

        $auto = Auto::create([
            'precio'        => 150.00,
            'anio'         => 2021,
            'descripcion'   => 'Auto con modelo invalido',
        ]);
        $auto->setState($states['disponibleAuto']);
    }

    public function test_registrar_auto_con_precio_maximo_es_permitido()
    {
        $states = $this->createEstadosYObjetos();
        list($modelo) = $this->setupData();

        $auto = Auto::create([
            'precio'        => 9999999.99, // límite superior
            'anio'         => 2021,
            'descripcion'   => 'Auto de lujo de exhibición',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        $this->assertNotNull($auto->id_auto);
        $this->assertEquals(9999999.99, $auto->precio);
        $this->assertEquals('Disponible', $auto->estadoAuto->estado_auto);
    }

    // ---------------------------------------------------------------------
    // MODIFICAR AUTO
    // ---------------------------------------------------------------------
    /**
     * Caso positivo: modificar datos de un auto existente.
     */
    public function test_modificar_auto_exitoso()
    {
        $states = $this->createEstadosYObjetos();
        list($modelo) = $this->setupData();

        $auto = Auto::create([
            'precio'        => 150.00,
            'anio'         => 2021,
            'descripcion'   => 'Auto original',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        // Modificar precio y descripción
        $auto->precio      = 200.00;
        $auto->descripcion = 'Auto modificado';
        $auto->save();

        $this->assertEquals(200.00, $auto->fresh()->precio);
        $this->assertEquals('Auto modificado', $auto->fresh()->descripcion);
    }

    /**
     * Caso negativo: intentar modificar un auto que no existe.
     */
    public function test_modificar_auto_inexistente_falla()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        Auto::findOrFail(9999)->update(['precio' => 123.45]);
    }

    /**
     * Caso límite: intentar establecer el precio máximo permitido.
     */
    public function test_modificar_auto_precio_maximo_limite()
    {
        $states = $this->createEstadosYObjetos();
        list($modelo) = $this->setupData();

        $auto = Auto::create([
            'precio'        => 150.00,
            'anio'         => 2021,
            'descripcion'   => 'Auto para límite',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);

        // Precio límite superior definido por la aplicación
        $maxPrice = 9999999.99;
        $auto->precio = $maxPrice;
        $auto->save();

        $this->assertEquals($maxPrice, $auto->fresh()->precio);
    }

    // ---------------------------------------------------------------------
    // ELIMINAR AUTO
    // ---------------------------------------------------------------------
    /**
     * Caso positivo: eliminar un auto que está disponible.
     */
    public function test_eliminar_auto_exitoso()
    {
        $states = $this->createEstadosYObjetos();
        $marca   = Marca::create(['nombre_marca' => 'MarcaNeg']);
        $modelo  = Modelo::create(['nombre_modelo' => 'ModeloNeg', 'id_marca' => $marca->id_marca]);
        $auto = Auto::create([
            'precio'        => 15000,
            'anio'          => 2022,
            'descripcion'   => 'Auto negativo',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['disponibleAuto']);
        $autoId = $auto->id_auto;
        $auto->delete();

        $this->assertDatabaseMissing('autos', ['id_auto' => $autoId]);
    }

    /**
     * Caso negativo: intentar eliminar un auto que no existe.
     */
    public function test_eliminar_auto_inexistente_falla()
    {
        $this->expectException(\Illuminate\Database\Eloquent\ModelNotFoundException::class);
        Auto::findOrFail(9999)->delete();
    }

    /**
     * Caso límite: no se debe eliminar un auto que está alquilado.
     */
    public function test_eliminar_auto_con_estado_alquilado_no_permitido()
    {
        $states = $this->createEstadosYObjetos();

        $marca   = Marca::create(['nombre_marca' => 'MarcaPos']);
        $modelo  = Modelo::create(['nombre_modelo' => 'ModeloPos', 'id_marca' => $marca->id_marca]);
        $auto = Auto::create([
            'precio'        => 20000,
            'anio'          => 2023,
            'descripcion'   => 'Auto positivo',
            'id_modelo'     => $modelo->id_modelo,
        ]);
        $auto->setState($states['ocupadoAuto']);

        $cliente = Cliente::create([
            'nombre' => 'Ana',
            'apellido' => 'Perez',
            'dni' => '87654321',
            'email' => 'ana@example.com',
            'contrasena' => \Illuminate\Support\Facades\Hash::make('password123'),
            'licencia' => 'ABC123456',
        ]);

        $alquiler = Alquiler::create([
            'id_auto'           => $auto->id_auto,
            'id_cliente'       => $cliente->id_cliente,
            'fecha_retiro'     => now(),
            'fecha_devolucion' => now()->addDays(4),
            'hora_retiro'      => '09:00:00',
            'hora_devolucion'  => '18:00:00',
            'precioTotal'       => 600,
            'id_estadoAlquiler'=> 1, // Pendiente
        ]);

        // Habilitar restricciones de clave foránea en SQLite
        \DB::statement('PRAGMA foreign_keys = ON;');

        $this->expectException(\Illuminate\Database\QueryException::class);
        $auto->delete();
    }
}
