<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla pagos
 * Registra el pago asociado a una reserva.
 * DER: pagos (id_pago PK, monto decimal(10,2), medio_pago, fecha_pago, id_reserva FK)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->id('id_pago');

            $table->decimal('monto', 10, 2);
            $table->string('medio_pago', 50);   // ej: "Efectivo", "Tarjeta", "Transferencia"
            $table->date('fecha_pago');

            // FK al alquiler que origina el pago
            $table->unsignedBigInteger('id_reserva');

            $table->timestamps();

            $table->foreign('id_reserva')
                  ->references('id_reserva')
                  ->on('alquileres')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pagos');
    }
};
