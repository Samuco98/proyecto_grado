<x-app-layout>
    <div class="container mt-4">
        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="fw-bold">🐾 Mascotas de {{ $cliente->nombre }} {{ $cliente->apellidos }}</h5>
            </div>
            <div class="card-body">
                @foreach ($cliente->mascotas as $m)
                    <div class="border rounded p-3 mb-3">
                        <div class="d-flex justify-content-between">
                            <h5>{{ $m->nombre }} ({{ $m->especie }})</h5>
                            <button class="btn btn-sm btn-dark" data-id="{{ $m->id }}" data-bs-toggle="modal" data-bs-target="#modalVacuna">+ Vacuna</button>
                        </div>
                        <p>Raza: {{ $m->raza ?? '—' }} | Sexo: {{ $m->sexo }} | Nacimiento: {{ $m->fecha_nacimiento }}</p>

                        <h6 class="fw-bold mt-3">💉 Vacunas Aplicadas</h6>
                        <ul>
                            @forelse ($m->vacunas as $v)
                                <li>{{ $v->nombre }} — {{ $v->fecha_aplicacion }}</li>
                            @empty
                                <li class="text-muted">Sin vacunas registradas</li>
                            @endforelse
                        </ul>
                    </div>
                @endforeach
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
                        <input type="hidden" name="mascota_id" id="mascota_id">
                        <div class="mb-2"><label>Nombre Vacuna</label><input name="nombre" class="form-control" required></div>
                        <div class="mb-2"><label>Fecha Aplicación</label><input type="date" name="fecha_aplicacion" class="form-control" required></div>
                        <div class="mb-2"><label>Veterinario</label><input name="veterinario" class="form-control"></div>
                        <div class="mb-2"><label>Observaciones</label><textarea name="observaciones" class="form-control"></textarea></div>
                        <button class="btn btn-dark w-100 mt-2">💾 Guardar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const modal = document.getElementById('modalVacuna');
        modal.addEventListener('show.bs.modal', e => {
            document.getElementById('mascota_id').value = e.relatedTarget.getAttribute('data-id');
        });

        document.getElementById('formVacuna').addEventListener('submit', e => {
            e.preventDefault();
            fetch("{{ route('vacunas.store') }}", {
                method: 'POST',
                headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}', 'Accept': 'application/json'},
                body: new FormData(e.target)
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) { alert('✅ Vacuna registrada'); location.reload(); }
                else alert('❌ Error al guardar vacuna');
            });
        });
    });
    </script>
</x-app-layout>
