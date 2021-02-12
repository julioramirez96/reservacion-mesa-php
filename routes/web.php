<?php

/*
    Nombre alumno: Julio Cesar Ramirez Hernandez
    Nombre profesor: Octavio Aguirre Lozano
    Materia: Computacion en el servidor web
    Actividad: Manejo de datos en el servidor e interacción con el cliente mediante una aplicación web
*/

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservacionController;
use App\Http\Controllers\MostrarReservacionController;

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

// Definimos las rutas de nuestra aplicacion apuntando a los controladores y metodos dependiendo el tipo de operacion http
Route::get('/reservacion', ReservacionController::class);
Route::get('/reservacion/{id}', [MostrarReservacionController::class, 'mostrar']);
Route::patch('/reservacion/{id}', [MostrarReservacionController::class, 'actualizar']);
Route::delete('/reservacion/{id}', [MostrarReservacionController::class, 'eliminar']);
Route::post('/reservacion', [ReservacionController::class, 'reservar']);
