<x-app-layout>
    <div class="container mt-4">
        <h3 class="text-center fw-bold mb-4">🛒 Registrar Nueva Compra</h3>

        <div class="card shadow-sm p-4">
            <form id="formCompra">
                @csrf

                <!-- PROVEEDOR -->
                <div class="mb-4">
                    <label for="proveedor_id" class="form-label fw-semibold">Proveedor</label>
                    <div class="input-group">
                        <select name="proveedor_id" id="proveedor_id" class="form-select" required>
                            <option value="">Seleccione un proveedor</option>
                            @foreach ($proveedores as $p)
                                <option value="{{ $p->id }}">{{ $p->nombre }}</option>
                            @endforeach
                        </select>
                        <button type="button" class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#modalProveedor">
                            ➕ Añadir Proveedor
                        </button>
                    </div>
                </div>

                <!-- PRODUCTOS -->
                <div id="productos-container">
                    <label class="form-label fw-semibold">Productos</label>

                    <div class="producto-item border p-3 mb-3 rounded bg-light">
                        <div class="row g-2 align-items-center">
                            <div class="col-md-4">
                                <select class="form-select producto-select" name="productos[0][id]" required>
                                    <option value="">Seleccione un producto</option>
                                    @foreach ($productos as $producto)
                                        <option value="{{ $producto->id }}" data-precio="{{ $producto->precio_compra }}">
                                            {{ $producto->nombre }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="col-md-2">
                                <input type="number" step="0.01" min="0" class="form-control precio"
                                    name="productos[0][precio]" placeholder="Precio Compra (Bs)">
                            </div>

                            <div class="col-md-2">
                                <input type="number" min="1" class="form-control cantidad"
                                    name="productos[0][cantidad]" placeholder="Cantidad">
                            </div>

                            <div class="col-md-2">
                                <input type="text" class="form-control subtotal" value="0.00" readonly>
                            </div>

                            <div class="col-md-2 text-center">
                                <button type="button" class="btn btn-danger eliminar-producto">✖</button>
                            </div>
                        </div>
                    </div>

                    <button type="button" id="agregarProducto" class="btn btn-outline-dark mt-2">
                        ➕ Agregar otro producto
                    </button>
                    <button type="button" class="btn btn-outline-dark mt-2" data-bs-toggle="modal" data-bs-target="#modalProducto">
                        ➕ Añadir Producto
                    </button>
                </div>

                <hr class="my-4">

                <div class="text-end">
                    <h4>Total: <span id="totalCompra" class="text-success fw-bold">0.00</span> Bs</h4>
                    <button id="guardarCompra" type="submit" class="btn btn-dark mt-3">
                        💾 Guardar Compra
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- MODAL AÑADIR PROVEEDOR -->
    <div class="modal fade" id="modalProveedor" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">➕ Añadir Proveedor</h5>
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
                            <label class="form-label">Correo</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ciudad</label>
                            <input type="text" name="ciudad" class="form-control">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Dirección</label>
                            <input type="text" name="direccion" class="form-control">
                        </div>
                        <button type="submit" class="btn btn-dark w-100">Guardar Proveedor</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL AÑADIR PRODUCTO -->
    <div class="modal fade" id="modalProducto" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-dark text-white">
                    <h5 class="modal-title">➕ Añadir Producto</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="formProducto">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nombre</label>
                            <input type="text" name="nombre" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Descripción</label>
                            <textarea name="descripcion" class="form-control"></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio Compra</label>
                            <input type="number" name="precio_compra" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Precio Venta</label>
                            <input type="number" name="precio" class="form-control" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Stock Inicial</label>
                            <input type="number" name="stock" class="form-control" value="0" min="0">
                        </div>
                        <div class="mb-3">
                              <label class="form-label">Fecha de Vencimiento</label>
                                <input type="date" name="fecha_vencimiento" class="form-control">
                        </div><input type="hidden" name="proveedor_id" id="proveedor_id_modal">


                        <button type="submit" class="btn btn-dark w-100">Guardar Producto</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let index = 1;

            // ➕ Agregar nuevo producto a la lista
            document.getElementById('agregarProducto').addEventListener('click', function() {
                const container = document.getElementById('productos-container');
                const template = document.querySelector('.producto-item');
                const clone = template.cloneNode(true);

                clone.querySelectorAll('input').forEach(i => i.value = '');
                clone.querySelectorAll('select').forEach(s => s.selectedIndex = 0);
                clone.querySelectorAll('input, select').forEach(el => {
                    el.name = el.name.replace(/\[\d+\]/, `[${index}]`);
                });

                container.insertBefore(clone, this);
                index++;
            });

            // ❌ Eliminar producto
            document.addEventListener('click', e => {
                if (e.target.classList.contains('eliminar-producto')) {
                    e.target.closest('.producto-item').remove();
                    actualizarTotal();
                }
            });

            // 💰 Calcular subtotal y total
            document.addEventListener('input', e => {
                if (e.target.classList.contains('precio') || e.target.classList.contains('cantidad')) {
                    const item = e.target.closest('.producto-item');
                    const precio = parseFloat(item.querySelector('.precio').value) || 0;
                    const cantidad = parseInt(item.querySelector('.cantidad').value) || 0;
                    const subtotal = precio * cantidad;
                    item.querySelector('.subtotal').value = subtotal.toFixed(2);
                    actualizarTotal();
                }
            });

            // 🧮 Precio automático al elegir producto
            document.addEventListener('change', e => {
                if (e.target.classList.contains('producto-select')) {
                    const option = e.target.selectedOptions[0];
                    const precio = option.getAttribute('data-precio') || 0;
                    const item = e.target.closest('.producto-item');
                    item.querySelector('.precio').value = parseFloat(precio).toFixed(2);
                }
            });

            // Calcular total general
            function actualizarTotal() {
                let total = 0;
                document.querySelectorAll('.subtotal').forEach(i => total += parseFloat(i.value) || 0);
                document.getElementById('totalCompra').textContent = total.toFixed(2);
            }

            // 💾 Guardar compra vía AJAX
            document.getElementById('formCompra').addEventListener('submit', function(e) {
                e.preventDefault();

                const proveedor_id = document.getElementById('proveedor_id').value;
                const productos = [];

                document.querySelectorAll('.producto-item').forEach(item => {
                    const id = item.querySelector('.producto-select').value;
                    const precio = parseFloat(item.querySelector('.precio').value);
                    const cantidad = parseInt(item.querySelector('.cantidad').value);
                    const subtotal = parseFloat(item.querySelector('.subtotal').value);
                    if (id && cantidad > 0) productos.push({ id, precio, cantidad, subtotal });
                });

                if (!proveedor_id || productos.length === 0)
                    return alert('⚠️ Complete los datos correctamente.');

                const total = parseFloat(document.getElementById('totalCompra').textContent);

                fetch("{{ route('compras.store') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ proveedor_id, productos, total })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        alert('✅ Compra registrada correctamente');
                        window.location.href = "{{ route('compras.index') }}";
                    } else {
                        alert('❌ Error: ' + data.message);
                    }
                })
                .catch(() => alert('Error al guardar la compra.'));
            });

            // 💾 Guardar proveedor desde modal
            document.getElementById('formProveedor').addEventListener('submit', function(e) {
                e.preventDefault();
                // Pasar el proveedor seleccionado al formulario de producto
                    document.getElementById('proveedor_id_modal').value = document.getElementById('proveedor_id').value;

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
                    } else {
                        alert('Error al guardar proveedor.');
                    }
                })
                .catch(() => alert('Error al guardar proveedor.'));
            });

            // 💾 Guardar producto desde modal
            document.getElementById('formProducto').addEventListener('submit', function(e) {
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
                        document.querySelectorAll('.producto-select').forEach(sel => {
                            sel.insertAdjacentHTML('beforeend', `<option value="${data.id}">${data.nombre}</option>`);
                        });
                        bootstrap.Modal.getInstance(document.getElementById('modalProducto')).hide();
                        this.reset();
                    } else {
                        alert('Error al guardar producto.');
                    }
                })
                .catch(() => alert('Error al guardar producto.'));
            });
        });
    </script>
</x-app-layout>
