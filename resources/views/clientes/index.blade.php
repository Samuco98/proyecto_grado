<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-dark">Lista de Clientes</h3>
           
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                {{-- Mensaje de éxito --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Tabla de clientes --}}
                <table class="table table-bordered table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Apellidos</th>
                            <th>C.I.</th>
                            <th>NIT</th>
                            <th>Dirección</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-center">
                        @forelse ($clientes as $cliente)
                            <tr>
                                <td>{{ $cliente->id }}</td>
                                <td>{{ $cliente->nombre }}</td>
                                <td>{{ $cliente->apellidos }}</td>
                                <td>{{ $cliente->ci ?? '-' }}</td>
                                <td>{{ $cliente->nit ?? '-' }}</td>
                                <td>{{ $cliente->direccion ?? '-' }}</td>
                                <td>{{ $cliente->telefono ?? '-' }}</td>
                                <td>{{ $cliente->email ?? '-' }}</td>
                                <td>
                                    <a href="{{ route('clientes.edit', $cliente->id) }}" class="btn btn-warning btn-sm">✏️</a>
                                    <form action="{{ route('clientes.destroy', $cliente->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('¿Seguro que deseas eliminar este cliente?')">
                                            🗑️
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="9" class="text-center text-muted py-3">
                                    No hay clientes registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div> 
        <div class="text-end mt-3">
        <a href="{{ route('clientes.create') }}" class="btn btn-dark">+ Nuevo Cliente</a>
        </div>
    </div>
</x-app-layout>
