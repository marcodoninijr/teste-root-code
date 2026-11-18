@extends('layouts.app')

@section('content')
@php
    $temAjuste = (float) $cotacao->valor_base !== (float) $cotacao->subtotal;
@endphp
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-success text-white d-flex align-items-center">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                     class="me-2" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0m-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05"/>
                </svg>
                <h4 class="mb-0">Cotação gerada com sucesso</h4>
            </div>
            <div class="card-body">

                {{-- Resumo da Viagem --}}
                <h5 class="border-bottom pb-2">Resumo da viagem</h5>
                <dl class="row mb-0">
                    <dt class="col-sm-4 text-muted fw-normal">Viajante</dt>
                    <dd class="col-sm-8">{{ $cotacao->nome }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal">Idade na viagem</dt>
                    <dd class="col-sm-8">{{ $cotacao->idade }} anos</dd>

                    <dt class="col-sm-4 text-muted fw-normal">Destino</dt>
                    <dd class="col-sm-8">{{ $cotacao->destino_label ?? ucfirst(strtolower($cotacao->destino)) }}</dd>

                    <dt class="col-sm-4 text-muted fw-normal">Período</dt>
                    <dd class="col-sm-8">
                        {{ $cotacao->data_inicio->format('d/m/Y') }}
                        <span class="text-muted mx-1">→</span>
                        {{ $cotacao->data_fim->format('d/m/Y') }}
                    </dd>

                    <dt class="col-sm-4 text-muted fw-normal">Dias cobrados</dt>
                    <dd class="col-sm-8">{{ $cotacao->dias_cobrados }} dias</dd>

                    <dt class="col-sm-4 text-muted fw-normal">Cobertura de bagagem</dt>
                    <dd class="col-sm-8">
                        @if($cotacao->bagagem)
                            <span class="badge bg-success-subtle text-success-emphasis">Incluída</span>
                        @else
                            <span class="badge bg-secondary-subtle text-secondary-emphasis">Não incluída</span>
                        @endif
                    </dd>
                </dl>

                {{-- Resumo Financeiro --}}
                <h5 class="border-bottom pb-2 mt-4">Resumo financeiro</h5>
                <table class="table mb-0" style="font-variant-numeric: tabular-nums;">
                    <tbody>
                        <tr>
                            <td>Valor base</td>
                            <td class="text-end">R$ {{ number_format($cotacao->valor_base, 2, ',', '.') }}</td>
                        </tr>

                        @if($temAjuste)
                            <tr>
                                <td>
                                    Ajuste por idade
                                    <small class="text-muted d-block">Aplicado sobre o valor base</small>
                                </td>
                                <td class="text-end">
                                    R$ {{ number_format($cotacao->subtotal, 2, ',', '.') }}
                                </td>
                            </tr>
                        @endif

                        @if((float) $cotacao->valor_bagagem > 0)
                            <tr>
                                <td>Adicional de bagagem</td>
                                <td class="text-end">R$ {{ number_format($cotacao->valor_bagagem, 2, ',', '.') }}</td>
                            </tr>
                        @endif

                        <tr class="table-success border-top border-2">
                            <th class="fs-5">Valor total</th>
                            <th class="text-end fs-5">R$ {{ number_format($cotacao->total, 2, ',', '.') }}</th>
                        </tr>
                    </tbody>
                </table>

                @if($cotacao->created_at)
                    <p class="text-muted small mt-3 mb-0">
                        Cotação gerada em {{ $cotacao->created_at->format('d/m/Y \à\s H:i') }}.
                    </p>
                @endif

                <div class="d-flex flex-sm-row flex-column-reverse justify-content-between gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('cotacoes.index') }}" class="btn btn-outline-secondary">
                        ← Ver histórico
                    </a>
                    <a href="{{ route('cotacoes.create') }}" class="btn btn-primary">
                        Nova cotação
                    </a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection