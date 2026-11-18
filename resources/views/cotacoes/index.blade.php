@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-10">
        <!-- Header Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4 px-2">
            <div>
                <h4 class="mb-0 fw-bold text-primary">Histórico de Cotações</h4>
                <p class="text-muted small mb-0">Gerencie e visualize as cotações de seguro viagem geradas.</p>
            </div>
            <a href="{{ route('cotacoes.create') }}" class="btn btn-primary shadow-sm fw-semibold rounded-pill px-4">
                + Nova Cotação
            </a>
        </div>

        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="card-body p-0">
                @if($cotacoes->isEmpty())
                    <div class="text-center py-5">
                        <div class="text-muted mb-3">
                            <!-- Simple SVG Icon for Empty State -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor" class="bi bi-inbox text-secondary opacity-50" viewBox="0 0 16 16">
                                <path d="M4.98 4a.5.5 0 0 0-.39.188L1.54 8H6a.5.5 0 0 1 .5.5 1.5 1.5 0 1 0 3 0A.5.5 0 0 1 10 8h4.46l-3.05-3.812A.5.5 0 0 0 11.02 4H4.98zm-1.17-.437A1.5 1.5 0 0 1 4.98 3h6.04a1.5 1.5 0 0 1 1.17.563l3.7 4.625A.5.5 0 0 1 16 8.5V13a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V8.5a.5.5 0 0 1 .15-.312l3.7-4.625zM1 8.5V13a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V8.5H11A2.5 2.5 0 0 1 8.5 11 2.5 2.5 0 0 1 6 8.5H1z"/>
                            </svg>
                        </div>
                        <h5 class="text-dark fw-semibold">Nenhuma cotação encontrada</h5>
                        <p class="text-muted small mb-4">Você ainda não realizou nenhuma simulação de seguro viagem.</p>
                        <a href="{{ route('cotacoes.create') }}" class="btn btn-outline-primary rounded-pill px-4">Fazer primeira cotação</a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light text-secondary">
                                <tr>
                                    <th class="ps-4 fw-medium border-bottom-0">#</th>
                                    <th class="fw-medium border-bottom-0">Viajante</th>
                                    <th class="fw-medium border-bottom-0">Destino</th>
                                    <th class="fw-medium border-bottom-0">Período</th>
                                    <th class="fw-medium border-bottom-0">Total</th>
                                    <th class="pe-4 fw-medium border-bottom-0 text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody class="border-top-0">
                                @foreach($cotacoes as $cotacao)
                                <tr>
                                    <td class="ps-4 text-muted">#{{ $cotacao->id }}</td>
                                    <td class="fw-semibold text-dark">{{ $cotacao->nome }}</td>
                                    <td>
                                        @php
                                            $badgeColor = match($cotacao->destino) {
                                                'NACIONAL' => 'bg-success-subtle text-success',
                                                'AMERICAS' => 'bg-warning-subtle text-warning-emphasis',
                                                'EUROPA' => 'bg-info-subtle text-info-emphasis',
                                                default => 'bg-light text-dark'
                                            };
                                        @endphp
                                        <span class="badge {{ $badgeColor }} border rounded-pill px-3 py-2 fw-medium">
                                            {{ ucfirst(strtolower($cotacao->destino)) }}
                                        </span>
                                    </td>
                                    <td class="text-muted small">
                                        {{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m/Y') }} 
                                        <i class="bi bi-arrow-right mx-1"></i> 
                                        {{ \Carbon\Carbon::parse($cotacao->data_fim)->format('d/m/Y') }}
                                    </td>
                                    <td class="fw-bold text-success">
                                        R$ {{ number_format($cotacao->total, 2, ',', '.') }}
                                    </td>
                                    <td class="pe-4 text-end">
                                        <a href="{{ route('cotacoes.show', $cotacao->id) }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3 transition-colors">
                                            Ver detalhes
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
            
            @if($cotacoes->hasPages())
                <div class="card-footer bg-white border-top py-3 d-flex justify-content-center">
                    {{ $cotacoes->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection