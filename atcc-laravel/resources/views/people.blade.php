@extends('layouts.app')

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="cpf" type="text" class="form-control w-25" name="cpf" autofocus placeholder="Procurar pelo CPF...">
            <a class="register-button" href="{{ route('view_create_person') }}">{{ __('Registrar Pessoas') }}</a>
        </div>


        <div style="border: 1px solid black">
            @foreach($people as $person)
                <div class="person-row">
                    <a href="{{ route('view_edit_person', ['id' => $person->id]) }}" class="flex-grow-1">{{$person->firstname . ' ' . $person->lastname }}</a>
                    <div>{{ $person->cpf }}</div>
                    <div class="w-25 text-end">{{ $person->qualification }}</div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

<style>
    .register-button {
        background-color: #4b89e2;
        padding: 7px 20px;
        border-radius: 5px;
        text-decoration: none;
        color: black;
    }

    .register-button:hover {
        background-color: #0dcaf0;
        color: black;
    }

    .person-row {
        display: flex;
        justify-content: space-between;
        column-gap: 30px;
        font-size: 18px;
        padding: 0 10px;
    }

    .person-row a {
        text-decoration: none;
        color: black;
    }
</style>
