<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CotacaoController extends Controller
{
    public function create()
    {
        return view('cotacoes.create');
    }

    public function store(Request $request)
    {
        // O dd() (dump and die) pausa a aplicação e imprime os dados na tela.
        // É ideal para testarmos se o HTML está enviando as informações corretamente.
        dd($request->all());
    }
}