<?php

namespace App\Services;

use Carbon\Carbon;

class CotacaoService
{
    public function calcular(array $dados): array
    {
        // Transformar as strings de data em objetos Carbon
        $dataInicio = Carbon::parse($dados['data_inicio']);
        $dataFim = Carbon::parse($dados['data_fim']);
        $dataNascimento = Carbon::parse($dados['data_nascimento']);

        // Calcular dias cobrados (mínimo de 5 dias)
        $diferenca = $dataInicio->diffInDays($dataFim);
        $diasCobrados = $diferenca + 1;
        if ($diasCobrados < 5) {
            $diasCobrados = 5;
        }

        // Calcular idade exata na data de início da viagem e definir multiplicador
        $idade = (int) $dataNascimento->diffInYears($dataInicio);
        
        $multiplicador = 1.0; // Padrão para 18 a 64 anos
        if ($idade <= 17) {
            $multiplicador = 0.5;
        } elseif ($idade >= 65) {
            $multiplicador = 2.0;
        }

        // Dicionário que define a tarifa diária com base no destino
        $tarifas = [
            'NACIONAL' => 10.00,
            'AMERICAS' => 16.00,
            'EUROPA'   => 22.00,
        ];
        $tarifaDiaria = $tarifas[$dados['destino']]; 

        // Executar os cálculos financeiros (Ordem de cálculo)
        $valorBase = $tarifaDiaria * $diasCobrados;
        $subtotal = $valorBase * $multiplicador;
        
        // Verifica se a checkbox da bagagem foi marcada
        $temBagagem = isset($dados['bagagem']) && $dados['bagagem'];
        $valorBagagem = $temBagagem ? (3.00 * $diasCobrados) : 0.00;

        $total = $subtotal + $valorBagagem;

        // Devolver todos os dados que precisam de ser guardados na base de dados
        return [
            'dias_cobrados' => $diasCobrados,
            'idade'         => $idade,
            'valor_base'    => $valorBase,
            'subtotal'      => $subtotal,
            'valor_bagagem' => $valorBagagem,
            'total'         => round($total, 2), // Arredondamento de duas casas decimais
        ];
    }
}