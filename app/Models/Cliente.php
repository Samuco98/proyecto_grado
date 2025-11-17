<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'apellidos',
        'ci',
        'nit',
        'direccion',
        'telefono',
        'email',
    ];

    //  Relación con mascotas// app/Models/Cliente.php
public function mascotas()
{
    return $this->hasMany(Mascota::class);
}

}
