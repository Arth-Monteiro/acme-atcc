@extends('layouts.app')

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="cpf" type="text" class="form-control w-25" name="cpf" autofocus placeholder="Procurar pelo CPF...">
            <a class="register-button" href="{{ route('view_create_person') }}">{{ __('Registrar Pessoas') }}</a>
        </div>


        <table class="list-table">
            <thead>
                <tr class="list-row header">
                    <th width="63%">Name</th>
                    <th width="15%">Cpf</th>
                    <th width="12%">Qualification</th>
                </tr>
            </thead>
            <tbody>
                @foreach($people as $person)
                    <tr onclick="window.location='{{ route('view_edit_person', ['id' => $person->id]) }}'" class="list-row body">
                        <td width="63%">{{$person->firstname . ' ' . $person->lastname }}</td>
                        <td width="15%">{{ $person->cpf }}</td>
                        <td width="12%">{{ $person->qualification }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
