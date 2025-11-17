<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProveedorController extends Controller
{
    public function index()
    {
        $proveedores = Proveedor::all();
        return view('proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        return view('proveedores.create');
    }

    public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'nit' => 'nullable|string|max:255',
        'direccion' => 'nullable|string|max:255',
        'ciudad' => 'nullable|string|max:255',
        'telefono' => 'nullable|string|max:50',
        'email' => 'nullable|email|max:255',
        'contacto' => 'nullable|string|max:255',
    ]);

    Proveedor::create($request->all());

    return redirect()->route('proveedors.index')
        ->with('success', '✅ Proveedor guardado correctamente.');
}


    public function edit(Proveedor $proveedor)
    {
        return view('proveedores.edit', compact('proveedor'));
    }

    public function update(Request $request, Proveedor $proveedor)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'nit' => 'nullable|string|max:20',
            'direccion' => 'nullable|string|max:150',
            'ciudad' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:100',
            'contacto' => 'nullable|string|max:100',
        ]);

        $proveedor->update($request->all());

        return redirect()->route('proveedors.index')
                         ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy(Proveedor $proveedor)
    {
        $proveedor->delete();
        return redirect()->route('proveedors.index')
                         ->with('success', 'Proveedor eliminado correctamente.');
    }public function showJson($id)
{
    $proveedor = \App\Models\Proveedor::find($id);

    if (!$proveedor) {
        return response()->json(['error' => 'Proveedor no encontrado'], 404);
    }

    return response()->json($proveedor);
}

}
