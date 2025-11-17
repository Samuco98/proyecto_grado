<x-app-layout>
    <div class="container mt-4">
        <!-- Tarjeta principal de bienvenida -->
        <div class="card shadow-lg border-0 rounded-3">
            <div class="card-body text-center">
                <h3 class="fw-bold mb-3">🐾 Bienvenido, {{ Auth::user()->name }}</h3>
                <p class="text-muted mb-4">Has iniciado sesión correctamente en el sistema veterinario <strong>J&C</strong>.</p>

                <!-- Imagen del logo -->
                <div class="d-flex justify-content-center mb-4">
                    <img src="{{ asset('images/logo2.png') }}" 
                        alt="Logo veterinaria" 
                        class="img-fluid rounded-circle shadow"
                        style="max-width: 160px; border: 3px solid #dee2e6;">
                </div>

                <!-- Contenedor de tarjetas (Citas médicas y más módulos futuros) -->
                <div class="row justify-content-center mt-4">

                    <!-- Tarjeta del calendario de citas -->
                   <div class="col-md-6">
    <div class="card shadow-sm p-3">
        <h5>📅 Citas Médicas</h5>
        <div id="miniCalendar"></div>
    </div>
</div>

<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const calendarEl = document.getElementById('miniCalendar');
    const calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        height: 400,
        locale: 'es',
        events: "{{ route('citas.listar') }}", // reutiliza las mismas citas
        eventClick: function(info) {
            const id = info.event.id;
            fetch(`/citas/${id}`)
                .then(res => res.json())
                .then(data => {
                    if (data.error) throw new Error(data.error);
                    alert(
                        `🩺 Detalle de la cita:\n\n` +
                        `👤 Cliente: ${data.cliente}\n` +
                        `🐾 Mascota: ${data.mascota}\n` +
                        `📖 Motivo: ${data.motivo}\n` +
                        `📅 Fecha: ${data.fecha}\n` +
                        `🕒 Hora: ${data.hora}`
                    );
                })
                .catch(() => alert('❌ No se pudo cargar la información de la cita.'));
        }
    });
    calendar.render();
});
</script>

                    <!-- Tarjeta opcional: puedes añadir más módulos aquí -->
                    {{-- 
                    <div class="col-lg-6 col-md-8 mt-3 mt-md-0">
                        <div class="card shadow-sm border-0">
                            <div class="card-header bg-success text-white">
                                <h5 class="mb-0"> Compras Recientes</h5>
                            </div>
                            <div class="card-body">
                                <p class="text-muted">Aquí se pueden mostrar tus últimas compras...</p>
                            </div>
                        </div>
                    </div>
                    --}}
                </div>
            </div>
        </div>
    </div>

    <!-- FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>

    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const calendarEl = document.getElementById('miniCalendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            height: 450,
            locale: 'es',
            events: "{{ route('citas.listar') }}",

            // Cuando haces clic en una cita → muestra detalle bonito
            eventClick: function(info) {
                const id = info.event.id;
                fetch(`/citas/${id}`)
                    .then(res => res.json())
                    .then(data => {
                        const detalle = `
                            <div class="text-start">
                                <h5 class="fw-bold text-primary mb-2">🩺 Detalle de la Cita</h5>
                                <p><strong>👤 Cliente:</strong> ${data.cliente}</p>
                                <p><strong>🐾 Mascota:</strong> ${data.mascota || '—'}</p>
                                <p><strong>📖 Motivo:</strong> ${data.motivo || '—'}</p>
                                <p><strong>📅 Fecha:</strong> ${data.fecha}</p>
                                <p><strong>🕒 Hora:</strong> ${data.hora}</p>
                            </div>
                        `;
                        // Mostrar detalle con un modal de Bootstrap
                        const modalHTML = `
                            <div class="modal fade" id="detalleCitaModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-info text-white">
                                            <h5 class="modal-title">Detalle de la Cita</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body">${detalle}</div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                        document.body.insertAdjacentHTML('beforeend', modalHTML);
                        const modal = new bootstrap.Modal(document.getElementById('detalleCitaModal'));
                        modal.show();
                        document.getElementById('detalleCitaModal').addEventListener('hidden.bs.modal', () => {
                            document.getElementById('detalleCitaModal').remove();
                        });
                    });
            }
        });

        calendar.render();
    });
    </script>
</x-app-layout>
