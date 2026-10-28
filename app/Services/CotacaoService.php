<?php

namespace App\Services;

use Carbon\Carbon;

class CotacaoService
{
    /**
     * Recebe os dados validados do formulário e retorna os cálculos.
     */
    public function calcular(array $dados): array
    {
        // Transformar as strings de data em objetos Carbon
        $dataInicio = Carbon::parse($dados['data_inicio']);
        $dataFim = Carbon::parse($dados['data_fim']);

        // Calcular a diferença de dias e adicionar 1 (os dois dias contam)
        $diferenca = $dataInicio->diffInDays($dataFim);
        $diasCobrados = $diferenca + 1;

        // Aplicar a regra do mínimo de 5 dias
        if ($diasCobrados < 5) {
            $diasCobrados = 5;
        }

        // Retorno temporário para vermos se está a funcionar
        return [
            'dias_cobrados' => $diasCobrados,
        ];
    }
}