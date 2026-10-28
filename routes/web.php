<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CotacaoController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/cotacoes/nova', [CotacaoController::class, 'create'])->name('cotacoes.create');

Route::post('/cotacoes', [CotacaoController::class, 'store'])->name('cotacoes.store');