@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white">
                <h4 class="mb-0">Cotação Gerada com Sucesso!</h4>
            </div>
            <div class="card-body">
                <h5 class="border-bottom pb-2">Resumo da Viagem</h5>
                <p><strong>Viajante:</strong> {{ $cotacao->nome }} ({{ $cotacao->idade }} anos na viagem)</p>
                <p><strong>Destino:</strong> {{ $cotacao->destino }}</p>
                <p><strong>Período:</strong> {{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($cotacao->data_fim)->format('d/m/Y') }}</p>
                <p><strong>Dias Cobrados:</strong> {{ $cotacao->dias_cobrados }} dias</p>
                <p><strong>Cobertura de Bagagem:</strong> {{ $cotacao->bagagem ? 'Incluída' : 'Não incluída' }}</p>

                <h5 class="border-bottom pb-2 mt-4">Resumo Financeiro</h5>
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Valor Base:</td>
                            <td class="text-end">R$ {{ number_format($cotacao->valor_base, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Subtotal (com ajuste de idade):</td>
                            <td class="text-end">R$ {{ number_format($cotacao->subtotal, 2, ',', '.') }}</td>
                        </tr>
                        <tr>
                            <td>Adicional de Bagagem:</td>
                            <td class="text-end">R$ {{ number_format($cotacao->valor_bagagem, 2, ',', '.') }}</td>
                        </tr>
                        <tr class="table-success">
                            <th>Valor Total:</th>
                            <th class="text-end">R$ {{ number_format($cotacao->total, 2, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>

                <div class="mt-4 text-center">
                    <a href="{{ route('cotacoes.create') }}" class="btn btn-outline-primary">Nova Cotação</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection