<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\CotacaoController;

Route::get('/', function () {
        return redirect()->route('cotacoes.create');
});

Route::get('/cotacoes/nova', [CotacaoController::class, 'create'])->name('cotacoes.create');

Route::post('/cotacoes', [CotacaoController::class, 'store'])->name('cotacoes.store');

Route::get('/cotacoes/{id}', [CotacaoController::class, 'show'])->name('cotacoes.show');

Route::get('/cotacoes', [CotacaoController::class, 'index'])->name('cotacoes.index');