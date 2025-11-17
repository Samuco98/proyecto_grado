<x-app-layout>
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Detalle de la Venta #{{ $venta->id }}</h5>
                <a href="{{ route('ventas.index') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    ⬅ Volver a Ventas
                </a>
            </div>

        <div class="card shadow-sm p-4">
            <p class="mb-1">
                <strong>
                    Cliente:
                </strong> 
                {{ $venta->cliente->nombre ?? 'Sin cliente' }}
           </p>
             <p class="mb-1">
                <strong>📅Fecha:</strong> {{ $venta->fecha_venta }}
            </p>
             <p class="mb-1">
                <strong>💰Total:</strong> Bs {{ number_format($venta->total, 2) }}
            </p>
            <hr>
            <h6 class="fw-bold mb-3">🧺 Productos Vendidos:</h6>
            <table class="table table-bordered mt-2">
                <thead class="table-dark text-center">
                    <tr class="text-center">
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Precio (Bs)</th>
                        <th>Subtotal (Bs)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($venta->detalles as $index => $detalle)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                            <td>{{ $detalle->producto->nombre }}</td>
                            <td class="text-center">{{ $detalle->cantidad }}</td>
                            <td class="text-center">{{ number_format($detalle->precio, 2) }}</td>
                            <td class="text-center">{{ number_format($detalle->subtotal, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                        <tr class="fw-bold text-center ">
                            <td colspan="4" class="text-end">TOTAL</td>
                            <td>{{ number_format($venta->total, 2) }} Bs</td>
                        </tr>
                    </tfoot>
            </table>

            <!-- Botones -->
                <div class="text-end mt-3">
                    <a href="{{ route('compras.index') }}" class="btn btn-secondary">
                        ⬅ Volver
                    </a>
                    <button class="btn btn-outline-primary" onclick="window.print()">
                        🖨️ Imprimir
                    </button>
                </div>
        </div>
    </div>
</x-app-layout>
