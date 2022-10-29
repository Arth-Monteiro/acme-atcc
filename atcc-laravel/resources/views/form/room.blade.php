@extends('layouts.app')

@push('styles_scripts')
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 60px;
            height: 34px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 26px;
            width: 26px;
            left: 4px;
            bottom: 4px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
        }

        input:checked + .slider {
            background-color: #2196F3;
        }

        input:focus + .slider {
            box-shadow: 0 0 1px #2196F3;
        }

        input:checked + .slider:before {
            -webkit-transform: translateX(26px);
            -ms-transform: translateX(26px);
            transform: translateX(26px);
        }

        /* Rounded sliders */
        .slider.round {
            border-radius: 34px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

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
                        <form method={{ 'POST' }} action="{{  isset($room) ? route('rooms_put', ['id' => $room->id, $building_id, $floor_id]) : route('rooms_post', [$building_id, $floor_id]) }}">
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
                                                       value="{{ $room->name ?? old('name') }}"
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
                                            <label for="blueprint" class="col-form-label">{{ __('Blueprint') }}</label>

                                            <div>
                                                <input id="blueprint"
                                                       type="text"
                                                       class="form-control @error('blueprint') is-invalid @enderror"
                                                       name="blueprint"
                                                       value="{{ $room->blueprint ?? old('blueprint') }}"
                                                       required
                                                       autocomplete="blueprint"
                                                       autofocus>

                                                @error('blueprint')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row mb-3">

                                            <label for="is_exit" class="col-form-label">{{ __('Is Exit') }}</label>

                                            <div>
                                                <label class="switch">
                                                    <input id="is_exit" name="is_exit" type="checkbox" {{ ($room->is_exit ?? old('is_exit')) ? 'checked' : '' }}>
                                                    <span class="slider round"></span>
                                                </label>

                                                @error('is_exit')
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
                                        @if (isset($room))
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
