<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

/**
 * Modelo: Cliente
 * Guard de autenticación: 'cliente'
 * Los clientes acceden al sistema para reservar autos.
 */
class Cliente extends Authenticatable
{
    use Notifiable;

    protected $table      = 'clientes';
    protected $primaryKey = 'id_cliente';

    // Campo de contraseña personalizado
    protected $authPasswordName = 'contrasena';

    protected $fillable = [
        'nombre',
        'apellido',
        'dni',
        'telefono',
        'direccion',
        'email',
        'contrasena',
        'licencia',
    ];

    protected $hidden = ['contrasena', 'remember_token'];

    protected $casts = ['contrasena' => 'hashed'];

    // Necesario para que Laravel use el campo correcto
    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }

    /** Un cliente tiene muchos alquileres. */
    public function alquileres(): HasMany
    {
        return $this->hasMany(Alquiler::class, 'id_cliente', 'id_cliente');
    }
}
