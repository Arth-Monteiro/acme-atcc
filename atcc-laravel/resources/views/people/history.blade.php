@extends('layouts.app')

@push('styles_scripts')
    <link href="{{ asset('css/panel.css') }}" rel="stylesheet">
    <script>
        $(document).ready(function () {
            $('.datetime').each((_, elem) => $(elem).text(formatDateTime($(elem).text())));
            $('.cpf').mask('000.000.000-00');
        });
    </script>
    <style>
        .title {
            cursor: pointer;
        }
    </style>
@endpush

@section('content')
    <div id="people-panel" class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <div class="d-flex gap-5">
                <h3 class="title"
                    onclick="window.location='{{ route('people_view_edit', ['id' => $response['person_id']] ) }}'">
                    {{ $response['person_name'] }} - <span class="cpf">{{ $response['cpf'] }}</span>
                </h3>
            </div>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Building</th>
                    <th>Floor</th>
                    <th>Room</th>
                    <th>Entered At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($response['history'] as $register)
                    <tr>
                        <td>{{$register->building_name}}</td>
                        <td>{{$register->floor_name}}</td>
                        <td>{{$register->room_name}}</td>
                        <td class="datetime">{{$register->created_at}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{ $response['history']->onEachSide(1)->links() }}
    </div>
@endsection
