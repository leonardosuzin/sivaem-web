<?php

use App\Http\Controllers\VagaController;
use illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CurriculoController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Controller;
use app\Http\Middleware\CheckUserType;




Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->post('logout', [AuthController::class, 'logout']);



Route::middleware('auth:sanctum')->group(function () {
  
        Route::get('/vagas', [VagaController::class, 'index']);
        Route::get('/curriculos', [CurriculoController::class, 'index']);
        Route::post('/curriculos', [CurriculoController::class, 'store']);
        Route::put('/curriculos/{id}', [CurriculoController::class, 'update']);
        Route::delete('/curriculos/{id}', [CurriculoController::class, 'destroy']);
        Route::get('/curriculos', [CurriculoController::class, 'index']);
        Route::get('/vagas', [VagaController::class, 'index']);
        Route::post('/vagas', [VagaController::class, 'store']);
        Route::put('/vagas/{id}', [VagaController::class, 'update']);
        Route::delete('/vagas/{id}', [VagaController::class, 'destroy']);
});

Route::get('/', function (Request $request){
    return $request -> user();
});

Route::post('/processar_vaga', [VagaController::class, 'inserir_vaga'])
;
