<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoPerfilController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

//Login e Logout
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

//Registrar
Route::post('/register', [UserController::class, 'store']);

//Atualizar
Route::post('/update', [UserController::class, 'update']);

//Buscar o própio usuário ou todos
Route::post('/me', [AuthController::class, 'me']);
Route::post('/allUsers', [UserController::class, 'allUsers']);

//Buscar tipos de perfis da plataforma
Route::get('/tiposPerfil', [TipoPerfilController::class, 'index']);