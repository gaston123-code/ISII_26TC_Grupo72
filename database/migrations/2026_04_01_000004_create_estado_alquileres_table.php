<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla estado_alquileres
 * Estados posibles de un alquiler (ej: "Pendiente", "Activo", "Finalizado", "Cancelado").
 * DER: estado_alquileres (id_estadoAlquiler PK, estado_alquiler)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_alquileres', function (Blueprint $table) {
            $table->id('id_estadoAlquiler');
            $table->string('estado_alquiler', 50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_alquileres');
    }
};
