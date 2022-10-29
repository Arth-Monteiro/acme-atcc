@extends('layouts.app')

@push('styles_scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

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
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body p-lg-5">
                        <form method={{ 'POST' }} action="{{  isset($building) ? route('buildings_put', ['id' => $building->id]) : route('buildings_post') }}">
                            @csrf
                            <div class="input-container">
                                <div class="d-flex justify-content-center">
                                    <div class="input-register">
                                        <div class="row mb-3">
                                            <label for="name" class="col-form-label">{{ __('Name') }}</label>

                                            <div>
                                                <input id="name"
                                                       type="text"
                                                       class="form-control @error('name') is-invalid @enderror"
                                                       name="name"
                                                       value="{{ $building->name ?? old('name') }}"
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
                                            <label for="company_id" class="col-form-label">{{ __('Company') }}</label>

                                            <div>
                                                <select
                                                    id="company_id"
                                                    class="form-control @error('company_id') is-invalid @enderror"
                                                    name="company_id">

                                                    <option value="" disabled selected></option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}" {{ ($building->company_id ?? old('company_id')) === $company->id ? "selected" : "" }}>{{ $company->fantasy_name }}</option>
                                                    @endforeach

                                                </select>

                                                @error('company_id')
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
                                        @if (isset($building))
                                            <button id="delete" type="button" class="btn" style="background-color: red;">
                                                {{ __('Remove') }}
                                            </button>
                                        @endif
                                        <button type="submit" class="btn btn-primary">
                                            {{ __('Save') }}
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
