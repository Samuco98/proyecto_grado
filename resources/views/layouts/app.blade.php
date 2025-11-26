<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Veterinaria J&C') }}</title>

    <!-- Bootstrap 5.3 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>

</head>
<body class="bg-light text-dark">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <!-- Logo / título -->
        <a class="navbar-brand fw-bold text-white" href="{{ route('dashboard') }}">
            Veterinaria J&C
        </a>

        <!-- 🔹 BOTÓN MÓVIL (Hamburguesa) -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menú principal -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">

                {{--  ADMINISTRADOR --}}
                @if(Auth::user()->rol === 'admin')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('usuarios*') ? 'active' : '' }}" href="{{ route('usuarios.index') }}">
                            Usuarios
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('clientes*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                            Clientes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('productos*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                            Productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('proveedors*') ? 'active' : '' }}" href="{{ route('proveedors.index') }}">
                            Proveedores
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('compras*') ? 'active' : '' }}" href="{{ route('compras.index') }}">
                            Compras
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('ventas*') ? 'active' : '' }}" href="{{ route('ventas.index') }}">
                            Ventas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('citas*') ? 'active' : '' }}" href="{{ route('citas.index') }}">
                            Citas 
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('consultas.index') }}">
                            Consultas 
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('mascotas*') ? 'active' : '' }}" href="{{ route('mascotas.index') }}">
                            Mascotas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('reportes*') ? 'active' : '' }}" href="{{ route('reportes.index') }}">
                             Reportes
                        </a>
                    </li>

                {{-- EMPLEADO --}}
                @elseif(Auth::user()->rol === 'empleado')

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('clientes*') ? 'active' : '' }}" href="{{ route('clientes.index') }}">
                            Clientes
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('productos*') ? 'active' : '' }}" href="{{ route('productos.index') }}">
                            Productos
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('ventas*') ? 'active' : '' }}" href="{{ route('ventas.index') }}">
                            Ventas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('citas*') ? 'active' : '' }}" href="{{ route('citas.index') }}">
                            Citas
                        </a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('mascotas*') ? 'active' : '' }}" href="{{ route('mascotas.index') }}">
                            Mascotas
                        </a>
                    </li>

                @endif
            </ul>

            <!-- Botón Cerrar sesión -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-outline-light btn-sm">Cerrar sesión</button>
                    </form>
                </li>
            </ul>

        </div> <!-- FIN collapse -->
    </div>
</nav>

<!-- Contenido principal -->
<main class="container py-4">
    {{ $slot }}
</main>

<footer class="text-center py-3 text-muted">
    <small>© {{ date('Y') }} Veterinaria J&C</small>
</footer>

</body>
</html>
