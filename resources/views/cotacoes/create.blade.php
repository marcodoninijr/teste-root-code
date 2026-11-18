@extends('layouts.app')

@section('content')
<div class="row justify-content-center py-4">
    <div class="col-lg-8 col-md-10">
        <div class="card shadow border-0 rounded-4">
            <div class="card-header bg-white border-bottom-0 pt-4 pb-0 px-4">
                <h4 class="mb-0 fw-bold text-primary">Nova Cotação de Seguro Viagem</h4>
                <p class="text-muted small mt-1">Preencha os dados abaixo para calcular o valor do seu seguro.</p>
            </div>
            <div class="card-body p-4">
                <form action="{{ route('cotacoes.store') }}" method="POST">
                    @csrf

                    <!-- Nome do Viajante -->
                    <div class="form-floating mb-4">
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}" placeholder="Nome completo">
                        <label for="nome">Nome do viajante *</label>
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="row mb-4">
                        <!-- Data de Nascimento -->
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="form-floating">
                                <input type="date" name="data_nascimento" id="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror" value="{{ old('data_nascimento') }}">
                                <label for="data_nascimento">Data de nascimento *</label>
                                @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <!-- Destino -->
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select name="destino" id="destino" class="form-select @error('destino') is-invalid @enderror">
                                    <option value="" disabled {{ old('destino') ? '' : 'selected' }}>Selecione um destino...</option>
                                    <option value="NACIONAL" {{ old('destino') == 'NACIONAL' ? 'selected' : '' }}>Nacional</option>
                                    <option value="AMERICAS" {{ old('destino') == 'AMERICAS' ? 'selected' : '' }}>Américas</option>
                                    <option value="EUROPA" {{ old('destino') == 'EUROPA' ? 'selected' : '' }}>Europa</option>
                                </select>
                                <label for="destino">Destino *</label>
                                @error('destino') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Período da Viagem -->
                    <div class="row mb-4">
                        <div class="col-md-6 mb-4 mb-md-0">
                            <div class="form-floating">
                                <input type="date" name="data_inicio" id="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror" value="{{ old('data_inicio') }}">
                                <label for="data_inicio">Data de início *</label>
                                @error('data_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" name="data_fim" id="data_fim" class="form-control @error('data_fim') is-invalid @enderror" value="{{ old('data_fim') }}">
                                <label for="data_fim">Data de fim *</label>
                                @error('data_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Cobertura de Bagagem -->
                    <div class="card bg-light border-0 rounded-3 mb-4">
                        <div class="card-body py-3 px-4">
                            <div class="form-check form-switch fs-5">
                                <input class="form-check-input" type="checkbox" role="switch" name="bagagem" id="bagagem" value="1" {{ old('bagagem') ? 'checked' : '' }}>
                                <label class="form-check-label ms-2 fs-6 text-dark" for="bagagem">
                                    Incluir cobertura de bagagem extra
                                    <span class="d-block text-muted small" style="font-size: 0.85rem;">+ R$ 3,00 por dia</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100 py-3 fw-bold rounded-3 shadow-sm">
                        Calcular Cotação
                    </button>
                </form>
                
                <div class="mt-4 text-center">
                    <a href="{{ route('cotacoes.index') }}" class="text-decoration-none text-secondary fw-semibold">
                        &larr; Voltar para o histórico
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection