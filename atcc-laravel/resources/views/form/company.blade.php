@extends('layouts.app')

@push('styles_scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        $(document).ready(function() {
            const cnpj = $('#cnpj');
            cnpj.mask('00.000.000/0000-00', {reverse: true});

        })
    </script>

    <style>
        .input-register {
            width: 100%;
        }

        .input-container {
            margin: auto;
            width: 80%;
        }
    </style>
@endpush

@section('content')
    <div class="container" style="width: 30%">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">{{ __('Registro') }}</div>

                    <div class="card-body p-lg-5">
                        <form method={{ 'POST' }} action="{{  isset($company) ? route('companies_put', ['id' => $company->id]) : route('companies_post') }}">
                            @csrf
                            <div class="input-container">
                                <div class="d-flex justify-content-center">
                                    <div class="input-register">
                                        <div class="row mb-3">
                                        <label for="cnpj" class="col-form-label">{{ __('CNPJ') }}</label>

                                        <div>
                                            <input id="cnpj"
                                                   type="text"
                                                   class="form-control @error('cnpj') is-invalid @enderror"
                                                   name="cnpj"
                                                   value="{{ $company->cnpj ?? old('cnpj') }}" required autocomplete="cnpj">

                                            @error('cnpj')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="row mb-3">
                                        <label for="name" class="col-form-label">{{ __('Nome') }}</label>

                                        <div>
                                            <input id="name"
                                                   type="text"
                                                   class="form-control @error('name') is-invalid @enderror"
                                                   name="name"
                                                   value="{{  $company->name ?? old('name') }}"
                                                   required
                                                   autocomplete="name"
                                                   autofocus>

                                            @error('name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="row mb-3">
                                        <label for="fantasy_name" class="col-form-label">{{ __('Nome Fantasia') }}</label>

                                        <div>
                                            <input id="fantasy_name"
                                                   type="text"
                                                   class="form-control @error('fantasy_name') is-invalid @enderror"
                                                   name="fantasy_name"
                                                   value="{{ $company->fantasy_name ?? old('fantasy_name') }}"
                                                   required
                                                   autocomplete="fantasy_name">

                                            @error('fantasy_name')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                        <div class="row mb-3">
                                        <label for="contact_email" class="col-form-label">{{ __('Email de Contato') }}</label>

                                        <div>
                                            <input id="contact_email"
                                                   type="email"
                                                   class="form-control @error('contact_email') is-invalid @enderror"
                                                   name="contact_email"
                                                   value="{{ $company->contact_email ?? old('contact_email') }}"
                                                   required
                                                   autocomplete="contact_email">

                                            @error('contact_email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    </div>
                                </div>


                                <div class="row mt-lg-3 mb-0">
                                    <div class="d-flex justify-content-end" style="column-gap: 10px">
                                        @if (isset($company))
                                            <button id="delete" type="button" class="btn" style="background-color: red;">
                                                {{ __('Remover') }}
                                            </button>
                                        @endif
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Salvar') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
