@extends('layouts.app')

@push('styles_scripts')
    <script src="{{ asset('js/listCards.js') }}"></script>
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex gap-5">
                <input id="code" type="text" class="form-control cnpj" name="cnpj" autofocus placeholder="Procurar pelo CNPJ...">
                <button id="search" type="button" class="search-button">Pesquisar</button>
            </div>
            <a class="register-button" href="{{ route('companies_view_create') }}">{{ __('Registrar Empresa') }}</a>
        </div>

        <div class="infinite-scroll">
            <div class="card-container">
            </div>
        </div>
    </div>
@endsection
