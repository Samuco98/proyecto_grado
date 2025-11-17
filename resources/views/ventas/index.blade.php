<x-app-layout>
    <div class="container mt-4">
        <h2 class=" mb-4">💰 Ventas Registradas</h2>

        <div class="card shadow-sm">
            <div class="card-body">
            <table class="table table-bordered table-hover align-middle">
                <thead class="table-dark text-center">
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Fecha</th>
                        <th>Total (Bs)</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($ventas as $venta)
                        <tr class="text-center">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $venta->cliente->nombre ?? 'Sin cliente' }}</td>
                            <td>{{ $venta->fecha_venta }}</td>
                            <td>{{ number_format($venta->total, 2) }}</td>
                            <td class="text-center">
                                <a href="{{ route('ventas.show', $venta->id) }}" class="btn btn-sm btn-info">
                                        🔍 Ver Detalle
                                    </a>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted">No hay ventas registradas</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         </div>

        <div class="text-end mt-3">
            <a href="{{ route('ventas.create') }}" class="btn btn-dark">➕ Nueva Venta</a>
        </div>
    </div>
</x-app-layout>
