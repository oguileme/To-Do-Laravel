<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


Route::middleware('auth:api')->group(function () {
    Route::resource('projetos', \App\Http\Controllers\ProjetoController::class);
    Route::resource('tarefas', \App\Http\Controllers\TarefaController::class);
    Route::get('profile', [\App\Http\Controllers\AuthController::class, 'profile']);
});


Route::post('/register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('/login', [\App\Http\Controllers\AuthController::class, 'login']);

