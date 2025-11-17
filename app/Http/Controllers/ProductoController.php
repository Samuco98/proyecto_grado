<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /** 🧾 Mostrar listado de productos */
    public function index()
    {
        $productos = Producto::with('proveedor')->get();
        return view('productos.index', compact('productos'));
    }

    /** ➕ Mostrar formulario de creación */
    public function create()
    {
        $proveedores = Proveedor::all();
        return view('productos.create', compact('proveedores'));
    }

    /** 💾 Guardar un nuevo producto (desde formulario o AJAX de compras) */
    public function store(Request $request)
    {
        try {
            $data = $request->validate([
                'nombre' => 'required|string|max:255',
                'descripcion' => 'nullable|string|max:500',
                'precio_compra' => 'required|numeric|min:0',
                'precio' => 'required|numeric|min:0',
                'fecha_vencimiento' => 'nullable|date',
                'proveedor_id' => 'nullable|exists:proveedors,id',
                'stock' => 'nullable|integer|min:0',
            ]);

            // Si no se define stock, será 0
            $data['stock'] = $data['stock'] ?? 0;

            $producto = Producto::create($data);

            // Si la petición viene desde AJAX (por ejemplo, módulo compras)
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'id' => $producto->id,
                    'nombre' => $producto->nombre,
                    'proveedor_id' => $producto->proveedor_id,
                    'message' => '✅ Producto registrado correctamente.',
                ]);
            }

            // Si viene desde formulario normal
            return redirect()->route('productos.index')->with('success', '✅ Producto registrado correctamente.');

        } catch (\Throwable $th) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al guardar producto: ' . $th->getMessage(),
                ], 500);
            }

            return back()->with('error', '❌ Error al guardar producto: ' . $th->getMessage());
        }
    }

    /** ✏️ Editar producto */
    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        $proveedores = Proveedor::all();
        return view('productos.edit', compact('producto', 'proveedores'));
    }

    /** 🔄 Actualizar producto */
    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);

        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string|max:500',
            'precio' => 'required|numeric|min:0',
            'precio_compra' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'proveedor_id' => 'nullable|exists:proveedors,id',
            'fecha_vencimiento' => 'nullable|date',
        ]);

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('success', '✅ Producto actualizado correctamente.');
    }

    /** 🗑️ Eliminar producto */
    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', '✅ Producto eliminado correctamente.');
    }
}
