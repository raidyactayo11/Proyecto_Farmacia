<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\configuracionesController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;

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
| CATEGORÍAS
|--------------------------------------------------------------------------
*/

Route::resource('categorias', CategoriaController::class)
    ->parameters(['categorias' => 'categoria'])
    ->except('show');

/*
|--------------------------------------------------------------------------
| MEDICAMENTOS
|--------------------------------------------------------------------------
*/

Route::resource('medicamentos', MedicamentoController::class)
    ->except('show');

/*
|--------------------------------------------------------------------------
| CLIENTES
|--------------------------------------------------------------------------
*/

Route::resource('clientes', ClienteController::class)
    ->except('show');

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
/*
|--------------------------------------------------------------------------
| REPORTES
|--------------------------------------------------------------------------
*/

Route::get('/reportes', [ReporteController::class, 'index'])
    ->name('reportes.index');