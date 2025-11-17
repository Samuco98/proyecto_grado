<x-app-layout>
    <div class="container mt-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white">
                <h5 class="mb-0">➕ Agregar Vacuna para {{ $mascota->nombre }}</h5>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('vacunas.store') }}">
                    @csrf
                    <input type="hidden" name="mascota_id" value="{{ $mascota->id }}">
                    <div class="mb-3">
                        <label class="form-label">Nombre de la Vacuna</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fecha de Aplicación</label>
                        <input type="date" name="fecha_aplicacion" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Veterinario</label>
                        <input type="text" name="veterinario" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Observaciones</label>
                        <textarea name="observaciones" class="form-control"></textarea>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-success">💾 Guardar Vacuna</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
