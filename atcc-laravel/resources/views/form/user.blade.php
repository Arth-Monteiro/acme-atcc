@extends('layouts.app')

@push('styles_scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <script>
        $(document).ready(function() {
            const cnpj = $('#cnpj');
            cnpj.mask('000.000.000/0000-00', {reverse: true});

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
                        <form method={{ 'POST' }} action="{{  isset($user) ? route('users_put', ['id' => $user->id]) : route('users_post') }}">
                            @csrf
                            <div class="input-container">
                                <div class="d-flex justify-content-center">
                                    <div class="input-register">
                                        <div class="row mb-3">
                                            <label for="name" class="col-form-label">{{ __('Nome') }}</label>

                                            <div>
                                                <input id="name"
                                                       type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="name"
                                                       value="{{ $user->name ?? old('name') }}"
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
                                            <label for="email" class="col-form-label">{{ __('Email') }}</label>

                                            <div>
                                                <input id="email"
                                                       type="email"
                                                       class="form-control @error('email') is-invalid @enderror"
                                                       name="email"
                                                       value="{{ $user->email ?? old('email') }}"
                                                       required
                                                       autocomplete="email">

                                                @error('email')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        @if(in_array('users_*', \App\Models\Roles::find(Auth::user()->role_id)->permissions) || in_array('*', \App\Models\Roles::find(Auth::user()->role_id)->permissions))

                                            <div class="row mb-3">
                                                <label for="password" class="col-form-label">{{ __('Senha') }}</label>

                                                <div>
                                                    <input id="password"
                                                           type="password"
                                                           class="form-control @error('password') is-invalid @enderror"
                                                           name="password"
                                                           required
                                                           autocomplete="new-password">

                                                    @error('password')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="password-confirm" class="col-form-label">{{ __('Confirma????o de Senha') }}</label>

                                                <div>
                                                    <input id="password-confirm"
                                                           type="password"
                                                           class="form-control"
                                                           name="password_confirmation"
                                                           required
                                                           autocomplete="new-password">
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <label for="role_id" class="col-form-label">{{ __('Role') }}</label>

                                                <div>
                                                    <select
                                                        id="role_id"
                                                        class="form-control @error('role_id') is-invalid @enderror"
                                                        name="role_id">

                                                        <option value="" disabled selected></option>
                                                        @foreach($roles as $role)
                                                            <option value="{{ $role->id }}" {{ ($user->role_id ?? old('role_id')) === $role->id ? "selected" : "" }}>{{ $role->name }}</option>
                                                        @endforeach

                                                    </select>

                                                    @error('role_id')
                                                    <span class="invalid-feedback" role="alert">
                                                            <strong>{{ $message }}</strong>
                                                        </span>
                                                    @enderror
                                                </div>
                                            </div>

                                        @endif

                                        @if(Auth::user()->getRole('code') === 'super_admin')
                                            <div class="row mb-3">
                                                <label for="company_id" class="col-form-label">{{ __('Empresa') }}</label>

                                                <div>
                                                    <select
                                                        id="company_id"
                                                        class="form-control @error('company_id') is-invalid @enderror"
                                                        name="company_id">

                                                        <option value="" disabled selected></option>
                                                        @foreach($companies as $company)
                                                            <option value="{{ $company->id }}" {{ ($user->company_id ?? old('company_id')) === $company->id ? "selected" : "" }}>{{ $company->fantasy_name }}</option>
                                                        @endforeach

                                                    </select>

                                                    @error('company_id')
                                                    <span class="invalid-feedback" role="alert">
                                                        <strong>{{ $message }}</strong>
                                                    </span>
                                                    @enderror
                                                </div>
                                            </div>
                                        @endif

                                        </div>
                                    </div>

                                @if(in_array('users_*', \App\Models\Roles::find(Auth::user()->role_id)->permissions) || in_array('*', \App\Models\Roles::find(Auth::user()->role_id)->permissions))
                                    <div class="row mt-lg-3 mb-0">
                                    <div class="d-flex justify-content-end" style="column-gap: 10px">
                                        @if (isset($user))
                                            <button id="delete" type="button" class="btn" style="background-color: red;">
                                                {{ __('Remover') }}
                                            </button>
                                        @endif
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Salvar') }}
                                        </button>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
