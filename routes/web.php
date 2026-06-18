<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\configuracionesController;
use App\Http\Controllers\ProductoController;

Route::get('/', [dashboardController::class, 'index'])->name('dashboard.index');

Route::get('configuraciones', [configuracionesController::class, 'index'])
    ->name('configuraciones.index');

/*
|---------------------------------
| PRODUCTOS (CRUD)
|---------------------------------
*/
Route::get('productos', [ProductoController::class, 'index'])
    ->name('productos.index');

Route::post('productos', [ProductoController::class, 'store'])
    ->name('productos.store');

Route::get('productos/{producto}/edit', [ProductoController::class, 'edit'])
    ->name('productos.edit');

Route::put('productos/{producto}', [ProductoController::class, 'update'])
    ->name('productos.update');

Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])
    ->name('productos.destroy');