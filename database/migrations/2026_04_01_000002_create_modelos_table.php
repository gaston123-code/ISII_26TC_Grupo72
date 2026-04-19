<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla modelos
 * Almacena los modelos de autos, asociados a una marca.
 * DER: modelos (id_modelo PK, nombre_modelo, id_marca FK→marcas)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('modelos', function (Blueprint $table) {
            $table->id('id_modelo');
            $table->string('nombre_modelo', 100);
            $table->unsignedBigInteger('id_marca');
            $table->timestamps();

            $table->foreign('id_marca')
                  ->references('id_marca')
                  ->on('marcas')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('modelos');
    }
};
