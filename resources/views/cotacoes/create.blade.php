@extends('layouts.app')

@section('content')
<div class="row justify-content-center g-4">
    {{-- Form --}}
    <div class="col-lg-7">
        <div class="card border-0 shadow-sm">
            <div class="card-body p-4 p-md-5">

                <div class="mb-4">
                    <h1 class="h3 mb-1">Nova cotação</h1>
                    <p class="text-muted mb-0">Seguro viagem em poucos segundos.</p>
                </div>

                <form action="{{ route('cotacoes.store') }}" method="POST" id="cotacao-form">
                    @csrf

                    {{-- Dados do viajante --}}
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Dados do viajante</h6>

                    <div class="mb-3">
                        <label for="nome" class="form-label">Nome completo *</label>
                        <input type="text"
                               name="nome" id="nome"
                               class="form-control form-control-lg @error('nome') is-invalid @enderror"
                               value="{{ old('nome') }}"
                               autocomplete="name"
                               placeholder="Ex.: Maria Silva"
                               required>
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <div class="mb-4">
                        <label for="data_nascimento" class="form-label">Data de nascimento *</label>
                        <input type="date"
                               name="data_nascimento" id="data_nascimento"
                               class="form-control form-control-lg @error('data_nascimento') is-invalid @enderror"
                               value="{{ old('data_nascimento') }}"
                               max="{{ now()->toDateString() }}"
                               autocomplete="bday"
                               required>
                        @error('data_nascimento') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    {{-- Destino --}}
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Destino *</h6>
                    <div class="row g-2 mb-2">
                        <div class="col-4">
                            <input type="radio" class="btn-check" name="destino" id="destino-NACIONAL"
                                   value="NACIONAL" required
                                   {{ old('destino') === 'NACIONAL' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary w-100 py-3 h-100" for="destino-NACIONAL">
                                <div class="fs-3 mb-1">🇧🇷</div>
                                <div class="fw-semibold small">Nacional</div>
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="radio" class="btn-check" name="destino" id="destino-AMERICAS"
                                   value="AMERICAS"
                                   {{ old('destino') === 'AMERICAS' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary w-100 py-3 h-100" for="destino-AMERICAS">
                                <div class="fs-3 mb-1">🌎</div>
                                <div class="fw-semibold small">Américas</div>
                            </label>
                        </div>
                        <div class="col-4">
                            <input type="radio" class="btn-check" name="destino" id="destino-EUROPA"
                                   value="EUROPA"
                                   {{ old('destino') === 'EUROPA' ? 'checked' : '' }}>
                            <label class="btn btn-outline-primary w-100 py-3 h-100" for="destino-EUROPA">
                                <div class="fs-3 mb-1">🇪🇺</div>
                                <div class="fw-semibold small">Europa</div>
                            </label>
                        </div>
                    </div>
                    @error('destino') <div class="text-danger small mb-3">{{ $message }}</div> @enderror

                    {{-- Período --}}
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3 mt-4">Período da viagem</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-sm-6">
                            <label for="data_inicio" class="form-label">Início *</label>
                            <input type="date"
                                   name="data_inicio" id="data_inicio"
                                   class="form-control form-control-lg @error('data_inicio') is-invalid @enderror"
                                   value="{{ old('data_inicio') }}"
                                   min="{{ now()->toDateString() }}"
                                   required>
                            @error('data_inicio') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="col-sm-6">
                            <label for="data_fim" class="form-label">Fim *</label>
                            <input type="date"
                                   name="data_fim" id="data_fim"
                                   class="form-control form-control-lg @error('data_fim') is-invalid @enderror"
                                   value="{{ old('data_fim') }}"
                                   required>
                            @error('data_fim') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>

                    {{-- Extras --}}
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Extras</h6>
                    <div class="form-check form-switch p-3 ps-5 bg-light rounded-3 mb-4">
                        <input type="checkbox" class="form-check-input" role="switch"
                               name="bagagem" id="bagagem" value="1"
                               {{ old('bagagem') ? 'checked' : '' }}>
                        <label class="form-check-label fw-semibold" for="bagagem">
                            Cobertura de bagagem
                            <span class="text-muted small d-block fw-normal">+ R$ 3,00 por dia</span>
                        </label>
                    </div>

                    <button type="submit" class="btn btn-primary btn-lg w-100" id="submit-btn">
                        Calcular cotação
                    </button>

                    <div class="text-center mt-3">
                        <a href="{{ route('cotacoes.index') }}" class="text-decoration-none small text-muted">
                            ← Ver histórico de cotações
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Sidebar --}}
    <div class="col-lg-5">
        <div class="sticky-lg-top" style="top: 1rem;">

            <div class="card border-0 bg-primary text-white mb-3">
                <div class="card-body p-4">
                    <h5 class="mb-3">Como funciona</h5>
                    <ol class="list-unstyled mb-0 small">
                        <li class="d-flex mb-3">
                            <span class="badge bg-white text-primary rounded-circle me-2 flex-shrink-0 d-flex align-items-center justify-content-center"
                                  style="width: 24px; height: 24px;">1</span>
                            <span>Preencha os dados do viajante</span>
                        </li>
                        <li class="d-flex mb-3">
                            <span class="badge bg-white text-primary rounded-circle me-2 flex-shrink-0 d-flex align-items-center justify-content-center"
                                  style="width: 24px; height: 24px;">2</span>
                            <span>Escolha destino e datas</span>
                        </li>
                        <li class="d-flex">
                            <span class="badge bg-white text-primary rounded-circle me-2 flex-shrink-0 d-flex align-items-center justify-content-center"
                                  style="width: 24px; height: 24px;">3</span>
                            <span>Receba o valor na hora</span>
                        </li>
                    </ol>
                </div>
            </div>

            <div class="card border-0 bg-light">
                <div class="card-body p-4">
                    <h6 class="text-uppercase text-muted small fw-semibold mb-3">Destinos disponíveis</h6>
                    <ul class="list-unstyled mb-0 small">
                        <li class="d-flex align-items-start mb-3">
                            <span class="fs-5 me-2">🇧🇷</span>
                            <div>
                                <div class="fw-semibold">Nacional</div>
                                <div class="text-muted">Viagens dentro do Brasil</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-start mb-3">
                            <span class="fs-5 me-2">🌎</span>
                            <div>
                                <div class="fw-semibold">Américas</div>
                                <div class="text-muted">Do Canadá à Patagônia</div>
                            </div>
                        </li>
                        <li class="d-flex align-items-start">
                            <span class="fs-5 me-2">🇪🇺</span>
                            <div>
                                <div class="fw-semibold">Europa</div>
                                <div class="text-muted">Todo o continente europeu</div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
(function () {
    var inicio = document.getElementById('data_inicio');
    var fim    = document.getElementById('data_fim');
    var form   = document.getElementById('cotacao-form');
    var btn    = document.getElementById('submit-btn');

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

    form.addEventListener('submit', function () {
        btn.disabled = true;
        btn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span>Calculando...';
    });
})();
</script>
@endsection