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
                        <form method={{ 'POST' }} action="{{  isset($floor) ? route('floors_put', ['id' => $floor->id, 'building_id' => $building_id]) : route('floors_post', compact('building_id')) }}">
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
                                                       value="{{ $floor->name ?? old('name') }}"
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
                                            <label for="order" class="col-form-label">{{ __('Order') }}</label>

                                            <div>
                                                <input id="order"
                                                       type="number"
                                                       class="form-control @error('order') is-invalid @enderror"
                                                       name="order"
                                                       value="{{ $floor->order ?? old('order') }}"
                                                       required
                                                       autocomplete="order"
                                                       autofocus>

                                                @error('order')
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
                                        @if (isset($floor))
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
