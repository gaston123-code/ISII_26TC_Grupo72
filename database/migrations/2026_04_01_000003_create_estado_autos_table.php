<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla estado_autos
 * Estados posibles de un auto (ej: "Disponible", "Alquilado", "Mantenimiento").
 * DER: estado_autos (id_estadoAuto PK, estado_auto)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('estado_autos', function (Blueprint $table) {
            $table->id('id_estadoAuto');
            $table->string('estado_auto', 50)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('estado_autos');
    }
};
