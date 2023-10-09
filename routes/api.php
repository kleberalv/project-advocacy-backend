<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TipoPerfilController;
use App\Http\Controllers\ProcessoController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\SexoController;

/*
|--------------------------------------------------------------------------
| API Rotas
|--------------------------------------------------------------------------
| Rota de login/logout
| Middleware->Autenticacao: Verifica se o token é valido
| Middleware->permissao: Verifica se o usuário em questão tem permissão de acesso a determinada funcionalidade
|
*/

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::group(['middleware' => 'autenticacao'], function () {
    Route::group(['middleware' => 'permissao'], function () {
        Route::resource('/users', UserController::class);
        Route::resource('/profiles', TipoPerfilController::class);
        Route::resource('/process', ProcessoController::class);
        Route::resource('/status', StatusController::class);
        Route::resource('/sexos', SexoController::class);
        Route::get('/me', [AuthController::class, 'me'])->name('me.index');
        Route::put('/updateMe', [UserController::class, 'update'])->name('me.update');
        Route::get('/lawyer', [UserController::class, 'indexLawyer'])->name('lawyer.index');
        Route::get('/client', [UserController::class, 'indexClient'])->name('client.index');
    });
});
