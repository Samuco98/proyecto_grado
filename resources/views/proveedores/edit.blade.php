<x-app-layout>
    <div class="container mt-4">
        <h3 class="mb-3">Editar Proveedor</h3>
<form action="{{ route('proveedors.update', ['proveedor' => $proveedor->id]) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="mb-3">
        <label for="nombre" class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" value="{{ $proveedor->nombre }}" required>
    </div>

    <div class="mb-3"><label class="form-label">NIT</label>
  <input name="nit" class="form-control" value="{{ old('nit', $proveedor->nit ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Dirección</label>
  <input name="direccion" class="form-control" value="{{ old('direccion', $proveedor->direccion ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Ciudad</label>
  <input name="ciudad" class="form-control" value="{{ old('ciudad', $proveedor->ciudad ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Teléfono</label>
  <input name="telefono" class="form-control" value="{{ old('telefono', $proveedor->telefono ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Email</label>
  <input type="email" name="email" class="form-control" value="{{ old('email', $proveedor->email ?? '') }}">
</div>
<div class="mb-3"><label class="form-label">Contacto</label>
  <input name="contacto" class="form-control" value="{{ old('contacto', $proveedor->contacto ?? '') }}">
</div>


    <button type="submit" class="btn btn-success">Actualizar</button>
</form>

    </div>
</x-app-layout>
