<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\CitaController;
use App\Http\Controllers\MascotaController;
use App\Http\Controllers\VacunaController;
use App\Http\Controllers\UsuarioController;

    use App\Models\Cliente;

/*
|--------------------------------------------------------------------------
| RUTAS PARA ADMINISTRADOR (Acceso total)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:admin'])->group(function () {
    // Módulos principales
     Route::get('reportes', [\App\Http\Controllers\ReporteController::class, 'index'])->name('reportes.index');
    Route::post('reportes/generar', [\App\Http\Controllers\ReporteController::class, 'generar'])->name('reportes.generar');
    Route::resource('clientes', ClienteController::class);
    Route::resource('proveedors', ProveedorController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('compras', CompraController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('mascotas', MascotaController::class);
    Route::resource('vacunas', VacunaController::class);
    Route::resource('usuarios', UsuarioController::class);
 

    Route::get('/api/clientes/{id}/mascotas', function($id) {
    $cliente = Cliente::with('mascotas')->find($id);
    return response()->json($cliente ? $cliente->mascotas : []);
});

    // Citas médicas (CRUD completo)

Route::middleware('auth')->group(function () {
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::get('/citas/listar', [CitaController::class, 'listar'])->name('citas.listar'); // para fullcalendar
    Route::get('/citas/{id}', [CitaController::class, 'show'])->name('citas.show');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::put('/citas/{id}', [CitaController::class, 'update'])->name('citas.update');
    Route::delete('/citas/{id}', [CitaController::class, 'destroy'])->name('citas.destroy');

    // endpoint auxiliar: mascotas por cliente (API)
    Route::get('/api/clientes/{cliente}/mascotas', function (\App\Models\Cliente $cliente) {
        return $cliente->mascotas()->select('id','nombre')->get();
    })->name('api.clientes.mascotas');
});



    // JSON de proveedores (usado en compras)
    Route::get('proveedors/{id}/json', [ProveedorController::class, 'showJson'])
        ->name('proveedors.showJson');
});

/*
|--------------------------------------------------------------------------
| RUTAS PARA EMPLEADO (Acceso limitado)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:empleado'])->group(function () {
    // Módulos permitidos
    Route::resource('clientes', ClienteController::class);
    Route::resource('productos', ProductoController::class);
    Route::resource('ventas', VentaController::class);
    Route::resource('mascotas', MascotaController::class);
    Route::resource('vacunas', VacunaController::class);
    

    // Citas médicas
    Route::get('/citas', [CitaController::class, 'index'])->name('citas.index');
    Route::post('/citas', [CitaController::class, 'store'])->name('citas.store');
    Route::get('/citas/listar', [CitaController::class, 'listar'])->name('citas.listar');
    Route::get('/citas/{id}', [CitaController::class, 'show'])->name('citas.show');
});

/*
|--------------------------------------------------------------------------
| RUTAS GENERALES
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Perfil de usuario
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rutas de autenticación (login / register / logout)
require __DIR__ . '/auth.php';
