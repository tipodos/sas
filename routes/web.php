<?php

use App\Http\Controllers\ListaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\CompraController;
use App\Http\Controllers\DatoController;
use App\Http\Controllers\MovimientoController;
use App\Http\Controllers\GastoController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VentaController;
use App\Models\supplier;
use App\Models\Venta;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('ventas.index');
});

Route::resource('/producto', Productocontroller::class);
Route::put('/producto/estado/{id}',[ProductoController::class, 'estado'])->name('producto.estado');

Route::resource('/proveedor', SupplierController::class);
Route::put('/proveedor/estado/{id}', [SupplierController::class, 'estado'])->name('proveedor.estado');

Route::resource('/datos', DatoController::class);

Route::resource('/gastos', GastoController::class);

Route::resource('/compras', CompraController::class);

Route::resource('/movimientos', MovimientoController::class);

Route::resource('/categoria', CategoriaController::class);
Route::put('/categoria/estado/{id}', [CategoriaController::class, 'estado'])->name('categoria.estado');

Route::resource('/ventas', VentaController::class);
Route::get('/ventas/ticket/{id}', [VentaController::class, 'generarTicket'])->name('ventas.ticket');
Route::post('/ventas/anular/{id}', [VentaController::class, 'anular'])->name('ventas.anular');

Route::get('/home',[HomeController::class,'index'])->name('home.index');
Route::get('/ventas/exportar', [HomeController::class, 'exportarExcel'])->name('ventas.exportar');

Route::resource('personal', PersonalController::class);
Route::put('personal/{id}/estado', [PersonalController::class, 'estado'])->name('personal.estado');

Route::get('/lista', [ListaController::class,'index'])->name('lista.index');
Route::get('orders/export', [ListaController::class, 'export'])->name('orders.export');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
