@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            
            <!-- Success Banner Top -->
            <div class="bg-success-subtle text-success text-center py-4 border-bottom border-success border-opacity-25">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-check-circle mb-2" viewBox="0 0 16 16">
                    <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                    <path d="M10.97 4.97a.235.235 0 0 0-.02.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-1.071-1.05z"/>
                </svg>
                <h4 class="mb-0 fw-bold">Cotação Gerada com Sucesso!</h4>
                <p class="mb-0 small text-success-emphasis mt-1">Cotação #{{ $cotacao->id }}</p>
            </div>

            <div class="card-body p-4 p-md-5">
                <!-- Trip Summary Section -->
                <h5 class="fw-bold text-dark mb-3">Resumo da Viagem</h5>
                <div class="row g-3 mb-5">
                    <div class="col-sm-6">
                        <div class="p-3 bg-light border rounded-3 h-100">
                            <span class="d-block text-muted small text-uppercase fw-semibold mb-1">Viajante</span>
                            <span class="fw-bold text-dark fs-6">{{ $cotacao->nome }}</span>
                            <span class="d-block text-secondary small">{{ $cotacao->idade }} anos de idade</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light border rounded-3 h-100">
                            <span class="d-block text-muted small text-uppercase fw-semibold mb-1">Destino</span>
                            <span class="fw-bold text-dark fs-6">{{ ucfirst(strtolower($cotacao->destino)) }}</span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light border rounded-3 h-100">
                            <span class="d-block text-muted small text-uppercase fw-semibold mb-1">Período <span class="badge bg-secondary ms-1">{{ $cotacao->dias_cobrados }} dias</span></span>
                            <span class="fw-bold text-dark fs-6">
                                {{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m') }} 
                                <span class="text-muted mx-1">&rarr;</span> 
                                {{ \Carbon\Carbon::parse($cotacao->data_fim)->format('d/m/Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="p-3 bg-light border rounded-3 h-100">
                            <span class="d-block text-muted small text-uppercase fw-semibold mb-2">Cobertura de Bagagem</span>
                            @if($cotacao->bagagem)
                                <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2">Incluída no plano</span>
                            @else
                                <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle px-3 py-2">Não incluída</span>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Financial Summary Section -->
                <h5 class="fw-bold text-dark mb-3">Resumo Financeiro</h5>
                <div class="card border border-2 rounded-4 shadow-sm mb-4">
                    <div class="card-body p-0">
                        <table class="table table-borderless align-middle mb-0">
                            <tbody class="text-secondary">
                                <tr class="border-bottom">
                                    <td class="ps-4 py-3 fw-medium">Valor Base</td>
                                    <td class="pe-4 py-3 text-end">R$ {{ number_format($cotacao->valor_base, 2, ',', '.') }}</td>
                                </tr>
                                <tr class="border-bottom">
                                    <td class="ps-4 py-3 fw-medium">
                                        Subtotal <br>
                                        <small class="text-muted fw-normal">(incluindo ajuste de risco por idade)</small>
                                    </td>
                                    <td class="pe-4 py-3 text-end">R$ {{ number_format($cotacao->subtotal, 2, ',', '.') }}</td>
                                </tr>
                                <tr>
                                    <td class="ps-4 py-3 fw-medium">Adicional de Bagagem</td>
                                    <td class="pe-4 py-3 text-end">R$ {{ number_format($cotacao->valor_bagagem, 2, ',', '.') }}</td>
                                </tr>
                            </tbody>
                            <tfoot class="bg-success-subtle border-top border-success border-opacity-25">
                                <tr>
                                    <th class="ps-4 py-4 fs-5 text-success-emphasis">Valor Total Estimado</th>
                                    <th class="pe-4 py-4 text-end fs-3 text-success fw-bolder">R$ {{ number_format($cotacao->total, 2, ',', '.') }}</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                <!-- Actions -->
                <div class="d-flex flex-column flex-sm-row gap-3 justify-content-center mt-5">
                    <a href="{{ route('cotacoes.create') }}" class="btn btn-primary btn-lg rounded-pill px-5 fw-bold shadow-sm">
                        Nova Cotação
                    </a>
                    <a href="{{ route('cotacoes.index') }}" class="btn btn-outline-secondary btn-lg rounded-pill px-5 fw-semibold transition-colors">
                        Ver Histórico
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection