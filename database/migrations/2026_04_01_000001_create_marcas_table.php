<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla marcas
 * Almacena las marcas de los autos disponibles.
 * DER: marcas (id_marca PK, nombre_marca)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('marcas', function (Blueprint $table) {
            $table->id('id_marca');
            $table->string('nombre_marca', 100)->unique();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marcas');
    }
};
