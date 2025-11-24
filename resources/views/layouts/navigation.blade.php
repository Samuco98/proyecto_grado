<nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">

                <!-- Logo -->
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <!-- Desktop Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-nav-link>

                    {{-- Enlaces visibles para todos los usuarios --}}
                    <x-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                        {{ __('Clientes') }}
                    </x-nav-link>

                    <x-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.*')">
                        {{ __('Citas Médicas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('mascotas.index')" :active="request()->routeIs('mascotas.*')">
                        {{ __('Registro de Mascotas') }}
                    </x-nav-link>

                    <x-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                        {{ __('Ventas') }}
                    </x-nav-link>

                    {{-- Solo visible para ADMIN --}}
                    @if(Auth::user() && Auth::user()->rol === 'admin')

                        <x-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                            {{ __('Usuarios') }}
                        </x-nav-link>

                        <x-nav-link :href="route('compras.index')" :active="request()->routeIs('compras.*')">
                            {{ __('Compras') }}
                        </x-nav-link>

                        <x-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                            {{ __('Productos') }}
                        </x-nav-link>

                        <x-nav-link :href="route('proveedors.index')" :active="request()->routeIs('proveedors.*')">
                            {{ __('Proveedores') }}
                        </x-nav-link>

                        <x-nav-link href="{{ route('reportes.index') }}" :active="request()->routeIs('reportes.*')">
                            📊 {{ __('Reportes') }}
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Perfil') }}
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}" id="logout-form">
                            @csrf
                            <x-dropdown-link href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                {{ __('Cerrar sesión') }}
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <!-- Hamburger Menu Button (Mobile) -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': !open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

        </div>
    </div>

    <!-- Mobile Navigation Menu -->
    <div :class="{'block': open, 'hidden': !open}" class="hidden sm:hidden">

        <div class="pt-2 pb-3 space-y-1">

            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>

            {{-- Enlaces del sistema --}}
            <x-responsive-nav-link :href="route('clientes.index')" :active="request()->routeIs('clientes.*')">
                {{ __('Clientes') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('citas.index')" :active="request()->routeIs('citas.*')">
                {{ __('Citas Médicas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('mascotas.index')" :active="request()->routeIs('mascotas.*')">
                {{ __('Registro de Mascotas') }}
            </x-responsive-nav-link>

            <x-responsive-nav-link :href="route('ventas.index')" :active="request()->routeIs('ventas.*')">
                {{ __('Ventas') }}
            </x-responsive-nav-link>

            {{-- Solo admin --}}
            @if(Auth::user() && Auth::user()->rol === 'admin')

                <x-responsive-nav-link :href="route('usuarios.index')" :active="request()->routeIs('usuarios.*')">
                    {{ __('Usuarios') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('compras.index')" :active="request()->routeIs('compras.*')">
                    {{ __('Compras') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('productos.index')" :active="request()->routeIs('productos.*')">
                    {{ __('Productos') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('proveedors.index')" :active="request()->routeIs('proveedors.*')">
                    {{ __('Proveedores') }}
                </x-responsive-nav-link>

                <x-responsive-nav-link :href="route('reportes.index')" :active="request()->routeIs('reportes.*')">
                    📊 {{ __('Reportes') }}
                </x-responsive-nav-link>

            @endif

        </div>

        <!-- Responsive User Settings -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">

                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Perfil') }}
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}" id="logout-form-responsive">
                    @csrf
                    <x-responsive-nav-link href="#" onclick="event.preventDefault(); document.getElementById('logout-form-responsive').submit();">
                        {{ __('Cerrar sesión') }}
                    </x-responsive-nav-link>
                </form>

            </div>
        </div>

    </div>
</nav>
