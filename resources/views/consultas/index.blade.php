<x-app-layout>
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
                <h3 class="fw-bold text-dark"> Consultas Veterinarias</h3>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalConsulta">
                + Nueva Consulta
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">

                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Mascota</th>
                            <th>Motivo</th>
                            <th>Fecha</th>
                            <th>Total (Bs)</th>
                            <th>Acción</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($consultas as $consulta)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $consulta->cliente->nombre }} {{ $consulta->cliente->apellidos }}</td>
                                <td>{{ $consulta->mascota->nombre }}</td>
                                <td>{{ Str::limit($consulta->motivo, 20) }}</td>
                                <td>{{ $consulta->fecha_consulta }}</td>
                                <td>
                                    <span class="badge bg-success">
                                        {{ number_format($consulta->total, 2) }} Bs
                                    </span>
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('consultas.show', $consulta->id) }}" class="btn btn-sm btn-dark">
                                        Ver Detalle
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>
        </div>

    </div>

   @include('consultas.modals.create-consulta', [
    'clientes' => $clientes,
    'mascotas' => $mascotas,
    'productos' => $productos
])


</x-app-layout>
