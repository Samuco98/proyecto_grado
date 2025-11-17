<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Conversión automática de tipos.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Verifica si el usuario tiene un rol específico.
     * Ejemplo: $user->hasRole('admin')
     */
    public function hasRole($role)
    {
        return $this->rol === $role;
    }

    /**
     * Relación opcional si deseas vincular ventas o citas.
     */
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
