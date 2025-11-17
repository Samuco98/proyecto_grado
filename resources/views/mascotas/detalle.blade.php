<x-app-layout>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
                <h5>🐾 Detalle de {{ $mascota->nombre }}</h5>
                <button class="btn btn-light" data-bs-toggle="modal" data-bs-target="#modalVacuna">+ Vacuna</button>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <p><b>Especie:</b> {{ $mascota->especie }}</p>
                        <p><b>Raza:</b> {{ $mascota->raza }}</p>
                        <p><b>Sexo:</b> {{ $mascota->sexo }}</p>
                        <p><b>Nacimiento:</b> {{ $mascota->fecha_nacimiento }}</p>
                    </div>
                </div>

                <hr>
                <h5 class="fw-bold">💉 Vacunas Aplicadas</h5>
                <table class="table table-bordered">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Vacuna</th>
                            <th>Fecha</th>
                            <th>Veterinario</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mascota->vacunas as $v)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $v->nombre }}</td>
                                <td>{{ $v->fecha_aplicacion }}</td>
                                <td>{{ $v->veterinario }}</td>
                                <td>{{ $v->observaciones }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="text-center text-muted">Sin vacunas registradas</td></tr>
                        @endforelse
                    </tbody>
                </table>

                <hr>
                <h5 class="fw-bold mt-4">🩺 Citas Médicas</h5>
                <table class="table table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Motivo</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($mascota->citas as $c)
                            <tr>
                                <td>{{ $c->fecha }}</td>
                                <td>{{ $c->hora }}</td>
                                <td>{{ $c->motivo }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning btnEditar" data-id="{{ $c->id }}">✏️</button>
                                    <button class="btn btn-sm btn-danger btnEliminar" data-id="{{ $c->id }}">🗑️</button>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No hay citas registradas</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal Vacuna -->
    <div class="modal fade" id="modalVacuna" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5>Registrar Vacuna</h5>
                    <button class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formVacuna">
                        @csrf
                        <input type="hidden" name="mascota_id" value="{{ $mascota->id }}">
                        <div class="mb-2"><label>Nombre</label><input name="nombre" class="form-control" required></div>
                        <div class="mb-2"><label>Fecha Aplicación</label><input type="date" name="fecha_aplicacion" class="form-control" required></div>
                        <div class="mb-2"><label>Veterinario</label><input name="veterinario" class="form-control"></div>
                        <div class="mb-2"><label>Observaciones</label><textarea name="observaciones" class="form-control"></textarea></div>
                        <button class="btn btn-dark w-100 mt-2">Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    // Agregar vacuna
    document.querySelector('#formVacuna').addEventListener('submit', e => {
        e.preventDefault();
        fetch("{{ route('vacunas.store') }}", {
            method: 'POST',
            headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
            body: new FormData(e.target)
        })
        .then(r => r.json())
        .then(data => {
            if (data.success) { alert('Vacuna guardada'); location.reload(); }
        });
    });

    // Eliminar cita
    document.querySelectorAll('.btnEliminar').forEach(btn => {
        btn.addEventListener('click', e => {
            if (confirm('¿Eliminar cita?')) {
                fetch(`/citas/${btn.dataset.id}`, {
                    method: 'DELETE',
                    headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'}
                }).then(() => location.reload());
            }
        });
    });
    </script>
</x-app-layout>
