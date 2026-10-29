<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use App\Services\CotacaoService;

class CotacaoServiceTest extends TestCase
{
    public function test_viagens_curtas_devem_cobrar_minimo_de_cinco_dias()
    {
        // Prepara o cenário 
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-02', // Apenas 2 dias de viagem
            'data_nascimento' => '1990-01-01', // 36 anos (multiplicador 1.0)
            'destino'         => 'NACIONAL',   // Tarifa 10.00/dia
            'bagagem'         => false,
        ];

        // Executa a ação 
        $resultado = $service->calcular($dados);

        // Verifica se o resultado é o esperado
        $this->assertEquals(5, $resultado['dias_cobrados']);
        $this->assertEquals(50.00, $resultado['valor_base']); // 5 dias * R$ 10,00
    }

    public function test_idade_no_inicio_com_aniversario_durante_a_viagem_sem_bagagem()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-10', // 10 dias
            // A pessoa faz 18 anos no dia 05/10, ou seja, DURANTE a viagem.
            // No dia do embarque (01/10), ela ainda tem 17 anos.
            'data_nascimento' => '2008-10-05', 
            'destino'         => 'AMERICAS',   // Tarifa 16.00
            'bagagem'         => false,
        ];
        
        $resultado = $service->calcular($dados);
        
        $this->assertEquals(17, $resultado['idade']); // Confirma que fixou em 17 anos
        $this->assertEquals(160.00, $resultado['valor_base']); // 10 * 16
        $this->assertEquals(80.00, $resultado['subtotal']);    // 160 * 0.5 (desconto aplicado)
    }

    public function test_para_menores_de_idade_sem_bagagem()
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

    public function test_para_menores_de_idade_com_bagagem()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-10', // 10 dias
            'data_nascimento' => '2015-01-01', // 11 anos (multiplicador 0.5)
            'destino'         => 'AMERICAS',   // Tarifa 16.00/dia
            'bagagem'         => true,         // Com bagagem (+ R$ 3/dia)
        ];

        $resultado = $service->calcular($dados);

        // Valor Base: 10 dias * R$ 16,00 = 160.00
        $this->assertEquals(160.00, $resultado['valor_base']);
        // Subtotal: 160.00 * 0.5 = 80.00
        $this->assertEquals(80.00, $resultado['subtotal']); 
        // Bagagem: 10 dias * R$ 3,00 = 30.00
        $this->assertEquals(30.00, $resultado['valor_bagagem']);
        // Total Final: 80.00 + 30.00 = 110.00
        $this->assertEquals(110.00, $resultado['total']);
    }

    public function test_faixa_18_64_sem_bagagem()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-01-01',
            'data_fim'        => '2026-01-11', // 11 dias
            'data_nascimento' => '1990-01-01', // 36 anos (Multiplicador 1.0)
            'destino'         => 'EUROPA',     // Tarifa 22.00
            'bagagem'         => false,        // Sem bagagem
        ];
        
        $resultado = $service->calcular($dados);

        $this->assertEquals(11, $resultado['dias_cobrados']);
        $this->assertEquals(36, $resultado['idade']);
        $this->assertEquals(242.00, $resultado['total']); 
    }

    public function test_faixa_18_64_com_bagagem_exemplo_resolvido_no_pdf()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-01-01',
            'data_fim'        => '2026-01-11', // 11 dias
            'data_nascimento' => '1990-01-01', // 36 anos (Multiplicador 1.0)
            'destino'         => 'EUROPA',     // Tarifa 22.00
            'bagagem'         => true,         // Com bagagem (+ R$ 3/dia)
        ];
        
        $resultado = $service->calcular($dados);

        $this->assertEquals(11, $resultado['dias_cobrados']);
        $this->assertEquals(36, $resultado['idade']);
        $this->assertEquals(275.00, $resultado['total']); 
    }

    public function test_para_idosos_sem_bagagem()
    {
        $service = new CotacaoService();
        $dados = [
            'data_inicio'     => '2026-10-01',
            'data_fim'        => '2026-10-10', // 10 dias
            'data_nascimento' => '1950-01-01', // 76 anos (multiplicador 2.0)
            'destino'         => 'EUROPA',     // Tarifa 22.00/dia
            'bagagem'         => false,        // Sem bagagem
        ];

        $resultado = $service->calcular($dados);

        // Subtotal: (10 dias * R$ 22.00) * 2.0 = 440.00
        $this->assertEquals(440.00, $resultado['subtotal']);
        // Bagagem: 0.00
        // Total Final: 440.00 + 0.00 = 440.00
        $this->assertEquals(440.00, $resultado['total']);
    }

    public function test_para_idosos_com_bagagem()
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