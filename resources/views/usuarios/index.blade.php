<x-app-layout>
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
            <h3>Lista de Usuarios</h3>
            
        </div>

    {{-- Mensajes de éxito --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    

    {{-- Tabla de usuarios --}}
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped align-middle">
                <thead class="table-dark">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($usuarios as $usuario)
                        <tr class="text-center">
                            <td>{{ $usuario->id }}</td>
                            <td>{{ $usuario->name }}</td>
                            <td>{{ $usuario->email }}</td>
                            <td>
                                <span class="badge {{ $usuario->rol === 'admin' ? 'bg-primary' : 'bg-warning text-dark' }}">
                                    {{ ucfirst($usuario->rol) }}
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm editarUsuario"
                                        data-id="{{ $usuario->id }}"
                                        data-nombre="{{ $usuario->name }}"
                                        data-email="{{ $usuario->email }}"
                                        data-rol="{{ $usuario->rol }}">
                                    ✏️ 
                                </button>
                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('¿Seguro que desea eliminar este usuario?')">
                                        🗑️ 
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    {{-- Botón para abrir modal --}}
    <div class="text-end mt-3">
        <button class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#modalUsuario">
            + Nuevo Usuario
        </button>
    </div>
</div>

{{-- Modal Crear / Editar Usuario --}}
<div class="modal fade" id="modalUsuario" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title">Nuevo Usuario</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>
      <div class="modal-body">
        <form id="formUsuario">
          @csrf
          <input type="hidden" id="usuario_id">

          <div class="mb-3">
            <label class="form-label fw-bold">Nombre</label>
            <input type="text" name="name" id="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Email</label>
            <input type="email" name="email" id="email" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Contraseña</label>
            <input type="password" name="password" id="password" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold">Rol</label>
            <select name="rol" id="rol" class="form-select" required>
              <option value="">Seleccione un rol</option>
              <option value="admin">Administrador</option>
              <option value="empleado">Empleado</option>
            </select>
          </div>

          <button type="submit" class="btn btn-success w-100">Guardar</button>
        </form>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formUsuario');
    const modal = new bootstrap.Modal(document.getElementById('modalUsuario'));

    // Crear o actualizar usuario
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        const id = document.getElementById('usuario_id').value;
        const url = id ? `/usuarios/${id}` : `/usuarios`;
        const method = id ? 'PUT' : 'POST';

        fetch(url, {
            method: method,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                name: document.getElementById('name').value,
                email: document.getElementById('email').value,
                password: document.getElementById('password').value,
                rol: document.getElementById('rol').value
            })
        })
        .then(res => {
            if (!res.ok) throw new Error('Error al guardar usuario');
            return res.json();
        })
        .then(data => {
            alert('✅ Usuario guardado correctamente');
            location.reload();
        })
        .catch(err => alert(err.message));
    });

    // Cargar datos al editar
    document.querySelectorAll('.editarUsuario').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelector('.modal-title').textContent = 'Editar Usuario';
            document.getElementById('usuario_id').value = this.dataset.id;
            document.getElementById('name').value = this.dataset.nombre;
            document.getElementById('email').value = this.dataset.email;
            document.getElementById('password').required = false;
            document.getElementById('rol').value = this.dataset.rol;
            modal.show();
        });
    });

    // Resetear modal al cerrar
    document.getElementById('modalUsuario').addEventListener('hidden.bs.modal', function() {
        form.reset();
        document.querySelector('.modal-title').textContent = 'Nuevo Usuario';
        document.getElementById('usuario_id').value = '';
        document.getElementById('password').required = true;
    });
});
</script>
</x-app-layout>
