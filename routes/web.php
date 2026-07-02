<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\dashboardController;
use App\Http\Controllers\configuracionesController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\MedicamentoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;

Auth::routes();

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - ADMINISTRADOR Y CAJERO
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador,Cajero'])->group(function () {
    Route::get('/cajero/dashboard', [dashboardController::class, 'cajero'])
        ->name('dashboard.cajero');

    Route::get('/ventas', [VentaController::class, 'index'])
        ->name('ventas.index');

    Route::post('/ventas', [VentaController::class, 'store'])
        ->name('ventas.store');
});

/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS - SOLO ADMINISTRADOR
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Administrador'])->group(function () {

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

    Route::delete('/ventas/{venta}', [VentaController::class, 'destroy'])
        ->name('ventas.destroy');

    /*
    |--------------------------------------------------------------------------
    | REPORTES
    |--------------------------------------------------------------------------
    */

    Route::get('/reportes', [ReporteController::class, 'index'])
        ->name('reportes.index');

    Route::get('/reportes/medicamentos/pdf', [ReporteController::class, 'medicamentosPdf'])
        ->name('reportes.medicamentos.pdf');

    Route::get('/reportes/ventas/pdf', [ReporteController::class, 'ventasPdf'])
        ->name('reportes.ventas.pdf');

    Route::get('/reportes/clientes/pdf', [ReporteController::class, 'clientesPdf'])
        ->name('reportes.clientes.pdf');

    Route::get('/reportes/medicamentos/excel', [ReporteController::class, 'medicamentosExcel'])
        ->name('reportes.medicamentos.excel');

    Route::get('/reportes/ventas/excel', [ReporteController::class, 'ventasExcel'])
        ->name('reportes.ventas.excel');

    Route::get('/reportes/clientes/excel', [ReporteController::class, 'clientesExcel'])
        ->name('reportes.clientes.excel');
});
