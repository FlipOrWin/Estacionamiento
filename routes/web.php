<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RegistroController;

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

//Route::get('/', function () {
//    return view('welcome');
//});

//Rutas controller registros
Route::get('/', [RegistroController::class, 'getRegistros'])->name('home');


Route::post('/guardar-registro', [RegistroController::class, 'saveRegistro'])->name('saveRegister');

Route::post('/marcar-salida/{id}', [RegistroController::class, 'marcarSalida'])->name('marcarSalida');

Route::post('/generar-pdf', [RegistroController::class, 'crearPdf']);
