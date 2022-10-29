@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body w-50 d-flex flex-column m-auto">
                        <form method="{{ 'POST' }}" action="{{ isset($tag) ? route('tags_put', ['id' => $tag->id]) : route('tags_post') }}">
                            @csrf

                            <div class="d-flex flex-row" >

                                <div class="mb-3 flex-grow-1">
                                    <label for="code" class="col-form-label">{{ __('Code') }}</label>

                                    <div class="w-75">
                                        <input id="code"
                                               type="text"
                                               class="form-control @error('code') is-invalid @enderror"
                                               name="code" value="{{ $tag->code ?? old('code') }}"
                                               required
                                               autocomplete="code"
                                               autofocus>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="col-form-label">{{ __('Status') }}</label>

                                    <div>
                                        <select
                                            id="status"
                                            class="form-control @error('status') is-invalid @enderror"
                                            name="status">

                                            <option value="" disabled selected></option>
                                            @foreach(App\Models\Tags::STATUS as $status)
                                                <option value="{{ $status }}" {{ ($tag->status ?? old('status')) === $status ? "selected" : "" }}>{{ $status }}</option>
                                            @endforeach

                                        </select>

                                        @error('status')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                            </div>

                            <div class="d-flex flex-row justify-content-between">

                                <div class="mb-3 flex-grow-1">
                                    <label for="sub_status" class="col-form-label">{{ __('Sub Status') }}</label>

                                    <div class="w-75">

                                        <select
                                            id="sub_status"
                                            class="form-control @error('sub_status') is-invalid @enderror"
                                            name="sub_status">

                                            <option value="" disabled selected></option>
                                            @foreach(App\Models\Tags::SUB_STATUS as $sub_status)
                                                <option value="{{ $sub_status }}" {{ ($tag->sub_status ?? old('sub_status')) === $sub_status ? "selected" : "" }}>{{ $sub_status }}</option>
                                            @endforeach

                                        </select>

                                        @error('sub_status')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="access_level" class="col-form-label">{{ __('Access Level') }}</label>

                                    <div>

                                        <select
                                            id="access_level"
                                            class="form-control @error('access_level') is-invalid @enderror"
                                            name="access_level">

                                            <option value="" disabled selected></option>
                                            @foreach(App\Models\Tags::ACCESS_LEVEL as $access_level)
                                                <option value="{{ $access_level }}" {{ ($tag->access_level ?? old('access_level')) === $access_level ? "selected" : "" }}>{{ $access_level }}</option>
                                            @endforeach

                                        </select>

                                        @error('access_level')
                                        <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror

                                    </div>
                                </div>
                            </div>

                            @if(isset($companies) && !empty($companies))
                                <div class="mb-3">
                                <label for="company_id" class="col-form-label"><?php echo e(__('Company')); ?></label>

                                <select
                                    id="company_id"
                                    class="form-control @error('company_id') is-invalid @enderror"
                                    name="company_id">

                                    <option value="" disabled selected></option>
                                    @foreach($companies as $company)
                                        <option value="{{ $company->id }}" {{ ($tag->company_id ?? old('company_id')) === $company->id ? "selected" : "" }}>{{ $company->fantasy_name }}</option>
                                    @endforeach

                                </select>

                                @error('company_id')
                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                @enderror
                            </div>
                            @endif

                            <div class="row mb-0">
                                <div class="d-flex justify-content-end" style="column-gap: 10px">
                                    @if (isset($tag))
                                        <button id="delete" class="btn" style="background-color: red;">
                                            {{ __('Remove') }}
                                        </button>
                                    @endif
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Save') }}
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
