<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultaDetalle extends Model
{
    protected $fillable = [
        'consulta_id',
        'producto_id',
        'cantidad',
        'precio',
        'subtotal'
    ];

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }

    public function producto()
    {
        return $this->belongsTo(Producto::class);
    }
}
