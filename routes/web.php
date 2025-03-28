<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PartidaController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/teste', function () {
    return view('teste');
});


Route::get('partida/{date}', [PartidaController::class, 'get']);

Route::get('/jogos/busca/{params}', [PartidaController::class, 'buscarJogos']);

Route::get('/jogos/previsao/{id}', [PartidaController::class, 'getPrevisao']);

