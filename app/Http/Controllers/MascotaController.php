<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Mascota;
use Illuminate\Http\Request;

class MascotaController extends Controller
{
    public function index()
    {
        // Traemos todos los clientes con el conteo de mascotas
        $clientes = Cliente::withCount('mascotas')->get();
        return view('mascotas.index', compact('clientes'));
    }

    public function show($id)
    {
        $cliente = Cliente::with(['mascotas.vacunas', 'mascotas.citas'])->findOrFail($id);
        return view('mascotas.show', compact('cliente'));
    }

    public function detalle($id)
    {
        $mascota = Mascota::with(['vacunas', 'citas'])->findOrFail($id);
        return view('mascotas.detalle', compact('mascota'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'nombre' => 'required',
            'especie' => 'required',
        ]);

        $mascota = Mascota::create($request->all());
        return response()->json(['success' => true, 'mascota' => $mascota]);
    }
}
