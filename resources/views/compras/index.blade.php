<x-app-layout>
    <div class="container mt-4">
        <h3 class="mb-4">📦 Compras Registradas</h3>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr class="text-center">
                            <th>#</th>
                            <th>Fecha</th>
                            <th>Total (Bs)</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($compras as $compra)
                            <tr class="text-center">
                                <td>{{ $compra->id }}</td>
                                
                                <td>{{ \Carbon\Carbon::parse($compra->fecha_compra)->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format($compra->total, 2) }}</td>
                                <td>
                                    <a href="{{ route('compras.show', $compra->id) }}" class="btn btn-sm btn-info">
                                        🔍 Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center text-muted">No hay compras registradas.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="text-end mt-3">
            <a href="{{ route('compras.create') }}" class="btn btn-dark">➕ Nueva Compra</a>
        </div>
    </div>
</x-app-layout>
