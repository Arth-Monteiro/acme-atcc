@extends('layouts.app')

@push('styles_scripts')
    <script src="{{ asset('js/listCards.js') }}"></script>
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex gap-5">
                <input id="code" type="text" class="form-control" name="code" autofocus placeholder="Search by Name...">
                <button id="search" type="button" class="search-button">Pesquisar</button>
            </div>
            <a class="register-button" href="{{ route('rooms_view_create', [$building_id, $floor_id]) }}">{{ __('Register Room') }}</a>
        </div>

        <div class="infinite-scroll">
            <div class="card-container">
            </div>
        </div>
    </div>
@endsection
