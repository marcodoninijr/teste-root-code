<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotacaoRequest;
use App\Services\CotacaoService;

class CotacaoController extends Controller
{
    public function create()
    {
        return view('cotacoes.create');
    }

    public function store(CotacaoRequest $request, CotacaoService $service)
    {
        $dadosValidados = $request->validated();
        
        // Passa os dados para o Service fazer a matemática
        $calculo = $service->calcular($dadosValidados);
        
        dd($calculo);
    }
}