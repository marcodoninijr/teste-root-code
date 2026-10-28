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

        // Calcular a idade exata na data de início da viagem
        $idade = $dataNascimento->diffInYears($dataInicio);

        // Definir o multiplicador com base na faixa etária
        $multiplicador = 1.0; // Padrão para 18 a 64 anos
        if ($idade <= 17) {
            $multiplicador = 0.5;
        } elseif ($idade >= 65) {
            $multiplicador = 2.0;
        }

        // Retorno temporário para ver os novos dados
        return [
            'dias_cobrados' => $diasCobrados,
            'idade' => $idade,
            'multiplicador' => $multiplicador,
        ];
    }
}