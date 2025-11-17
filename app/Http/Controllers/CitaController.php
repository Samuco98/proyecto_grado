<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cita;
use App\Models\Mascota;
use App\Models\Cliente;
use Illuminate\Support\Facades\Validator;

class CitaController extends Controller
{
    // Mostrar vista principal con calendario y selects
    public function index()
    {
        // Cargar clientes (para poder elegir y cargar mascotas por cliente)
        $clientes = Cliente::select('id','nombre','apellidos')->get();

        // Cargar citas para calendario (se consumen por listar() también)
        // también pasamos mascotas vacías (se llenan por AJAX cuando el usuario elige cliente)
        return view('citas.index', compact('clientes'));
    }

    // Para FullCalendar -> devuelve JSON con eventos
    public function listar()
    {
        $citas = Cita::with('mascota.cliente')->get();

        // Formatear como eventos FullCalendar
        $events = $citas->map(function ($c) {
            return [
                'id' => $c->id,
                'title' => ($c->mascota ? $c->mascota->nombre : 'Cita') . ' - ' . ($c->mascota && $c->mascota->cliente ? $c->mascota->cliente->nombre : ''),
                'start' => $c->fecha . 'T' . $c->hora,
                'allDay' => false,
            ];
        });

        return response()->json($events);
    }

    // Crear cita (AJAX)
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'motivo'     => 'required|string|max:1000',
            'fecha'      => 'required|date',
            'hora'       => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Opcional: comprobar que la mascota pertenece al cliente
        $mascota = Mascota::find($request->mascota_id);
        if ($mascota->cliente_id != $request->cliente_id) {
            return response()->json(['success' => false, 'message' => 'La mascota seleccionada no pertenece al cliente.'], 422);
        }

        $cita = Cita::create([
            'cliente_id' => $request->cliente_id,
            'mascota_id' => $request->mascota_id,
            'motivo'     => $request->motivo,
            'fecha'      => $request->fecha,
            'hora'       => $request->hora,
        ]);

        return response()->json(['success' => true, 'cita' => $cita]);
    }

    // Mostrar detalles de una cita (JSON) -> para abrir modal
    public function show($id)
    {
        $cita = Cita::with('mascota.cliente')->findOrFail($id);

        return response()->json([
            'id' => $cita->id,
            'cliente_id' => $cita->cliente_id,
            'mascota_id' => $cita->mascota_id,
            'motivo' => $cita->motivo,
            'fecha' => $cita->fecha,
            'hora' => $cita->hora,
            'mascota' => $cita->mascota ? $cita->mascota->nombre : null,
            'cliente' => $cita->mascota && $cita->mascota->cliente ? $cita->mascota->cliente->nombre : null,
        ]);
    }

    // Actualizar cita (AJAX)
    public function update(Request $request, $id)
    {
        $cita = Cita::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'cliente_id' => 'required|exists:clientes,id',
            'mascota_id' => 'required|exists:mascotas,id',
            'motivo'     => 'required|string|max:1000',
            'fecha'      => 'required|date',
            'hora'       => 'required|date_format:H:i',
        ]);

        if ($validator->fails()) {
            return response()->json(['success' => false, 'errors' => $validator->errors()], 422);
        }

        // Verificar pertenencia mascota-cliente
        $mascota = Mascota::find($request->mascota_id);
        if ($mascota->cliente_id != $request->cliente_id) {
            return response()->json(['success' => false, 'message' => 'La mascota seleccionada no pertenece al cliente.'], 422);
        }

        $cita->update([
            'cliente_id' => $request->cliente_id,
            'mascota_id' => $request->mascota_id,
            'motivo' => $request->motivo,
            'fecha' => $request->fecha,
            'hora' => $request->hora,
        ]);

        return response()->json(['success' => true, 'cita' => $cita]);
    }

    // Eliminar cita (AJAX)
    public function destroy($id)
    {
        $cita = Cita::findOrFail($id);
        $cita->delete();

        return response()->json(['success' => true]);
    }
}
