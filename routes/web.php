<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\dashboardController;
use App\Http\Controllers\configuracionesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('prueba');
// });

Route::get('/', [dashboardController::class, 'index'])->name('dashboard.index');
Route::get('configuraciones', [configuracionesController::class, 'index'])->name('configuraciones.index');