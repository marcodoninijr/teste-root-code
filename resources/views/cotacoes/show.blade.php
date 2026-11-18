@extends('layouts.app')

@section('content')
@php
    $destinoLabels = [
        'NACIONAL' => 'Nacional (Brasil)',
        'AMERICAS' => 'Américas',
        'EUROPA'   => 'Europa',
    ];
    $destinoLabel = $destinoLabels[$cotacao->destino] ?? $cotacao->destino;
    $temAjuste    = (float) $cotacao->valor_base !== (float) $cotacao->subtotal;
    $temBagagem   = (float) $cotacao->valor_bagagem > 0;
@endphp

{{-- Hero --}}
<div class="row justify-content-center mb-4">
    <div class="col-lg-10">
        <div class="card border-0 shadow-sm overflow-hidden"
             style="background: linear-gradient(135deg, #198754 0%, #146c43 100%);">
            <div class="card-body p-4 p-md-5 text-white">
                <div class="row align-items-center g-3">
                    <div class="col-md-8">
                        <div class="d-inline-flex align-items-center mb-2">
                            <span class="badge bg-white text-success me-2">
                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="currentColor" viewBox="0 0 16 16" class="me-1">
                                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05"/>
                                </svg>
                                Cotação gerada
                            </span>
                            <span class="text-white-50 small">#{{ $cotacao->id }}</span>
                        </div>
                        <div class="text-uppercase small opacity-75 mb-1">Valor total do seguro</div>
                        <div class="display-4 fw-bold lh-1 mb-2"
                             style="font-variant-numeric: tabular-nums;">
                            R$ {{ number_format($cotacao->total, 2, ',', '.') }}
                        </div>
                        <div class="opacity-75">
                            {{ $cotacao->dias_cobrados }} {{ $cotacao->dias_cobrados === 1 ? 'dia' : 'dias' }}
                            · {{ $destinoLabel }}
                        </div>
                    </div>
                    <div class="col-md-4 text-md-end">
                        <a href="{{ route('cotacoes.create') }}" class="btn btn-light">
                            Nova cotação
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center g-4">
    {{-- Main column --}}
    <div class="col-lg-7">

        {{-- Trip timeline --}}
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body p-4">
                <h6 class="text-uppercase text-muted small fw-semibold mb-4">Período da viagem</h6>

                <div class="d-flex align-items-center">
                    <div class="text-center flex-shrink-0">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2 mx-auto"
                             style="width: 44px; height: 44px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849"/>
                            </svg>
                        </div>
                        <div class="fw-semibold small">
                            {{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m/Y') }}
                        </div>
                        <div class="text-muted small">Início</div>
                    </div>

                    <div class="flex-grow-1 mx-3">
                        <div class="position-relative">
                            <hr class="m-0 border-primary border-2 opacity-50">
                            <div class="text-center" style="margin-top: -12px;">
                                <span class="badge bg-primary">{{ $cotacao->dias_cobrados }} dias</span>
                            </div>
                        </div>
                    </div>

                    <div class="text-center flex-shrink-0">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center mb-2 mx-auto"
                             style="width: 44px; height: 44px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849"/>
                            </svg>
                        </div>
                        <div class="fw-semibold small">
                            {{ \Carbon\Carbon::parse($cotacao->data_fim)->format('d/m/Y') }}
                        </div>
                        <div class="text-muted small">Fim</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Financial --}}
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4">
                <h6 class="text-uppercase text-muted small fw-semibold mb-4">Resumo financeiro</h6>

                <div class="d-flex justify-content-between py-2 border-bottom">
                    <span class="text-muted">Valor base</span>
                    <span style="font-variant-numeric: tabular-nums;">
                        R$ {{ number_format($cotacao->valor_base, 2, ',', '.') }}
                    </span>
                </div>

                @if($temAjuste)
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <div>
                            <div>Ajuste por idade</div>
                            <small class="text-muted">Aplicado sobre o valor base</small>
                        </div>
                        <span style="font-variant-numeric: tabular-nums;">
                            R$ {{ number_format($cotacao->subtotal, 2, ',', '.') }}
                        </span>
                    </div>
                @endif

                @if($temBagagem)
                    <div class="d-flex justify-content-between py-2 border-bottom">
                        <span>Adicional de bagagem</span>
                        <span style="font-variant-numeric: tabular-nums;">
                            R$ {{ number_format($cotacao->valor_bagagem, 2, ',', '.') }}
                        </span>
                    </div>
                @endif

                <div class="d-flex justify-content-between align-items-center mt-3 p-3 rounded-3 bg-success bg-opacity-10">
                    <span class="fw-semibold text-success-emphasis">Valor total</span>
                    <span class="fs-4 fw-bold text-success-emphasis" style="font-variant-numeric: tabular-nums;">
                        R$ {{ number_format($cotacao->total, 2, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-3">
        <div class="sticky-lg-top" style="top: 1rem;">
            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Viajante</h6>
                    <div class="d-flex align-items-center">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                             style="width: 48px; height: 48px; font-weight: 600;">
                            {{ mb_strtoupper(mb_substr($cotacao->nome, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-semibold">{{ $cotacao->nome }}</div>
                            <div class="text-muted small">{{ $cotacao->idade }} anos</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-3">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Bagagem</h6>
                    @if($cotacao->bagagem)
                        <span class="badge bg-success">✓ Incluída</span>
                    @else
                        <span class="badge bg-secondary">Não incluída</span>
                    @endif
                </div>
            </div>

            <div class="d-grid gap-2">
                <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
                    Imprimir cotação
                </button>
                <a href="{{ route('cotacoes.index') }}" class="btn btn-light border">
                    ← Ver histórico
                </a>
            </div>

            @if($cotacao->created_at)
                <p class="text-muted small text-center mt-3 mb-0">
                    Gerada em {{ $cotacao->created_at->format('d/m/Y \à\s H:i') }}
                </p>
            @endif
        </div>
    </div>
</div>

<style media="print">
    .btn, .sticky-lg-top, .no-print { display: none !important; }
    body { background: #fff !important; }
    .card { box-shadow: none !important; border: 1px solid #dee2e6 !important; break-inside: avoid; }
    .row > [class*="col-"] { max-width: 100% !important; flex: 0 0 100% !important; }
</style>
@endsection