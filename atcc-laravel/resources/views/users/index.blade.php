@extends('layouts.app')

@push('styles_scripts')
    <script src="{{ asset('js/listCards.js') }}"></script>
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="code" type="text" class="form-control w-25" name="code" autofocus placeholder="Search by Name...">
            <a class="register-button" href="{{ route('users_view_create') }}">{{ __('Register User') }}</a>
        </div>

        <div class="infinite-scroll">
            <div class="card-container">
            </div>
        </div>
    </div>
@endsection
