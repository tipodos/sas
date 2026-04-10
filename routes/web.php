<?php

use App\Http\Controllers\ListaController;
use App\Http\Controllers\PersonalController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VentaController;
use App\Models\Venta;
use Illuminate\Support\Facades\Route;

Route::get('/producto', [ProductoController::class,'index'])->name('producto.index');
Route::post('/producto/store', [ProductoController::class,'store'])->name('producto.store');
Route::get('/producto/edit/{id}', [ProductoController::class,'edit'])->name('producto.edit');
Route::PUT('/producto/update/{id}',[ProductoController::class,'update'])->name('producto.update');
Route::delete('/producto/delete/{id}', [ProductoController::class,'delete'])->name('producto.delete');

Route::get('/categoria', [CategoriaController::class,'index'])->name('categoria.index');
Route::post('/categoria/store', [categoriaController::class,'store'])->name('categoria.store');
Route::get('/categoria/edit/{id}', [CategoriaController::class,'edit'])->name('categoria.edit');
Route::PUT('/categoria/update/{id}',[CategoriaController::class,'update'])->name('categoria.update');
Route::delete('/categoria/delete/{id}', [CategoriaController::class,'delete'])->name('categoria.delete');

Route::get('/personal', [PersonalController::class,'index'])->name('personal.index');
Route::post('/personal/store', [PersonalController::class,'store'])->name('personal.store');
Route::get('/personal/edit/{id}', [PersonalController::class,'edit'])->name('personal.edit');
Route::PUT('/personal/update/{id}',[PersonalController::class,'update'])->name('personal.update');
Route::delete('/personal/delete/{id}', [PersonalController::class,'delete'])->name('personal.delete');

Route::get('/lista', [ListaController::class,'index'])->name('lista.index');

Route::get('ventas',[VentaController::class,'index'])->name('ventas.index');
Route::post('/ventas/store', [VentaController::class,'store'])->name('ventas.store');
Route::get('/ventas/ticket/{id}', [VentaController::class, 'generarTicket'])->name('ventas.ticket');
Route::post('/ventas/anular/{id}', [VentaController::class, 'anular'])->name('ventas.anular');

Route::get('/home',[HomeController::class,'index'])->name('home.index');
Route::get('/ventas/exportar', [HomeController::class, 'exportarExcel'])->name('ventas.exportar');

Route::get('/', [PersonalController::class,'index'])->name('index');
Route::post('/store', [PersonalController::class,'store'])->name('store');
Route::get('/show/{id}', [PersonalController::class,'show'])->name('show');
Route::PUT('/update/{id}',[PersonalController::class,'update'])->name('update');
Route::delete('/delete/{id}', [PersonalController::class,'delete'])->name('delete');

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
