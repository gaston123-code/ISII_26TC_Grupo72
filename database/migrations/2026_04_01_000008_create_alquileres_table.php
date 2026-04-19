<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla alquileres (reservas)
 * Registra cada alquiler de auto por un cliente.
 * DER: alquileres (id_reserva PK, fecha_retiro, fecha_devolucion,
 *                   hora_retiro, hora_devolucion, precioTotal decimal(10,2),
 *                   id_cliente FK, id_auto FK, id_estadoAlquiler FK)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('alquileres', function (Blueprint $table) {
            $table->id('id_reserva');

            $table->date('fecha_retiro');
            $table->date('fecha_devolucion');
            $table->time('hora_retiro')->nullable();
            $table->time('hora_devolucion')->nullable();

            $table->decimal('precioTotal', 10, 2);

            // Claves foráneas
            $table->unsignedBigInteger('id_cliente');
            $table->unsignedBigInteger('id_auto');
            $table->unsignedBigInteger('id_estadoAlquiler');

            $table->timestamps();

            $table->foreign('id_cliente')
                  ->references('id_cliente')
                  ->on('clientes')
                  ->onDelete('cascade');   // si se elimina el cliente, se eliminan sus alquileres

            $table->foreign('id_auto')
                  ->references('id_auto')
                  ->on('autos')
                  ->onDelete('restrict');  // no se puede eliminar un auto con alquileres activos

            $table->foreign('id_estadoAlquiler')
                  ->references('id_estadoAlquiler')
                  ->on('estado_alquileres')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('alquileres');
    }
};
