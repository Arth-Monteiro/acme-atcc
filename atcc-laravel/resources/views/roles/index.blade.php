@extends('layouts.app')

@push('styles_scripts')
    <script src="{{ asset('js/listCards.js') }}"></script>
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="code" type="text" class="form-control w-25" name="code" autofocus placeholder="Search by Name...">
            <a class="register-button" href="{{ route('roles_view_create') }}">{{ __('Register Role') }}</a>
        </div>

        <div class="infinite-scroll">
            <div class="card-container">
                @foreach($roles as $role)
                    <div class="card card-link text-center p-5 fs-4" style="border: 1px solid black"
                         onclick="window.location='{{ route('roles_view_edit', ['id' => $role->id] ) }}'">
                        {{ $role->name }}
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection


