<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla clientes
 * Clientes (turistas) que alquilan autos.
 * DER: clientes (id_cliente PK, nombre, apellido, dni, telefono,
 *                 direccion, email, licencia, contrasena)
 *
 * Nota: Esta tabla actúa como guard de autenticación para clientes.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id('id_cliente');

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();

            // Credenciales de acceso
            $table->string('email', 255)->unique();
            $table->string('contrasena');   // hash bcrypt
            $table->rememberToken();        // para "recordarme"

            // Datos específicos del conductor
            $table->string('licencia', 50)->unique()->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
