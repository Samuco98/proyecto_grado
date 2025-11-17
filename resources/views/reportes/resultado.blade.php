<x-app-layout>
    <div class="container mt-4">
        <h2 class="fw-bold text-center">{{ $titulo }}</h2>

        <div class="card mt-4 p-4 shadow-sm">
            <h5 class="fw-bold">📅 Período: {{ request('desde') ?? '—' }} - {{ request('hasta') ?? '—' }}</h5>
            <h5 class="fw-bold text-success">💰 Total: Bs {{ number_format($total, 2) }}</h5>

            @if($tipo === 'ventas')
                <h6 class="text-primary mt-3">
                    🏆 Producto más vendido: 
                    {{ $masVendido?->producto?->nombre ?? 'N/A' }} 
                    ({{ $masVendido?->total_vendidos ?? 0 }} unidades)
                </h6>
            @else
                <h6 class="text-primary mt-3">
                    📦 Producto más comprado: 
                    {{ $masComprado?->producto?->nombre ?? 'N/A' }} 
                    ({{ $masComprado?->total_comprados ?? 0 }} unidades)
                </h6>
            @endif
        </div>

        <div class="card p-4 mt-4 shadow-sm">
            <table class="table table-bordered table-striped align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        @if($tipo === 'ventas')
                            <th>Cliente</th>
                            <th>Fecha Venta</th>
                        @else
                            <th>Proveedor</th>
                            <th>Fecha Compra</th>
                        @endif
                        <th>Total (Bs)</th>
                        <th>Detalle</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data as $i => $item)
                        <tr>
                            <td>{{ $i + 1 }}</td>
                            <td>{{ $tipo === 'ventas' ? $item->cliente->nombre : $item->proveedor->nombre }}</td>
                            <td>{{ $tipo === 'ventas' ? $item->fecha_venta : $item->fecha_compra }}</td>
                            <td>{{ number_format($item->total, 2) }}</td>
                            <td>
                                <ul>
                                    @foreach($item->detalles as $d)
                                        <li>{{ $d->producto->nombre }} — {{ $d->cantidad }} u. (Bs {{ $d->subtotal }})</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
