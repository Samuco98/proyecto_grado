<x-app-layout>
<div class="container mt-4">

    <h3 class="fw-bold text-primary mb-4">Detalle de Consulta</h3>

    <div class="card shadow-sm mx-auto" style="max-width: 900px;">
        <div class="card-body">

            <div class="row mb-4">

                {{-- COLUMNA IZQUIERDA --}}
                <div class="col-md-6">
                    <p><strong>Cliente:</strong> {{ $consulta->cliente->nombre }} {{ $consulta->cliente->apellidos }}</p>
                    <p><strong>Mascota:</strong> {{ $consulta->mascota->nombre }}</p>
                    <p><strong>Fecha:</strong> {{ $consulta->fecha_consulta }}</p>
                </div>

                {{-- COLUMNA DERECHA --}}
                <div class="col-md-6">
                    <p><strong>Motivo:</strong> {{ $consulta->motivo }}</p>
                    <p><strong>Diagnóstico:</strong> {{ $consulta->diagnostico }}</p>
                    <p><strong>Tratamiento:</strong> {{ $consulta->tratamiento }}</p>
                </div>

            </div>

            <hr>

            <h5 class="fw-bold mb-3">Medicamentos Usados</h5>

            <table class="table table-hover">
                <thead class="table-dark">
                    <tr>
                        <th>Producto</th>
                        <th>Cant.</th>
                        <th>Precio</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($consulta->detalles as $d)
                    <tr>
                        <td>{{ $d->producto->nombre }}</td>
                        <td>{{ $d->cantidad }}</td>
                        <td>{{ number_format($d->precio,2) }} Bs</td>
                        <td>{{ number_format($d->subtotal,2) }} Bs</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <h4 class="mt-3">
                <strong>Total: </strong>
                <span class="text-success">{{ number_format($consulta->total,2) }} Bs</span>
            </h4>

            <a href="{{ route('consultas.index') }}" class="btn btn-secondary mt-4">Volver</a>

        </div>
    </div>

</div>
</x-app-layout>
