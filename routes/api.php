<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{UsuarioController, ConversaoController, HistoricoConversaoController};


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

Route::post('/login', [UsuarioController::class, 'login']);

Route::group(['middleware' => 'api'], function($router) {
    Route::post('/logout',             [UsuarioController::class, 'logout']);
    Route::post('/conversao',          [ConversaoController::class, 'conversao']);
    Route::get('conversao/initialize', [ConversaoController::class, 'initialize']);
    Route::get('historico/initialize', [HistoricoConversaoController::class, 'initialize']);
    Route::get('usuario/initialize',   [UsuarioController::class, 'initialize']);
});

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
