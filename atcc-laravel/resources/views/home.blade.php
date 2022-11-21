@extends('layouts.app')

@push('styles_scripts')
    <script src="{{ asset('js/panel.js') }}"></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 row">
            <div id="buildings" class="col-md-2 card-container">
                @foreach ($buildings as $building)
                    <div id='{{ $building->id }}' class='panel-card card-building' onclick='showFloors({{ $building->id }})'>
                        <span>{{ $building->name }}</span>
                        <span class='card-number'>0</span>
                    </div>
                @endforeach
            </div>
            <div id="floors" class="col-md-2">
                <div style='display: none;' aria-building='buildingid' aria-value='building_levelid' class='roof card-floor'></div>
                @foreach ($buildings as $building)
                    @foreach ($building->floors as $floor)
                        <div style='display: none;'
                             aria-building='{{ $building->id }}'
                             id='{{ $floor->id }}'
                             class='panel-card card-floor'
                             onclick='showRooms({{ $floor->id }})'>
                            {{ $floor->name }} - <span class='card-number'>0</span>
                        </div>
                    @endforeach
                @endforeach
            </div>
            <div id="rooms" class="col-md-4">
            </div>
            <div id="people-panel" class="col-md-4">
                <table>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
