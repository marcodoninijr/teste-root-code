@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nova Cotação de Seguro Viagem</h4>
            </div>
            <div class="card-body">
                <p class="text-muted small mb-3">
                    Campos com <span class="text-danger" aria-hidden="true">*</span> são obrigatórios.
                </p>

                <form action="{{ route('cotacoes.store') }}" method="POST" id="cotacao-form">
                    @csrf

                    {{-- Nome do Viajante --}}
                    <div class="mb-3">
                        <label for="nome" class="form-label">
                            Nome do viajante <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="text"
                            name="nome"
                            id="nome"
                            class="form-control @error('nome') is-invalid @enderror"
                            value="{{ old('nome') }}"
                            autocomplete="name"
                            required
                        >
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Data de Nascimento --}}
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">
                            Data de nascimento <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <input
                            type="date"
                            name="data_nascimento"
                            id="data_nascimento"
                            class="form-control @error('data_nascimento') is-invalid @enderror"
                            value="{{ old('data_nascimento') }}"
                            max="{{ now()->toDateString() }}"
                            autocomplete="bday"
                            required
                        >
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Destino --}}
                    <div class="mb-3">
                        <label for="destino" class="form-label">
                            Destino <span class="text-danger" aria-hidden="true">*</span>
                        </label>
                        <select
                            name="destino"
                            id="destino"
                            class="form-select @error('destino') is-invalid @enderror"
                            required
                        >
                            <option value="" disabled {{ old('destino') ? '' : 'selected' }}>Selecione um destino...</option>
                            <option value="NACIONAL" @selected(old('destino') === 'NACIONAL')>Nacional (Brasil)</option>
                            <option value="AMERICAS" @selected(old('destino') === 'AMERICAS')>Américas</option>
                            <option value="EUROPA"   @selected(old('destino') === 'EUROPA')>Europa</option>
                        </select>
                        @error('destino') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Período da Viagem --}}
                    <fieldset class="mb-3">
                        <legend class="form-label fs-6 mb-2">
                            Período da viagem <span class="text-danger" aria-hidden="true">*</span>
                        </legend>
                        <div class="row g-2">
                            <div class="col-md-6">
                                <label for="data_inicio" class="form-label small text-muted">Início</label>
                                <input
                                    type="date"
                                    name="data_inicio"
                                    id="data_inicio"
                                    class="form-control @error('data_inicio') is-invalid @enderror"
                                    value="{{ old('data_inicio') }}"
                                    min="{{ now()->toDateString() }}"
                                    required
                                >
                                @error('data_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="data_fim" class="form-label small text-muted">Fim</label>
                                <input
                                    type="date"
                                    name="data_fim"
                                    id="data_fim"
                                    class="form-control @error('data_fim') is-invalid @enderror"
                                    value="{{ old('data_fim') }}"
                                    required
                                >
                                @error('data_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </fieldset>

                    {{-- Cobertura de Bagagem --}}
                    <div class="form-check mb-4">
                        <input
                            type="checkbox"
                            name="bagagem"
                            id="bagagem"
                            class="form-check-input"
                            value="1"
                            {{ old('bagagem') ? 'checked' : '' }}
                        >
                        <label class="form-check-label" for="bagagem">
                            Incluir cobertura de bagagem
                            <span class="text-muted small">(R$ 3,00 por dia)</span>
                        </label>
                    </div>

                    <div class="d-flex flex-sm-row flex-column-reverse justify-content-between align-items-sm-center gap-2">
                        <a href="{{ route('cotacoes.index') }}" class="btn btn-link text-muted px-0">
                            ← Ver histórico de cotações
                        </a>
                        <button type="submit" class="btn btn-primary px-4" id="submit-btn">
                            Calcular cotação
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
(function () {
    const inicio = document.getElementById('data_inicio');
    const fim    = document.getElementById('data_fim');
    const form   = document.getElementById('cotacao-form');
    const btn    = document.getElementById('submit-btn');

    // data_fim nunca antes de data_inicio
    function syncMin() {
        if (inicio.value) {
            fim.min = inicio.value;
            if (fim.value && fim.value < inicio.value) fim.value = inicio.value;
        } else {
            fim.removeAttribute('min');
        }
    }
    inicio.addEventListener('change', syncMin);
    syncMin();

    // loading state para evitar duplo submit
    form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Calculando...';
    });
})();
</script>
@endpush