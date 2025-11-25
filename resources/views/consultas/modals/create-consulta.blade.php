<div class="modal fade" id="modalConsulta" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">

            <div class="modal-header bg-dark text-white">
                <h5>Registrar Nueva Consulta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                <form id="formConsulta">
                    @csrf

                    <div class="row g-3">

                        <div class="col-md-6">
                            <label class="form-label">Cliente</label>
                            <select name="cliente_id" id="cliente_id_consulta" class="form-select" required>
                                <option value="">Seleccione un cliente</option>
                                @foreach ($clientes as $c)
                                    <option value="{{ $c->id }}">{{ $c->nombre }} {{ $c->apellidos }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Mascota</label>
                            <select name="mascota_id" id="mascota_id_consulta" class="form-select" required>
                                <option value="">Seleccione un cliente primero</option>
                            </select>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Motivo</label>
                            <textarea name="motivo" class="form-control" required></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Diagnóstico</label>
                            <textarea name="diagnostico" class="form-control"></textarea>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Tratamiento</label>
                            <textarea name="tratamiento" class="form-control"></textarea>
                        </div>

                    </div>

                    <hr>

                    <h5 class="mt-3 fw-bold">Medicamentos Usados</h5>

                    <table class="table table-bordered">
                        <thead class="table-dark">
                            <tr>
                                <th>Producto</th>
                                <th style="width: 100px">Cant.</th>
                                <th style="width: 120px">Precio</th>
                                <th style="width: 120px">Subtotal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody id="tabla_productos">
                            <tr>
                                <td>
                                    <select name="productos[]" class="form-select producto">
                                        <option value="">Seleccione</option>
                                        @foreach ($productos as $prod)
                                            <option value="{{ $prod->id }}"
                                                data-precio="{{ $prod->precio }}">
                                                {{ $prod->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="cantidades[]" class="form-control cantidad" min="1" value="1">
                                </td>
                                <td>
                                    <input type="number" name="precios[]" class="form-control precio" step="0.01">
                                </td>
                                <td>
                                    <input type="text" class="form-control subtotal" readonly>
                                </td>
                                <td>
                                    <button type="button" class="btn btn-danger btn-sm eliminarFila">X</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>

                    <div class="text-end mt-3">
                        <h4>Total: <span id="total_span" class="text-success">0.00 Bs</span></h4>
                        <input type="hidden" name="total" id="total_general">
                    </div>

                    <button type="button" class="btn btn-secondary" id="btnAgregarFila">
                        + Añadir Producto
                    </button>

                    <hr>

                    <div class="text-end mt-3">
                        <button type="submit" class="btn btn-dark">💾 Guardar Consulta</button>
                    </div>

                </form>
            </div>

        </div>
    </div>
</div>
<script>
// Cargar mascotas según cliente
document.getElementById("cliente_id_consulta").addEventListener("change", function () {
    let clienteId = this.value;

    fetch(`/mascotas-por-cliente/${clienteId}`)
        .then(res => res.json())
        .then(data => {
            let select = document.getElementById("mascota_id_consulta");
            select.innerHTML = "";

            data.forEach(mascota => {
                select.innerHTML += `<option value="${mascota.id}">${mascota.nombre}</option>`;
            });
        });
});

// Añadir fila
document.getElementById("btnAgregarFila").addEventListener("click", function () {
    let fila = `
        <tr>
            <td>
                <select name="productos[]" class="form-select producto">
                    <option value="">Seleccione</option>
                    @foreach ($productos as $prod)
                        <option value="{{ $prod->id }}" data-precio="{{ $prod->precio }}">
                            {{ $prod->nombre }}
                        </option>
                    @endforeach
                </select>
            </td>
            <td><input type="number" name="cantidades[]" class="form-control cantidad" min="1" value="1"></td>
            <td><input type="number" name="precios[]" class="form-control precio" step="0.01"></td>
            <td><input type="text" class="form-control subtotal" readonly></td>
            <td><button type="button" class="btn btn-danger btn-sm eliminarFila">X</button></td>
        </tr>
    `;
    document.getElementById("tabla_productos").insertAdjacentHTML("beforeend", fila);
});

// Eliminar fila
document.addEventListener("click", function (e) {
    if (e.target.classList.contains("eliminarFila")) {
        e.target.closest("tr").remove();
        calcularTotal();
    }
});

// Reacción al cambiar precio, cantidad o producto
document.addEventListener("change", function (e) {
    if (e.target.classList.contains("producto") ||
        e.target.classList.contains("cantidad") ||
        e.target.classList.contains("precio")) {
        actualizarFila(e.target.closest("tr"));
        calcularTotal();
    }
});

function actualizarFila(fila) {
    let producto = fila.querySelector(".producto");
    let cantidad = fila.querySelector(".cantidad").value;
    let precioInput = fila.querySelector(".precio");
    let subtotalInput = fila.querySelector(".subtotal");

    if (!precioInput.value) {
        let precio = producto.options[producto.selectedIndex].dataset.precio;
        precioInput.value = precio;
    }

    let subtotal = precioInput.value * cantidad;
    subtotalInput.value = subtotal.toFixed(2);
}

function calcularTotal() {
    let total = 0;

    document.querySelectorAll(".subtotal").forEach(sub => {
        total += parseFloat(sub.value || 0);
    });

    document.getElementById("total_span").textContent = total.toFixed(2) + " Bs";
    document.getElementById("total_general").value = total.toFixed(2);
}

// Guardar consulta por AJAX
document.getElementById("formConsulta").addEventListener("submit", e => {
    e.preventDefault();

    fetch("{{ route('consultas.store') }}", {
        method: "POST",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
            "Accept": "application/json"
        },
        body: new FormData(e.target)
    })
    .then(res => res.json())
    .then(data => {
        alert("Consulta registrada ✓");
        location.reload();
    });
});
</script>
