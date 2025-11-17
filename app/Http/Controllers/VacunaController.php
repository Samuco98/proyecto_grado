<?php

namespace App\Http\Controllers;

use App\Models\Vacuna;
use Illuminate\Http\Request;

class VacunaController extends Controller
{
    public function store(Request $request)
    {
        try {
            Vacuna::create([
                'mascota_id' => $request->mascota_id,
                'nombre' => $request->nombre,
                'fecha_aplicacion' => $request->fecha_aplicacion,
                'veterinario' => $request->veterinario,
                'observaciones' => $request->observaciones,
            ]);

            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            return response()->json(['success' => false, 'message' => $th->getMessage()]);
        }
    }
}
