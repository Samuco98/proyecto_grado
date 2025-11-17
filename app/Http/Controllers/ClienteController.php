<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    // 📋 Listar clientes
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    // 📝 Mostrar formulario para crear
    public function create()
    {
        return view('clientes.create');
    }

    // 💾 Guardar nuevo cliente (compatible con AJAX y normal)
    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'ci'        => 'nullable|string|max:30',
            'nit'       => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:200',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'ciudad'    => 'nullable|string|max:100',
        ]);

        $cliente = Cliente::create($data);

        // 🔄 Si la petición viene de AJAX (modal), devolvemos JSON
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json($cliente);
        }

        // 🚀 Si viene desde un formulario normal (navegador)
        return redirect()->route('clientes.index')->with('success', 'Cliente creado.');
    }

    // ✏️ Mostrar formulario de edición
    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    // 🔧 Actualizar cliente
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'nombre'    => 'required|string|max:100',
            'apellidos' => 'nullable|string|max:100',
            'ci'        => 'nullable|string|max:30',
            'nit'       => 'nullable|string|max:30',
            'direccion' => 'nullable|string|max:200',
            'telefono'  => 'nullable|string|max:20',
            'email'     => 'nullable|email|max:100',
            'ciudad'    => 'nullable|string|max:100',
        ]);

        $cliente = Cliente::findOrFail($id);
        $cliente->update($data);

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado.');
    }

    // 🗑️ Eliminar cliente
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', '🗑️ Cliente eliminado correctamente.');
    }
}
