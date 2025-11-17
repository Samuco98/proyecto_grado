<x-app-layout>
    <div class="container mt-4">
        <h3 class="mb-4">➕ Nuevo Producto</h3>

        <div class="card p-4 shadow-sm">
            <form id="formProductoPrincipal">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Nombre del Producto</label>
                    <input type="text" name="nombre" class="form-control" placeholder="Ej: Jeringa, Gasas, Alcohol..." required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descripción</label>
                    <textarea name="descripcion" class="form-control" placeholder="Breve descripción del producto" rows="3"></textarea>
                </div>

                <div class="row">
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio de Compra (Bs)</label>
                        <input type="number" step="0.01" name="precio_compra" class="form-control" placeholder="Ej: 25.50" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Precio de Venta (Bs)</label>
                        <input type="number" step="0.01" name="precio" class="form-control" placeholder="Ej: 35.00" required>
                    </div>

                    <div class="col-md-4 mb-3">
                        <label class="form-label">Fecha de Vencimiento</label>
                        <input type="date" name="fecha_vencimiento" class="form-control">
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Proveedor</label>
                        <div class="input-group">
                            <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                                <option value="">Seleccione un proveedor</option>
                                @foreach ($proveedores as $p)
                                    <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                                @endforeach
                            </select>
                            <button type="button" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalProveedor">
                                + Añadir Proveedor
                            </button>
                        </div>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Stock Inicial</label>
                        <input type="number" name="stock" class="form-control" value="0" readonly>
                        <small class="text-muted">El stock inicial se establece en 0 automáticamente</small>
                    </div>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('productos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-dark">Guardar Producto</button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL AÑADIR PROVEEDOR -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-success text-white">
                    <h5 class="modal-title">Añadir Proveedor</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formProveedor">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">NIT</label>
                            <input type="text" name="nit" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Teléfono</label>
                            <input type="text" name="telefono" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Correo Electrónico</label>
                            <input type="email" name="email" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-success w-100">Guardar Proveedor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- SCRIPTS -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Guardar nuevo proveedor desde el modal
            document.getElementById('formProveedor').addEventListener('submit', function(e) {
                e.preventDefault();

                fetch("{{ route('proveedors.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.id) {
                        const select = document.getElementById('proveedor_id');
                        select.insertAdjacentHTML('beforeend', `<option value="${data.id}" selected>${data.nombre}</option>`);
                        select.value = data.id;

                        bootstrap.Modal.getInstance(document.getElementById('modalProveedor')).hide();
                        this.reset();

                        alert('✅ Proveedor añadido correctamente');
                    } else {
                        alert('❌ Error al guardar el proveedor.');
                    }
                })
                .catch(() => alert('❌ Error al conectar con el servidor.'));
            });

            // Guardar producto sin recargar (AJAX)
            document.getElementById('formProductoPrincipal').addEventListener('submit', function(e) {
                e.preventDefault();

                fetch("{{ route('productos.store') }}", {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: new FormData(this)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.id) {
                        alert('✅ Producto guardado correctamente');
                        this.reset();
                        document.getElementById('proveedor_id').selectedIndex = 0;
                    } else {
                        alert('❌ Error al guardar el producto.');
                    }
                })
                .catch(() => alert('❌ Error de conexión con el servidor.'));
            });
        });
    </script>
</x-app-layout>
