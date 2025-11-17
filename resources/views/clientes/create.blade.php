<x-app-layout>
<div class="container mt-4">
    <h3>Nuevo Cliente</h3>

    <form action="{{ route('clientes.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="nombre" class="form-label">Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
        </div>
        <div class="mb-3"><label class="form-label">Apellidos</label>
  <input name="apellidos" class="form-control" value="{{ old('apellidos', $cliente->apellidos ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">C.I.</label>
  <input name="ci" class="form-control" value="{{ old('ci', $cliente->ci ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">NIT</label>
  <input name="nit" class="form-control" value="{{ old('nit', $cliente->nit ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Dirección</label>
  <input name="direccion" class="form-control" value="{{ old('direccion', $cliente->direccion ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Teléfono</label>
  <input name="telefono" class="form-control" value="{{ old('telefono', $cliente->telefono ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Email</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $cliente->email ?? '') }}">
</div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('clientes.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
</x-app-layout>
