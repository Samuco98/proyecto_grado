<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mascota extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'nombre',
        'especie',
        'raza',
        'sexo',
        'fecha_nacimiento',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }

    public function vacunas()
    {
        return $this->hasMany(Vacuna::class);
    }

    public function citas()
    {
        return $this->hasMany(Cita::class);
    }
}
