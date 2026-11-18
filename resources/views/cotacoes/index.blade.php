@extends('layouts.app')

@section('content')
@php
    $destinoMeta = [
        'NACIONAL' => ['label' => 'Nacional', 'badge' => 'bg-success', 'flag' => '🇧🇷'],
        'AMERICAS' => ['label' => 'Américas', 'badge' => 'bg-info text-dark', 'flag' => '🌎'],
        'EUROPA'   => ['label' => 'Europa',   'badge' => 'bg-primary', 'flag' => '🇪🇺'],
    ];
@endphp
<div class="row justify-content-center">
    <div class="col-lg-10">

        {{-- Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
            <div>
                <h1 class="h3 mb-1">Histórico de cotações</h1>
                <p class="text-muted mb-0 small">
                    {{ $cotacoes->total() }} {{ $cotacoes->total() === 1 ? 'cotação gerada' : 'cotações geradas' }}
                </p>
            </div>
            <a href="{{ route('cotacoes.create') }}" class="btn btn-primary">
                + Nova cotação
            </a>
        </div>

        <div class="card border-0 shadow-sm">
            <div class="card-body p-3 p-md-4">

                @if($cotacoes->isEmpty())
                    <div class="text-center py-5">
                        <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-inline-flex align-items-center justify-content-center mb-3"
                             style="width: 64px; height: 64px;">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M4 0a2 2 0 0 0-2 2v13.5a.5.5 0 0 0 .74.439L8 13.069l5.26 2.87A.5.5 0 0 0 14 15.5V2a2 2 0 0 0-2-2zm5 3.5v3h3v1h-3v3H8v-3H5v-1h3v-3z"/>
                            </svg>
                        </div>
                        <h5 class="mb-1">Nenhuma cotação ainda</h5>
                        <p class="text-muted mb-3">Crie sua primeira cotação de seguro viagem.</p>
                        <a href="{{ route('cotacoes.create') }}" class="btn btn-primary">
                            Fazer minha primeira cotação
                        </a>
                    </div>
                @else
                    {{-- Search --}}
                    <div class="input-group mb-3">
                        <span class="input-group-text bg-white border-end-0">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </span>
                        <input type="text" id="filtro" class="form-control border-start-0"
                               placeholder="Buscar por nome ou destino...">
                    </div>

                    {{-- Table --}}
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0" id="cotacoes-table">
                            <thead class="text-muted small text-uppercase">
                                <tr>
                                    <th scope="col" class="fw-normal">Viajante</th>
                                    <th scope="col" class="fw-normal">Destino</th>
                                    <th scope="col" class="fw-normal">Período</th>
                                    <th scope="col" class="fw-normal text-end">Total</th>
                                    <th scope="col" class="text-end"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotacoes as $cotacao)
                                    @php
                                        $meta = $destinoMeta[$cotacao->destino] ?? ['label' => $cotacao->destino, 'badge' => 'bg-secondary', 'flag' => ''];
                                    @endphp
                                    <tr class="border-bottom">
                                        <td>
                                            <div class="d-flex align-items-center">
                                                <div class="rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center me-3 flex-shrink-0"
                                                     style="width: 40px; height: 40px; font-weight: 600;">
                                                    {{ mb_strtoupper(mb_substr($cotacao->nome, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="fw-semibold">{{ $cotacao->nome }}</div>
                                                    <div class="text-muted small">#{{ $cotacao->id }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <span class="badge {{ $meta['badge'] }}">
                                                {{ $meta['flag'] }} {{ $meta['label'] }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap small">
                                            {{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m/Y') }}
                                            <span class="text-muted">→</span>
                                            {{ \Carbon\Carbon::parse($cotacao->data_fim)->format('d/m/Y') }}
                                        </td>
                                        <td class="text-end fw-bold text-nowrap"
                                            style="font-variant-numeric: tabular-nums;">
                                            R$ {{ number_format($cotacao->total, 2, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('cotacoes.show', $cotacao->id) }}"
                                               class="btn btn-sm btn-light border">
                                                Detalhes →
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($cotacoes->hasPages())
                        <div class="d-flex justify-content-center mt-4">
                            {{ $cotacoes->links('pagination::bootstrap-5') }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

@if(! $cotacoes->isEmpty())
<script>
(function () {
    var filtro = document.getElementById('filtro');
    var linhas = document.querySelectorAll('#cotacoes-table tbody tr');
    filtro.addEventListener('input', function (e) {
        var q = e.target.value.toLowerCase().trim();
        linhas.forEach(function (tr) {
            tr.style.display = tr.textContent.toLowerCase().indexOf(q) !== -1 ? '' : 'none';
        });
    });
})();
</script>
@endif
@endsection