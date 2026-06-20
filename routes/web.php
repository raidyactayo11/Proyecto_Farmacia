<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\configuracionesController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;

/*
|--------------------------------------------------------------------------
| DASHBOARD
|--------------------------------------------------------------------------
*/

Route::get('/', [dashboardController::class, 'index'])
    ->name('dashboard.index');

/*
|--------------------------------------------------------------------------
| CONFIGURACIONES
|--------------------------------------------------------------------------
*/

Route::get('/configuraciones', [configuracionesController::class, 'index'])
    ->name('configuraciones.index');

/*
|--------------------------------------------------------------------------
| MEDICAMENTOS
|--------------------------------------------------------------------------
*/

Route::get('/medicamentos', [MedicamentoController::class, 'index'])
    ->name('medicamentos.index');

Route::post('/medicamentos', [MedicamentoController::class, 'store'])
    ->name('medicamentos.store');

Route::get('/medicamentos/{medicamento}/edit', [MedicamentoController::class, 'edit'])
    ->name('medicamentos.edit');

Route::put('/medicamentos/{medicamento}', [MedicamentoController::class, 'update'])
    ->name('medicamentos.update');

Route::delete('/medicamentos/{medicamento}', [MedicamentoController::class, 'destroy'])
    ->name('medicamentos.destroy');

/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/

Route::get('/clientes', [ClienteController::class, 'index'])
    ->name('clientes.index');

Route::post('/clientes', [ClienteController::class, 'store'])
    ->name('clientes.store');

Route::put('/clientes/{cliente}', [ClienteController::class, 'update'])
    ->name('clientes.update');

Route::delete('/clientes/{cliente}', [ClienteController::class, 'destroy'])
    ->name('clientes.destroy');

/*
|--------------------------------------------------------------------------
| VENTAS
|--------------------------------------------------------------------------
*/

Route::get('/ventas', [VentaController::class, 'index'])
    ->name('ventas.index');

Route::post('/ventas', [VentaController::class, 'store'])
    ->name('ventas.store');

Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])
    ->name('ventas.destroy');