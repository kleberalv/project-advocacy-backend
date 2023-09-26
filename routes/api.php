<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoPerfilController;
use App\Http\Controllers\ProcessoController;

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
        Route::resource('/users', UserController::class);
        Route::resource('/profiles', TipoPerfilController::class);
        Route::resource('/process', ProcessoController::class);
    });
    Route::get('/me', [AuthController::class, 'me']);
});
