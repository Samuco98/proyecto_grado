<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Compra;
use App\Models\Venta;
use App\Models\DetalleVenta;
use App\Models\DetalleCompra;
use App\Models\Producto;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index()
    {
        return view('reportes.index');
    }

    public function generar(Request $request)
    {
        $request->validate([
            'tipo' => 'required|in:ventas,compras',
            'desde' => 'nullable|date',
            'hasta' => 'nullable|date',
        ]);

        $desde = $request->desde ?? '2000-01-01';
        $hasta = $request->hasta ?? now();

        if ($request->tipo === 'ventas') {
            $data = Venta::with(['cliente', 'detalles.producto'])
                ->whereBetween('fecha_venta', [$desde, $hasta])
                ->orderByDesc('fecha_venta')
                ->get();

            $total = $data->sum('total');
            $masVendido = DetalleVenta::select('producto_id', DB::raw('SUM(cantidad) as total_vendidos'))
                ->groupBy('producto_id')
                ->orderByDesc('total_vendidos')
                ->with('producto')
                ->first();

            return view('reportes.resultado', [
                'titulo' => 'Reporte de Ventas',
                'tipo' => 'ventas',
                'data' => $data,
                'total' => $total,
                'masVendido' => $masVendido
            ]);
        }

        if ($request->tipo === 'compras') {
            $data = Compra::with(['proveedor', 'detalles.producto'])
                ->whereBetween('fecha_compra', [$desde, $hasta])
                ->orderByDesc('fecha_compra')
                ->get();

            $total = $data->sum('total');
            $masComprado = DetalleCompra::select('producto_id', DB::raw('SUM(cantidad) as total_comprados'))
                ->groupBy('producto_id')
                ->orderByDesc('total_comprados')
                ->with('producto')
                ->first();

            return view('reportes.resultado', [
                'titulo' => 'Reporte de Compras',
                'tipo' => 'compras',
                'data' => $data,
                'total' => $total,
                'masComprado' => $masComprado
            ]);
        }
    }
}
