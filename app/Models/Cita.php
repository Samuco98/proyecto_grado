<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    protected $fillable = ['cliente_id','mascota_id','motivo','fecha','hora'];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function cliente()
    {
        return $this->belongsTo(Cliente::class);
    }
}
