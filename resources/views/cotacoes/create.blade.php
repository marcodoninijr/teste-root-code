@extends('layouts.app')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">Nova Cotação de Seguro Viagem</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('cotacoes.store') }}" method="POST">
                    @csrf

                    <!-- Nome do Viajante -->
                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome do viajante *</label>
                        <input type="text" name="nome" id="nome" class="form-control @error('nome') is-invalid @enderror" value="{{ old('nome') }}">
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Data de Nascimento -->
                    <div class="mb-3">
                        <label for="data_nascimento" class="form-label">Data de nascimento *</label>
                        <input type="date" name="data_nascimento" id="data_nascimento" class="form-control @error('data_nascimento') is-invalid @enderror" value="{{ old('data_nascimento') }}">
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Destino -->
                    <div class="mb-3">
                        <label for="destino" class="form-label">Destino *</label>
                        <select name="destino" id="destino" class="form-select @error('destino') is-invalid @enderror">
                            <option value="">Selecione um destino...</option>
                            <option value="NACIONAL" {{ old('destino') == 'NACIONAL' ? 'selected' : '' }}>NACIONAL</option>
                            <option value="AMERICAS" {{ old('destino') == 'AMERICAS' ? 'selected' : '' }}>AMERICAS</option>
                            <option value="EUROPA" {{ old('destino') == 'EUROPA' ? 'selected' : '' }}>EUROPA</option>
                        </select>
                        @error('destino') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <!-- Período da Viagem -->
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="data_inicio" class="form-label">Data de início *</label>
                            <input type="date" name="data_inicio" id="data_inicio" class="form-control @error('data_inicio') is-invalid @enderror" value="{{ old('data_inicio') }}">
                            @error('data_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="data_fim" class="form-label">Data de fim *</label>
                            <input type="date" name="data_fim" id="data_fim" class="form-control @error('data_fim') is-invalid @enderror" value="{{ old('data_fim') }}">
                            @error('data_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    <!-- Cobertura de Bagagem -->
                    <div class="form-check mb-4">
                        <input type="checkbox" name="bagagem" id="bagagem" class="form-check-input" value="1" {{ old('bagagem') ? 'checked' : '' }}>
                        <label class="form-check-label" for="bagagem">
                            Incluir cobertura de bagagem (R$ 3,00 por dia)
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Calcular Cotação</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection