<?php

namespace App\Http\Controllers;

use App\Http\Requests\CotacaoRequest;
use App\Services\CotacaoService;
use App\Models\Cotacao; 

class CotacaoController extends Controller
{
    public function create()
    {
        return view('cotacoes.create');
    }

    public function store(CotacaoRequest $request, CotacaoService $service)
    {
        // Recebe os dados limpos do formulário
        $dadosValidados = $request->validated();
        
        // Chama o Service para fazer a matemática
        $calculo = $service->calcular($dadosValidados);
        
        // Junta os dados do formulário com os resultados da matemática
        $dadosCompletos = array_merge($dadosValidados, $calculo);
        
        // Guarda tudo na base de dados num único passo
        $cotacao = Cotacao::create($dadosCompletos);
        
        // Redireciona para a página de detalhes da cotação
        return redirect()->route('cotacoes.show', $cotacao->id);
    }

    // Método para exibir a cotação após o redirecionamento
    public function show($id)
    {
        // O findOrFail procura a cotação pelo ID ou devolve erro 404 se não existir
        $cotacao = Cotacao::findOrFail($id);
        
        return view('cotacoes.show', compact('cotacao'));
    }
}