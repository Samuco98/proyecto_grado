<x-app-layout>
    <div class="container mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="fw-bold text-primary">🐶 Registro de Mascotas</h3>
            <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalMascota">
                + Registrar Mascota
            </button>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-hover align-middle">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Teléfono</th>
                            <th>Email</th>
                            <th>Mascotas Registradas</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($clientes as $c)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $c->nombre }} {{ $c->apellidos }}</td>
                                <td>{{ $c->telefono }}</td>
                                <td>{{ $c->email }}</td>
                                <td><span class="badge bg-info">{{ $c->mascotas_count }}</span></td>
                                <td>
                                    <a href="{{ route('mascotas.show', $c->id) }}" class="btn btn-sm btn-primary">
                                        Ver Mascotas
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- MODAL REGISTRAR MASCOTA -->
    <div class="modal fade" id="modalMascota" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5>Registrar Nueva Mascota</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formMascota">
                        @csrf
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Cliente</label>
                                <div class="input-group">
                                    <select name="cliente_id" id="cliente_id" class="form-select" required>
                                        <option value="">Seleccione un cliente</option>
                                        @foreach ($clientes as $c)
                                            <option value="{{ $c->id }}">{{ $c->nombre }} {{ $c->apellidos }}</option>
                                        @endforeach
                                    </select>
                                    <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalCliente">
                                        + Añadir Cliente
                                    </button>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Nombre Mascota</label>
                                <input type="text" name="nombre" class="form-control" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Especie</label>
                                <input type="text" name="especie" class="form-control" placeholder="Ej: Perro, Gato" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Raza</label>
                                <input type="text" name="raza" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Sexo</label>
                                <select name="sexo" class="form-select" required>
                                    <option value="">Seleccione</option>
                                    <option value="Macho">Macho</option>
                                    <option value="Hembra">Hembra</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Fecha Nacimiento</label>
                                <input type="date" name="fecha_nacimiento" class="form-control">
                            </div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-dark">💾 Guardar Mascota</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL AÑADIR CLIENTE -->
    <div class="modal fade" id="modalCliente" tabindex="-1">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5>Registrar Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formCliente">
                        @csrf
                        <div class="mb-2"><label>Nombre</label><input type="text" name="nombre" class="form-control" required></div>
                        <div class="mb-2"><label>Apellidos</label><input type="text" name="apellidos" class="form-control" required></div>
                        <div class="mb-2"><label>Teléfono</label><input type="text" name="telefono" class="form-control"></div>
                        <div class="mb-2"><label>Email</label><input type="email" name="email" class="form-control"></div>
                        <div class="text-end mt-3">
                            <button type="submit" class="btn btn-dark">💾 Guardar Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Registrar Mascota
        document.getElementById('formMascota').addEventListener('submit', e => {
            e.preventDefault();
            fetch("{{ route('mascotas.store') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(e.target)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) { alert('✅ Mascota registrada'); location.reload(); }
                else alert('❌ Error: ' + data.message);
            });
        });

        // Registrar Cliente
        document.getElementById('formCliente').addEventListener('submit', e => {
            e.preventDefault();
            fetch("{{ route('clientes.store') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(e.target)
            })
            .then(res => res.json())
            .then(data => {
                if (data.id) {
                    document.getElementById('cliente_id').insertAdjacentHTML('beforeend', `<option value="${data.id}" selected>${data.nombre} ${data.apellidos}</option>`);
                    bootstrap.Modal.getInstance(document.getElementById('modalCliente')).hide();
                } else alert('❌ Error al guardar cliente.');
            });
        });
    });
    </script>
</x-app-layout>
