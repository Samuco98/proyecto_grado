<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Lista de Productos</h3>
          
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Fecha Vencimiento</th>
                            <th>Proveedor</th>
                            <th>Descripción</th>
                            <th>Precio Venta</th>
                            <th>Precio Compra</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($productos as $producto)
                            <tr>
                                <td>{{ $producto->id }}</td>
                                <td>{{ $producto->nombre }}</td>
                                <td>{{ $producto->stock }}</td>
                                <td>
                                    {{ $producto->fecha_vencimiento ? \Carbon\Carbon::parse($producto->fecha_vencimiento)->format('d/m/Y') : '—' }}
                                </td>
                                <td>{{ $producto->proveedor->nombre ?? 'Sin proveedor' }}</td>
                                <td>{{ $producto->descripcion ?? '-' }}</td>
                                <td>{{ number_format($producto->precio, 2) }} Bs</td>
                                <td>{{ number_format($producto->precio_compra, 2) }} Bs</td>
                                <td>
                                    <a href="{{ route('productos.edit', $producto->id) }}" class="btn btn-warning btn-sm">✏️</a>
                                    <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este producto?')">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">
                                    No hay productos registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="text-end mt-3">
         <a href="{{ route('productos.create') }}" class="btn btn-dark">+ Nuevo Producto</a>
        </div>
    </div>
</x-app-layout>
