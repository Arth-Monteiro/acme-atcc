@extends('layouts.app')

@push('styles_scripts')
    <script>
        $(document).ready(function() {
            $('#name').on('keyup', function() {
                const code = $(this).val().toLowerCase().split(' ').join('_');
                $('#code').val(code);
            });

            $('.option:not(.option-title)').on('click', function() {
                $(this).parent().children().removeClass('selected');
                $(this).addClass('selected');
            });

            $('form').submit(function(evt) {

                const values = $('.option.selected');
                $.each(values, (index, node) => {
                    const element = $(node);
                    const parentId = element.parent().parent().attr('id');
                    $(this).append(`<input type="hidden" name="permission-${parentId}" value="${element.text().toLowerCase()}" /> `);
                    return true;
                })
            })
        })

    </script>

    <style>
        .permissions-options {
            border: 1px solid #cccccc;
            border-radius: 5px;
            padding: 10px;
            max-height: 215px;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
            row-gap: 10px;
        }

        .options {
            display: flex;
            flex-direction: row;
            justify-content: space-between;
        }

        .option {
            border: 1px solid #cccccc;
            border-radius: 5px;
            display: flex;
            align-items: center;
            padding: 3px 10px;
            cursor: pointer;
        }

        .option-title {
            border: none;
            cursor: default;
        }

        .option:not(.option-title):not(.selected):hover {
            background-color: #0dcaf0;
            color: #000;
        }

        .option.selected {
            background-color: #4b89e2;
            color: #fff;
        }

        .readonly  {
            background-color: #ccc;
        }
    </style>
@endpush



@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body w-60 d-flex flex-column m-auto">
                        <form method="{{ 'POST' }}" action="{{ isset($role) ? route('roles_put', ['id' => $role->id]) : route('roles_post') }}">
                            @csrf

                            <div class="d-flex flex-row gap-5" >

                                <div class="mb-3">
                                    <label for="code" class="col-form-label">{{ __('Name') }}</label>

                                    <div class="">
                                        <input id="name"
                                               type="text"
                                               class="form-control @error('name') is-invalid @enderror"
                                               name="name" value="{{ $role->name ?? old('name') }}"
                                               required
                                               autocomplete="code"
                                               maxlength="20"
                                               autofocus>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="mb-3 ">
                                    <label for="code" class="col-form-label">{{ __('Code') }}</label>

                                    <div class="">
                                        <input id="code"
                                               type="text"
                                               readonly
                                               class="form-control readonly @error('code') is-invalid @enderror"
                                               name="code" value="{{ $role->code ?? old('code') }}"
                                               required>

                                        @error('code')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>

                            </div>

                            <div class="permissions-options">

                                @foreach(App\Models\Roles::PATHS as $path)
                                    <div class="options" id="{{ $path }}">
                                        <div class="option option-title">{{ ucfirst($path) }}</div>
                                        <div class="d-flex justify-content-between gap-2">
{{--                                            <span class="option {{ ( $path ?? old($path)) === $status ? "selected" : "" }}">Editor</span>--}}
                                            <span class="option">Viewer</span>
                                            <span class="option selected">None</span>
                                        </div>
                                    </div>
                                @endforeach

                            </div>

                            <div class="row mb-0 mt-3">
                                <div class="d-flex justify-content-end" style="column-gap: 10px">
                                    @if (isset($tag))
                                        <button class="btn red">
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
