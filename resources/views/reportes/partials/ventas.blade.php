<div class="card p-3 mt-3">
    <h4>📦 Reporte de Ventas</h4>
    <p><strong>Total generado:</strong> Bs {{ number_format($total, 2) }}</p>

    @if($productoMasVendido)
        <p><strong>Producto más vendido:</strong> {{ $productoMasVendido->nombre }} ({{ $productoMasVendido->total_vendidos }} unidades)</p>
    @endif

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Cliente</th>
                <th>Fecha</th>
                <th>Total (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registros as $v)
                <tr>
                    <td>{{ $v->cliente->nombre }}</td>
                    <td>{{ $v->fecha_venta }}</td>
                    <td>{{ $v->total }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No hay ventas registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
