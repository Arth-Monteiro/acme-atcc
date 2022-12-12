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
                    <div class="card-header">{{ __('Registro') }}</div>

                    <div class="card-body p-lg-5">
                        <form method={{ 'POST' }} action="{{  route('people_tag_post', [$people_id, $tag_id]) }}">
                            @csrf
                            <div class="input-container">
                                <div class="d-flex justify-content-center">
                                    <div class="input-register">
                                        <div class="row mb-3">
                                            <label for="tag_id" class="col-form-label">{{ __('Tag') }}</label>

                                            <div>
                                                <select
                                                    id="tag_id"
                                                    class="form-control @error('tag_id') is-invalid @enderror"
                                                    name="tag_id">

                                                    <option value="" disabled selected></option>
                                                    @foreach($tags as $tag)
                                                        <option value="{{ $tag->id }}" {{ ($tag_id ?? old('tag_id')) === $tag->id ? "selected" : "" }}>{{ $tag->code }}</option>
                                                    @endforeach

                                                </select>

                                                @error('tag_id')
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
                                        @if (isset($tag_id) && $tag_id > 0)
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
