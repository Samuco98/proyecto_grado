<div class="card p-3 mt-3">
    <h4>🧾 Reporte de Compras</h4>
    <p><strong>Total invertido:</strong> Bs {{ number_format($total, 2) }}</p>

    <table class="table table-striped mt-3">
        <thead>
            <tr>
                <th>Proveedor</th>
                <th>Fecha</th>
                <th>Total (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registros as $c)
                <tr>
                    <td>{{ $c->proveedor->nombre }}</td>
                    <td>{{ $c->fecha_compra }}</td>
                    <td>{{ $c->total }}</td>
                </tr>
            @empty
                <tr><td colspan="3" class="text-center">No hay compras registradas</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
