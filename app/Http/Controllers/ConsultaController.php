<?php

namespace App\Http\Controllers;

use App\Models\Consulta;
use App\Models\ConsultaDetalle;
use App\Models\Cliente;
use App\Models\Mascota;
use App\Models\Producto;
use App\Models\Venta;
use App\Models\DetalleVenta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ConsultaController extends Controller
{
    public function index()
    {
        $consultas = Consulta::with('cliente','mascota')->get();
        $clientes  = Cliente::all();
        $mascotas  = Mascota::with('cliente')->get();
        $productos = Producto::all();

        return view('consultas.index', compact('consultas','clientes','mascotas','productos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required',
            'mascota_id' => 'required',
            'motivo'     => 'required',
        ]);

        // Crear consulta
        $consulta = Consulta::create([
            'cliente_id'  => $request->cliente_id,
            'mascota_id'  => $request->mascota_id,
            'user_id'     => Auth::id(),
            'motivo'      => $request->motivo,
            'diagnostico' => $request->diagnostico,
            'tratamiento' => $request->tratamiento,
            'total'       => 0,
        ]);

        // TOTAL enviado desde el modal
        $totalConsulta = $request->total;

        // Registrar detalles (ya sin tocar inventario)
        if ($request->productos) {
            foreach ($request->productos as $index => $producto_id) {

                if (!$producto_id) continue;

                $cantidad = $request->cantidades[$index];
                $precio = $request->precios[$index];
                $subtotal = $precio * $cantidad;

                ConsultaDetalle::create([
                    'consulta_id' => $consulta->id,
                    'producto_id' => $producto_id,
                    'cantidad'    => $cantidad,
                    'precio'      => $precio,
                    'subtotal'    => $subtotal
                ]);
            }
        }

        // Actualizar total final
        $consulta->total = $totalConsulta;
        $consulta->save();

        // Crear venta automática si hay total
        if ($totalConsulta > 0) 
        {
            $venta = Venta::create([
                'cliente_id'  => $consulta->cliente_id,
                'user_id'     => Auth::id(),
                'fecha_venta' => now(),
                'total'       => $totalConsulta
            ]);

            foreach ($consulta->detalles as $det) {
                DetalleVenta::create([
                    'venta_id'       => $venta->id,
                    'producto_id'    => $det->producto_id,
                    'cantidad'       => $det->cantidad,
                    'precio_unitario'=> $det->precio,
                    'subtotal'       => $det->subtotal
                ]);
            }
        }

        return response()->json(['success' => true]);
    }

    public function show($id)
    {
        $consulta = Consulta::with('detalles.producto', 'cliente', 'mascota')->findOrFail($id);
        return view('consultas.show', compact('consulta'));
    }
}
