<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\Producto;
use App\Models\Cliente;
use Illuminate\Support\Facades\DB;

class VentaController extends Controller
{
    /** 📋 Listar ventas */
    public function index()
    {
        $ventas = Venta::with('cliente')->latest()->get();
        return view('ventas.index', compact('ventas'));
    }

    /** 🧾 Formulario para crear una nueva venta */
    public function create()
    {
        $clientes = Cliente::all();
        $productos = Producto::where('stock', '>', 0)->get();
        return view('ventas.create', compact('clientes', 'productos'));
    }

    /** 💾 Guardar venta */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $productos = $request->productos;

            if (is_string($productos)) {
                $productos = json_decode($productos, true);
            }

            if (empty($productos)) {
                throw new \Exception("Debe seleccionar al menos un producto.");
            }

            // 🧮 Verificar existencia y stock
            foreach ($productos as $p) {
                $producto = Producto::find($p['id']);

                if (!$producto) {
                    throw new \Exception("El producto con ID {$p['id']} no existe.");
                }

                if ($producto->stock < $p['cantidad']) {
                    throw new \Exception("Stock insuficiente para '{$producto->nombre}'. Solo hay {$producto->stock} unidades disponibles.");
                }
            }

            // 🧾 Crear la venta (fecha corregida)
            $venta = Venta::create([
                'cliente_id' => $request->cliente_id ?? 1, // Cliente predeterminado si no selecciona
                'fecha_venta' => now(),
                'total' => $request->total,
            ]);

            // 💾 Registrar detalles de venta y actualizar stock
            foreach ($productos as $item) {
                DetalleVenta::create([
                    'venta_id' => $venta->id,
                    'producto_id' => $item['id'],
                    'cantidad' => $item['cantidad'],
                    'precio' => $item['precio'],
                    'subtotal' => $item['subtotal'],
                ]);

                $producto = Producto::find($item['id']);
                $producto->stock -= $item['cantidad'];
                $producto->save();
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => '✅ Venta registrada correctamente.'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => '❌ Error: ' . $e->getMessage(),
            ], 500);
        }
    }

    /** 👁️ Ver detalle de una venta */
    public function show($id)
    {
        $venta = Venta::with(['cliente', 'detalles.producto'])->findOrFail($id);
        return view('ventas.show', compact('venta'));
    }
}
