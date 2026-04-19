<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla autos
 * Vehículos disponibles para alquiler.
 * DER: autos (id_auto PK, precio decimal(10,2), anio, imagen varchar(255),
 *              descripcion varchar(255), id_modelo FK, id_estadoAuto FK)
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('autos', function (Blueprint $table) {
            $table->id('id_auto');

            $table->decimal('precio', 10, 2)->unsigned();   // precio por día
            $table->year('anio');
            $table->string('imagen', 255)->nullable();      // path relativo en storage/
            $table->string('descripcion', 255)->nullable();

            // Claves foráneas
            $table->unsignedBigInteger('id_modelo');
            $table->unsignedBigInteger('id_estadoAuto');

            $table->timestamps();

            $table->foreign('id_modelo')
                  ->references('id_modelo')
                  ->on('modelos')
                  ->onDelete('restrict');

            $table->foreign('id_estadoAuto')
                  ->references('id_estadoAuto')
                  ->on('estado_autos')
                  ->onDelete('restrict');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('autos');
    }
};
