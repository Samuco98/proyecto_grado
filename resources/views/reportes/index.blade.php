<x-app-layout>
    <div class="container mt-4">
        <h2 class="text-center fw-bold mb-4">📊 Reportes Generales</h2>

        <div class="card p-4 shadow-sm">
            <form action="{{ route('reportes.generar') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label fw-bold">Tipo de Reporte</label>
                        <select name="tipo" class="form-select" required>
                            <option value="">Seleccione...</option>
                            <option value="ventas">Ventas</option>
                            <option value="compras">Compras</option>
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Desde</label>
                        <input type="date" name="desde" class="form-control">
                    </div>

                    <div class="col-md-4">
                        <label class="form-label fw-bold">Hasta</label>
                        <input type="date" name="hasta" class="form-control">
                    </div>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-dark">🔍 Generar Reporte</button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
