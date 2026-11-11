@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h4 class="mb-0">Histórico de Cotações</h4>
                <a href="{{ route('cotacoes.create') }}" class="btn btn-light btn-sm">Nova Cotação</a>
            </div>
            <div class="card-body">
                @if($cotacoes->isEmpty())
                    <p class="text-center text-muted my-4">Nenhuma cotação encontrada.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>#</th>
                                    <th>Viajante</th>
                                    <th>Destino</th>
                                    <th>Período</th>
                                    <th>Total</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cotacoes as $cotacao)
                                <tr>
                                    <td>{{ $cotacao->id }}</td>
                                    <td>{{ $cotacao->nome }}</td>
                                    <td>{{ $cotacao->destino }}</td>
                                    <td>{{ \Carbon\Carbon::parse($cotacao->data_inicio)->format('d/m/Y') }}</td>
                                    <td>R$ {{ number_format($cotacao->total, 2, ',', '.') }}</td>
                                    <td>
                                        <a href="{{ route('cotacoes.show', $cotacao->id) }}" class="btn btn-outline-info btn-sm">Detalhes</a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- Renderiza os botões de paginação -->
                    <div class="d-flex justify-content-center mt-3">
                        {{ $cotacoes->links('pagination::bootstrap-5') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection