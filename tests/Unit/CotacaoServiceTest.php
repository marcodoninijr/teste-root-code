<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CotacaoService;

class CotacaoServiceTest extends TestCase
{
    public function test_viagens_curtas_devem_cobrar_minimo_de_cinco_dias()
    {
        // 1. Prepara o cenário (Arrange)
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-02', // Apenas 2 dias de viagem
            'data_nascimento' => '1990-01-01', // 36 anos (multiplicador 1.0)
            'destino'         => 'NACIONAL',   // Tarifa 10.00/dia
            'bagagem'         => false,
        ];

        // 2. Executa a ação (Act)
        $resultado = $service->calcular($dados);

        // 3. Verifica se o resultado é o esperado (Assert)
        $this->assertEquals(5, $resultado['dias_cobrados']);
        $this->assertEquals(50.00, $resultado['valor_base']); // 5 dias * R$ 10,00
    }

    public function test_desconto_para_menores_de_idade()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-10', // 10 dias
            'data_nascimento' => '2015-01-01', // 11 anos (multiplicador 0.5)
            'destino'         => 'AMERICAS',   // Tarifa 16.00/dia
            'bagagem'         => false,
        ];

        $resultado = $service->calcular($dados);

        // Valor Base: 10 dias * R$ 16,00 = 160.00
        $this->assertEquals(160.00, $resultado['valor_base']);
        // Subtotal: 160.00 * 0.5 = 80.00
        $this->assertEquals(80.00, $resultado['subtotal']); 
    }

    public function test_acrescimo_para_idosos_com_bagagem()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-10', // 10 dias
            'data_nascimento' => '1950-01-01', // 76 anos (multiplicador 2.0)
            'destino'         => 'EUROPA',     // Tarifa 22.00/dia
            'bagagem'         => true,         // +3.00/dia
        ];

        $resultado = $service->calcular($dados);

        // Subtotal: (10 dias * R$ 22.00) * 2.0 = 440.00
        $this->assertEquals(440.00, $resultado['subtotal']);
        // Bagagem: 10 dias * R$ 3.00 = 30.00
        $this->assertEquals(30.00, $resultado['valor_bagagem']);
        // Total Final: 440.00 + 30.00 = 470.00
        $this->assertEquals(470.00, $resultado['total']);
    }
}