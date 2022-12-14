@extends('layouts.app')

@push('styles_scripts')
    <script>
        $(document).ready(function() {
            const cpf = $('#cpf');
            cpf.mask('000.000.000-00', {reverse: true});

            const cel = $('#cellphone');
            cel.mask('(00) 00000-0000');

            const emergency = $('#emergency_contact');
            emergency.mask('(00) 00000-0000');

            $("form").submit(function(){
                cpf.val(removeMask(cpf.val()));
                cel.val(removeMask(cel.val()));
                emergency.val(removeMask(emergency.val()));
            });

            $('#company_id').change(function () {
                disableBuilding(parseInt(this.value, 10))
            });

            function disableBuilding(companyId) {
                @foreach($buildings as $building)
                    $('#building_{{ $building->id }}').prop( "disabled", {{ $building->company_id }} !== companyId );
                @endforeach
            }
        })
    </script>

    <style>
        .input-register {
            width: 28%;
        }
    </style>
@endpush

@section('content')
    <div class="container w-75">
        <div class="row justify-content-center">
            <div>
                <div class="card">
                    <div class="card-header">{{ __('Registro') }}</div>

                    <div class="card-body p-lg-5">
                        <form method={{ 'POST' }} action="{{  isset($person) ? route('people_put', ['id' => $person->id]) : route('people_post') }}">
                            @csrf
                            <div class="d-flex justify-content-between">
                                <div class="input-register">
                                    <div class="row mb-3">
                                        <label for="firstname" class="col-form-label">{{ __('Primeiro Nome') }}</label>

                                        <div>
                                            <input id="firstname"
                                                   type="text"
                                                   class="form-control @error('firstname') is-invalid @enderror"
                                                   name="firstname"
                                                   value="{{  $person->firstname ?? old('firstname') }}"
                                                   required
                                                   autocomplete="firstname"
                                                   autofocus>

                                            @error('firstname')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="lastname" class="col-form-label">{{ __('??ltimo Nome') }}</label>

                                        <div>
                                            <input id="lastname"
                                                   type="text"
                                                   class="form-control @error('lastname') is-invalid @enderror"
                                                   name="lastname"
                                                   value="{{ $person->lastname ?? old('lastname') }}"
                                                   required
                                                   autocomplete="lastname">

                                            @error('lastname')
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
                                                   value="{{ $person->email ?? old('email') }}"
                                                   required
                                                   autocomplete="email">

                                            @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="cpf" class="col-form-label">{{ __('CPF') }}</label>

                                        <div>
                                            <input id="cpf"
                                                   type="text"
                                                   class="form-control @error('cpf') is-invalid @enderror"
                                                   name="cpf"
                                                   value="{{ $person->cpf ?? old('cpf') }}" required autocomplete="cpf">

                                            @error('cpf')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="input-register">

                                    <div class="row mb-3">
                                        <label for="cellphone" class="col-form-label">{{ __('Celular') }}</label>

                                        <div>
                                            <input id="cellphone"
                                                   type="tel"
                                                   class="form-control @error('cellphone') is-invalid @enderror"
                                                   name="cellphone"
                                                   value="{{ $person->cellphone ?? old('cellphone') }}"
                                                   required
                                                   autocomplete="cellphone">

                                            @error('cellphone')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="emergency_contact" class="col-form-label">{{ __('Contato de Emerg??ncia') }}</label>

                                        <div>
                                            <input id="emergency_contact"
                                                   type="tel"
                                                   class="form-control @error('emergency_contact') is-invalid @enderror"
                                                   name="emergency_contact"
                                                   value="{{ $person->emergency_contact ?? old('emergency_contact') }}"
                                                   required
                                                   autocomplete="emergency_contact">

                                            @error('emergency_contact')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="company" class="col-form-label">{{ __('Empresa') }}</label>

                                        <div>
                                            <input id="company"
                                                   type="text"
                                                   class="form-control @error('company') is-invalid @enderror"
                                                   name="company"
                                                   value="{{ $person->company ?? old('company') }}"
                                                   required
                                                   autocomplete="company">

                                            @error('company')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="job_title" class="col-form-label">{{ __('Cargo') }}</label>

                                        <div>
                                            <input id="job_title"
                                                   type="text"
                                                   class="form-control @error('job_title') is-invalid @enderror"
                                                   name="job_title"
                                                   value="{{ $person->job_title ?? old('job_title') }}"
                                                   required
                                                   autocomplete="job_title">

                                            @error('job_title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                </div>

                                <div class="input-register">

                                    <div class="row mb-3">
                                        <label for="blood_type" class="col-form-label">{{ __('Tipo Sang??ineo') }}</label>

                                        <div>
                                            <select
                                                id="blood_type"
                                                class="form-control @error('blood_type') is-invalid @enderror"
                                                name="blood_type">

                                                <option value="" disabled selected></option>
                                                @foreach(App\Models\People::BLOOD_TYPES as $blood_type)
                                                    <option value="{{ $blood_type }}" {{ ($person->blood_type ?? old('blood_type')) === $blood_type ? "selected" : "" }}>{{ $blood_type }}</option>
                                                @endforeach

                                            </select>

                                            @error('blood_type')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="qualification" class="col-form-label">{{ __('Qualifica????o') }}</label>

                                        <div>
                                            <select id="qualification" class="form-control @error('qualification') is-invalid @enderror" name="qualification" >

                                                <option value="" disabled selected></option>
                                                @foreach(App\Models\People::QUALIFICATION as $qualification)
                                                    <option value="{{ $qualification }}" {{ ($person->qualification ?? old('qualification')) === $qualification ? 'selected' : "" }}>{{ $qualification }}</option>
                                                @endforeach

                                             </select>

                                            @error('qualification')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>

                                    @if(Auth::user()->getRole('code') === 'super_admin')
                                        <div class="row mb-3">
                                            <label for="company_id" class="col-form-label">{{ __('Empresa Cliente') }}</label>

                                            <div>
                                                <select
                                                    id="company_id"
                                                    class="form-control @error('company_id') is-invalid @enderror"
                                                    name="company_id">

                                                    <option value="" disabled selected></option>
                                                    @foreach($companies as $company)
                                                        <option value="{{ $company->id }}" {{ ($person->company_id ?? old('company_id')) === $company->id ? "selected" : "" }}>{{ $company->fantasy_name }}</option>
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

                                    <div class="row mb-3">
                                        <label for="building_id" class="col-form-label">{{ __('P??edio') }}</label>

                                        <div>
                                            <select
                                                id="building_id"
                                                class="form-control @error('building_id') is-invalid @enderror"
                                                name="building_id">

                                                <option value="" disabled selected></option>
                                                @foreach($buildings as $building)
                                                    <option
                                                        id="building_{{ $building->id }}"
                                                        value="{{ $building->id }}" {{ ($person->building_id ?? old('building_id')) === $building->id ? "selected" : "" }}
                                                    >{{ $building->name }}</option>
                                                @endforeach

                                            </select>

                                            @error('building_id')
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
                                    @if (isset($person))
                                        <button id="delete" class="btn" style="background-color: red;">
                                            {{ __('Remover') }}
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Salvar') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
