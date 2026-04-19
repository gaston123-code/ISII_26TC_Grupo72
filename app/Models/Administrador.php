<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo: Administrador
 * Guard de autenticación: 'admin'
 * Gestiona la flota, reservas y usuarios del sistema.
 */
class Administrador extends Authenticatable
{
    use Notifiable;

    protected $table      = 'administradores';
    protected $primaryKey = 'id_administrador';

    protected $authPasswordName = 'contrasena';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'direccion',
        'email',
        'contrasena',
    ];

    protected $hidden = ['contrasena', 'remember_token'];

    protected $casts = ['contrasena' => 'hashed'];

    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }
}
