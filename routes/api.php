<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoPerfilController;

/*
|--------------------------------------------------------------------------
| API Rotas
|--------------------------------------------------------------------------
| Rota de login/logout
| Middleware->Autenticacao: Verifica se o token é valido
| Middleware->permissao: Verifica se o usuário em questão pode acessar as rotas de admin
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'autenticacao'], function () {
    Route::group(['middleware' => 'permissao'], function () {
        Route::get('/allUsers', [UserController::class, 'allUsers']);
        Route::get('/tiposPerfil', [TipoPerfilController::class, 'index']);
        Route::post('/register', [UserController::class, 'store']);
        Route::post('/update', [UserController::class, 'update']);
        Route::post('/delete', [UserController::class, 'delete']);
    });
    Route::get('/me', [AuthController::class, 'me']);
});
