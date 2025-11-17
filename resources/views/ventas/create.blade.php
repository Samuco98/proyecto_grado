<x-app-layout>
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">🛍️ Registrar Nueva Venta</h2>

        <div class="card p-4 shadow-sm">
            <form id="formVenta">
                @csrf

                <div class="mb-3">
                    <label class="form-label fw-bold">Cliente</label>
                    <select name="cliente_id" id="cliente_id" class="form-select" required>
                        <option value="">Seleccione un cliente</option>
                        @foreach ($clientes as $c)
                            <option value="{{ $c->id }}">{{ $c->nombre }}</option>
                        @endforeach
                    </select>
                </div>

                <hr>

                <div class="mb-3">
                    <label class="form-label fw-bold">Agregar Producto</label>
                    <div class="input-group">
                        <select id="producto_id" class="form-select">
                            <option value="">Seleccione un producto</option>
                            @foreach ($productos as $p)
                                <option value="{{ $p->id }}" data-precio="{{ $p->precio }}" data-stock="{{ $p->stock }}">
                                    {{ $p->nombre }} — Bs {{ $p->precio }} (Stock: {{ $p->stock }})
                                </option>
                            @endforeach
                        </select>
                        <input type="number" id="cantidad" class="form-control" placeholder="Cantidad" min="1">
                        <button type="button" id="agregarProducto" class="btn btn-dark">➕ Agregar producto</button>
                    </div>
                </div>

                <table class="table table-bordered mt-3" id="tablaProductos">
                    <thead class="table-dark text-center">
                        <tr>
                            <th>Producto</th>
                            <th>Precio (Bs)</th>
                            <th>Cantidad</th>
                            <th>Subtotal (Bs)</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                </table>

                <div class="text-end">
                    <h4 class="fw-bold">Total: Bs <span id="totalVenta">0.00</span></h4>
                </div>

                <div class="text-end mt-4">
                    <a href="{{ route('ventas.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-dark">Guardar Venta</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const productos = @json($productos);
        let listaProductos = [];

        function actualizarTabla() {
            const tbody = document.querySelector("#tablaProductos tbody");
            tbody.innerHTML = "";
            let total = 0;

            listaProductos.forEach((p, i) => {
                total += p.subtotal;
                tbody.innerHTML += `
                    <tr>
                        <td>${p.nombre}</td>
                        <td class="text-center">${p.precio}</td>
                        <td class="text-center">${p.cantidad}</td>
                        <td class="text-center">${p.subtotal.toFixed(2)}</td>
                        <td class="text-center">
                            <button type="button" class="btn btn-sm btn-danger" onclick="eliminar(${i})">🗑️</button>
                        </td>
                    </tr>`;
            });

            document.getElementById("totalVenta").innerText = total.toFixed(2);
        }

        function eliminar(i) {
            listaProductos.splice(i, 1);
            actualizarTabla();
        }

        document.getElementById("agregarProducto").addEventListener("click", () => {
            const select = document.getElementById("producto_id");
            const id = select.value;
            const cantidad = parseInt(document.getElementById("cantidad").value);

            if (!id || !cantidad || cantidad <= 0) {
                return alert("⚠️ Seleccione un producto y cantidad válida.");
            }

            const producto = productos.find(p => p.id == id);
            if (cantidad > producto.stock) {
                return alert(`❌ Stock insuficiente (${producto.stock} disponibles).`);
            }

            const subtotal = cantidad * producto.precio;
            listaProductos.push({
                id: producto.id,
                nombre: producto.nombre,
                cantidad,
                precio: producto.precio,
                subtotal
            });

            document.getElementById("cantidad").value = "";
            select.selectedIndex = 0;
            actualizarTabla();
        });

        document.getElementById("formVenta").addEventListener("submit", e => {
            e.preventDefault();
            if (listaProductos.length === 0) {
                return alert("⚠️ Agregue al menos un producto.");
            }

            const formData = new FormData(e.target);
            formData.append("productos", JSON.stringify(listaProductos));
            formData.append("total", document.getElementById("totalVenta").innerText);

            fetch("{{ route('ventas.store') }}", {
                method: "POST",
                headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" },
                body: formData
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    alert("✅ Venta registrada correctamente.");
                    window.location.href = "{{ route('ventas.index') }}";
                } else {
                    alert("❌ Error: " + data.message);
                }
            })
            .catch(() => alert("⚠️ Error de conexión al servidor."));
        });
    </script>
</x-app-layout>
