<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Migración: Tabla administradores
 * Personal interno que gestiona la flota y las reservas.
 * DER: administradores (id_administrador PK, nombre, apellido, dni,
 *                        telefono, direccion, email, contrasena)
 *
 * Nota: Guard separado del de clientes para diferenciar roles.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id('id_administrador');

            $table->string('nombre', 100);
            $table->string('apellido', 100);
            $table->string('dni', 20)->unique();
            $table->string('telefono', 20)->nullable();
            $table->string('direccion', 255)->nullable();

            // Credenciales
            $table->string('email', 255)->unique();
            $table->string('contrasena');
            $table->rememberToken();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
