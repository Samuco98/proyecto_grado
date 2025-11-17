<x-app-layout>
    <div class="container mt-4">
        <!-- Encabezado -->
        <div class="card shadow-sm border-0">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5 class="mb-0">📋 Detalle de la Compra #{{ $compra->id }}</h5>
                <a href="{{ route('compras.index') }}" class="btn btn-light btn-sm text-primary fw-bold">
                    ⬅ Volver a Compras
                </a>
            </div>

            <div class="card-body">
                <!-- Información general -->
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p class="mb-1">
                            <strong>
                                🧾 Proveedor:
                            </strong>
                             {{ $compra->proveedor->nombre ?? 'No especificado' }}
                        </p>
                        <p class="mb-1"><strong>📞 Teléfono:</strong> {{ $compra->proveedor->telefono ?? '—' }}</p>
                        <p class="mb-1"><strong>🏙️ Ciudad:</strong> {{ $compra->proveedor->ciudad ?? '—' }}</p>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <p class="mb-1"><strong>📅 Fecha de Compra:</strong> 
                            {{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y H:i') }}
                        </p>
                        <p class="mb-1"><strong>💰 Total:</strong> 
                            <span class="text-success fw-bold">{{ number_format($compra->total, 2) }} Bs</span>
                        </p>
                    </div>
                </div>

                <hr>

                <!-- Tabla de productos -->
                <h6 class="fw-bold mb-3">🧺 Productos Comprados:</h6>
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
                        @foreach ($compra->detalles as $index => $detalle)
                            <tr class="text-center">
                                <td>{{ $index + 1 }}</td>
                                <td >{{ $detalle->producto->nombre ?? '—' }}</td>
                                <td class="text-center">{{ $detalle->cantidad }}</td>
                                <td class="text-center">{{ number_format($detalle->precio, 2) }}</td>
                                <td class="text-center">{{ number_format($detalle->subtotal, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr class="fw-bold text-center ">
                            <td colspan="4" class="text-end">TOTAL</td>
                            <td>{{ number_format($compra->total, 2) }} Bs</td>
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
    </div>
</x-app-layout>
