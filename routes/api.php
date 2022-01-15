<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AlumnosController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/Alumnos', [AlumnosController::class, 'index']);
Route::post('/CrearAlumno', [AlumnosController::class, 'store']);
Route::get('/MostrarAlumno', [AlumnosController::class, 'show']);
Route::put('/EditarAlumno', [AlumnosController::class, 'update']);
Route::delete('/EliminarAlumno', [AlumnosController::class, 'destroy']);
