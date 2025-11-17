<x-app-layout>
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h3 class="mb-0">📅 Citas Médicas</h3>
            <button class="btn btn-dark" id="btnNuevaCita" data-bs-toggle="modal" data-bs-target="#modalCita">+ Nueva Cita</button>
        </div>

        <div id="calendar"></div>
    </div>

    <!-- Modal Crear / Editar Cita -->
    <div class="modal fade" id="modalCita" tabindex="-1">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header bg-dark text-white">
            <h5 class="modal-title" id="modalTitle">Programar Nueva Cita</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
          </div>
          <div class="modal-body">
            <form id="formCita">
                @csrf
                <input type="hidden" id="cita_id" name="cita_id" value="">
                <div class="mb-3">
                    <label class="form-label">Cliente</label>
                    <select id="cliente_id" name="cliente_id" class="form-select" required>
                        <option value="">Seleccione cliente</option>
                        @foreach($clientes as $cliente)
                            <option value="{{ $cliente->id }}">{{ $cliente->nombre }} {{ $cliente->apellidos ?? '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Mascota</label>
                    <select id="mascota_id" name="mascota_id" class="form-select" required>
                        <option value="">Seleccione mascota</option>
                        {{-- Se llena por JS al elegir cliente --}}
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Motivo</label>
                    <textarea id="motivo" name="motivo" class="form-control" rows="3" required></textarea>
                </div>

                <div class="row g-2">
                    <div class="col-6">
                        <label class="form-label">Fecha</label>
                        <input type="date" id="fecha" name="fecha" class="form-control" required>
                    </div>
                    <div class="col-6">
                        <label class="form-label">Hora</label>
                        <input type="time" id="hora" name="hora" class="form-control" required>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button id="btnEliminarCita" class="btn btn-danger me-auto" style="display:none">Eliminar</button>
            <button id="btnGuardarCita" class="btn btn-success">Guardar</button>
            <button class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>

    <!-- FullCalendar CSS/JS -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');

        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            locale: 'es',
            height: 650,
            events: "{{ route('citas.listar') }}",
            dateClick: info => {
                // Nuevo -> prellenar fecha
                resetModal();
                document.getElementById('fecha').value = info.dateStr;
                document.getElementById('modalTitle').textContent = 'Programar Nueva Cita';
                document.getElementById('btnEliminarCita').style.display = 'none';
                new bootstrap.Modal(document.getElementById('modalCita')).show();
            },
            eventClick: info => {
                // Abrir detalle y permitir editar/eliminar
                fetch(`/citas/${info.event.id}`)
                    .then(r => r.json())
                    .then(data => {
                        // llenar modal
                        document.getElementById('cita_id').value = data.id;
                        document.getElementById('cliente_id').value = data.cliente_id;
                        // cargar mascotas del cliente primero
                        cargarMascotas(data.cliente_id, data.mascota_id);
                        document.getElementById('motivo').value = data.motivo;
                        document.getElementById('fecha').value = data.fecha;
                        document.getElementById('hora').value = data.hora;

                        document.getElementById('modalTitle').textContent = 'Editar Cita';
                        document.getElementById('btnEliminarCita').style.display = ''; // mostrar
                        new bootstrap.Modal(document.getElementById('modalCita')).show();
                    })
                    .catch(() => alert('No se pudo obtener la cita'));
            }
        });

        calendar.render();

        // Cuando cambie cliente, cargar sus mascotas
        document.getElementById('cliente_id').addEventListener('change', function() {
            const clienteId = this.value;
            cargarMascotas(clienteId);
        });

        function cargarMascotas(clienteId, selected = null) {
            const mascotaSelect = document.getElementById('mascota_id');
            mascotaSelect.innerHTML = '<option>Cargando...</option>';
            if (!clienteId) {
                mascotaSelect.innerHTML = '<option value="">Seleccione mascota</option>';
                return;
            }
            fetch(`/api/clientes/${clienteId}/mascotas`)
                .then(r => r.json())
                .then(list => {
                    mascotaSelect.innerHTML = '<option value="">Seleccione mascota</option>';
                    list.forEach(m => {
                        const opt = document.createElement('option');
                        opt.value = m.id;
                        opt.textContent = m.nombre;
                        if (selected && selected == m.id) opt.selected = true;
                        mascotaSelect.appendChild(opt);
                    });
                })
                .catch(() => mascotaSelect.innerHTML = '<option value="">Error al cargar</option>');
        }

        // Guardar (crear o update)
        // Guardar (crear o update) — FIX para PUT con FormData (usamos _method=PUT)
document.getElementById('btnGuardarCita').addEventListener('click', function() {
    const form = document.getElementById('formCita');
    const id = document.getElementById('cita_id').value;
    // Si es edición usamos POST + _method=PUT (Laravel acepta spoofing)
    const url = id ? `/citas/${id}` : "{{ route('citas.store') }}";
    const method = 'POST'; // siempre POST en fetch para evitar problemas con PUT multipart

    const formData = new FormData(form);

    if (id) {
        formData.set('_method', 'PUT'); // important: Laravel method spoofing
    }

    fetch(url, {
        method: method,
        headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: formData
    })
    .then(async res => {
        // manejar errores de validación (422) o respuestas OK
        if (res.ok) return res.json();
        const err = await res.json().catch(()=>({message:'Error desconocido'}));
        throw err;
    })
    .then(data => {
        if (data.success) {
            alert('✅ Cita guardada');
            bootstrap.Modal.getInstance(document.getElementById('modalCita')).hide();
            calendar.refetchEvents();
            form.reset();
        } else {
            alert('❌ ' + (data.message || 'Error al guardar'));
        }
    })
    .catch(e => {
        if (e.errors) {
            const msgs = Object.values(e.errors).flat().join("\n");
            alert('Errores:\n' + msgs);
        } else {
            alert('Error al guardar cita: ' + (e.message || 'Desconocido'));
        }
    });
});


        // Eliminar
        document.getElementById('btnEliminarCita').addEventListener('click', function() {
            if (!confirm('¿Eliminar esta cita?')) return;
            const id = document.getElementById('cita_id').value;
            fetch(`/citas/${id}`, {
                method: 'DELETE',
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    alert('Cita eliminada');
                    bootstrap.Modal.getInstance(document.getElementById('modalCita')).hide();
                    calendar.refetchEvents();
                } else {
                    alert('Error al eliminar');
                }
            })
            .catch(()=>alert('Error al eliminar'));
        });

        function resetModal() {
            document.getElementById('formCita').reset();
            document.getElementById('cita_id').value = '';
            document.getElementById('mascota_id').innerHTML = '<option value="">Seleccione mascota</option>';
        }

        // botón nueva cita: reset modal
        document.getElementById('btnNuevaCita').addEventListener('click', () => {
            resetModal();
            document.getElementById('modalTitle').textContent = 'Programar Nueva Cita';
            document.getElementById('btnEliminarCita').style.display = 'none';
        });
    });
    </script>
</x-app-layout>
