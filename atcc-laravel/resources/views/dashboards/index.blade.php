@extends('layouts.app')

@push('styles_scripts')
    <link href="{{ asset('css/cards.css') }}" rel="stylesheet">
@endpush

@section('content')
    <div class="container" style="">
        <iframe
            src="{{ $iframe_uri }}"
            frameborder="50"
            style="border-radius: 20px; overflow-y: auto;"
            width="100%"
            height="720"
            allowtransparency
        ></iframe>
    </div>
@endsection
