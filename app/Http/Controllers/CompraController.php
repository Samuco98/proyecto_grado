<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\DetalleCompra;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Support\Facades\DB;

class CompraController extends Controller
{
    /**
     * Mostrar todas las compras registradas.
     */
    public function index()
    {
        // Cargar todas las compras con su proveedor
        $compras = Compra::with('proveedor')->orderBy('id', 'desc')->get();

        return view('compras.index', compact('compras'));
    }

    /**
     * Mostrar formulario para registrar nueva compra.
     */
    public function create()
    {
        // Cargar todos los proveedores y productos
        $proveedores = Proveedor::all();
        $productos = Producto::all();

        return view('compras.create', compact('proveedores', 'productos'));
    }

    /**
     * Guardar la compra desde AJAX.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $productos = $request->productos;

            // Si llega en formato JSON string, decodificar
            if (is_string($productos)) {
                $productos = json_decode($productos, true);
            }

            // Crear la compra
            $compra = Compra::create([
                'proveedor_id' => $request->proveedor_id,
                'fecha_compra' => now(),
                'total' => $request->total,
            ]);

            // Recorrer cada producto comprado
            foreach ($productos as $p) {
                DetalleCompra::create([
                    'compra_id' => $compra->id,
                    'producto_id' => $p['id'],
                    'cantidad' => $p['cantidad'],
                    'precio' => $p['precio'],
                    'subtotal' => $p['subtotal'],
                ]);

                // Actualizar stock y precio de compra
                $producto = Producto::find($p['id']);
                if ($producto) {
                    $producto->stock += $p['cantidad'];
                    $producto->precio_compra = $p['precio'];
                    $producto->save();
                }
            }

            DB::commit();
            return response()->json(['success' => true]);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $th->getMessage()
            ]);
        }
    }

    /**
     * Mostrar detalle completo de una compra específica.
     */
    public function show($id)
    {
        $compra = Compra::with(['proveedor', 'detalles.producto'])->findOrFail($id);

        return view('compras.show', compact('compra'));
    }
}
