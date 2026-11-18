@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Histórico de Cotações</h4>
                <a href="{{ route('cotacoes.create') }}" class="btn btn-light btn-sm">
                    + Nova cotação
                </a>
            </div>
            <div class="card-body">
                @if($cotacoes->isEmpty())
                    <div class="text-center text-muted my-5">
                        <p class="mb-3">Nenhuma cotação encontrada ainda.</p>
                        <a href="{{ route('cotacoes.create') }}" class="btn btn-primary">
                            Fazer minha primeira cotação
                        </a>
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Viajante</th>
                                    <th scope="col">Destino</th>
                                    <th scope="col">Período</th>
                                    <th scope="col" class="text-end">Total</th>
                                    <th scope="col" class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotacoes as $cotacao)
                                    <tr>
                                        <td class="text-muted font-monospace small">
                                            {{ $cotacao->id }}
                                        </td>
                                        <td>{{ $cotacao->nome }}</td>
                                        <td>
                                            <span class="badge bg-secondary-subtle text-secondary-emphasis">
                                                {{ $cotacao->destino_label ?? ucfirst(strtolower($cotacao->destino)) }}
                                            </span>
                                        </td>
                                        <td class="text-nowrap">
                                            {{ $cotacao->data_inicio->format('d/m/Y') }}
                                            <span class="text-muted mx-1">→</span>
                                            {{ $cotacao->data_fim->format('d/m/Y') }}
                                        </td>
                                        <td class="text-end fw-semibold text-nowrap"
                                            style="font-variant-numeric: tabular-nums;">
                                            R$ {{ number_format($cotacao->total, 2, ',', '.') }}
                                        </td>
                                        <td class="text-end">
                                            <a href="{{ route('cotacoes.show', $cotacao) }}"
                                               class="btn btn-outline-primary btn-sm">
                                                Detalhes
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    @if($cotacoes->hasPages())
                        <div class="d-flex justify-content-center mt-3">
                            {{ $cotacoes->links() }}
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection