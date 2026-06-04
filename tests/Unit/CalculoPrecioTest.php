<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Alquiler;
use App\Models\Auto;
use Carbon\Carbon;

class CalculoPrecioTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_calcular_precio_correcto()
    {
        $precioDiario = 100;
        $fechaRetiro = Carbon::parse('2024-01-01');
        $fechaDevolucion = Carbon::parse('2024-01-05'); // 4 days
        $expected = 400.00;
        $this->assertEquals($expected, Alquiler::calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion));
    }

    /** @test */
    public function test_calcular_precio_devolucion_anterior_a_retiro_lanza_excepcion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $precioDiario = 100;
        $fechaRetiro = Carbon::parse('2024-01-05');
        $fechaDevolucion = Carbon::parse('2024-01-01');
        Alquiler::calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion);
    }

    /** @test */
    public function test_calcular_precio_limite_mismo_dia()
    {
        $precioDiario = 150;
        $fechaRetiro = Carbon::parse('2024-02-10');
        $fechaDevolucion = Carbon::parse('2024-02-10'); // same day => 1 day
        $expected = 150.00;
        $this->assertEquals($expected, Alquiler::calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion));
    }

    /** @test */
    public function test_calcular_precio_limite_maximo_30_dias()
    {
        $precioDiario = 50;
        $fechaRetiro = Carbon::parse('2024-03-01');
        $fechaDevolucion = Carbon::parse('2024-03-31'); // 30 days
        $expected = 1500.00;
        $this->assertEquals($expected, Alquiler::calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion));
    }

    /** @test */
    public function test_calcular_precio_supera_limite_30_dias_lanza_excepcion()
    {
        $this->expectException(\InvalidArgumentException::class);
        $precioDiario = 60;
        $fechaRetiro = Carbon::parse('2024-04-01');
        $fechaDevolucion = Carbon::parse('2024-05-02'); // 31 days
        Alquiler::calcularPrecioTotal($precioDiario, $fechaRetiro, $fechaDevolucion);
    }
}
