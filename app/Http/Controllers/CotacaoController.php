<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotacaoRequest;

class CotacaoController extends Controller
{
    public function create()
    {
        return view('cotacoes.create');
    }

    public function store(CotacaoRequest $request)
    {
        // O método validated() devolve apenas os dados que passaram nas regras.
        $dadosValidados = $request->validated();
        
        dd($dadosValidados);
    }
}