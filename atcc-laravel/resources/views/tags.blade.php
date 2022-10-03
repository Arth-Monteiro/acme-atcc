@extends('layouts.app')

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="code" type="text" class="form-control w-25" name="code" autofocus placeholder="Procurar pelo CODE...">
            <a class="register-button" href="{{ route('view_create_tag') }}">{{ __('Registrar Tag') }}</a>
        </div>


        <div style="border: 1px solid black">
            @foreach($tags as $tag)
                <div class="tag-row {{$tag->status === 'Active' ? "green" : "red" }}">
                    <a href="{{ route('view_edit_tag', ['id' => $tag->id]) }}" class="flex-grow-1 ">{{ $tag->code }}</a>
                    <div class="w-25">{{ $tag->sub_status }}</div>
                    <div class="">{{ $tag->access_level }}</div>
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

    .tag-row {
        display: flex;
        justify-content: space-between;
        column-gap: 30px;
        font-size: 18px;
        padding: 0 10px;
    }

    .tag-row a {
        text-decoration: none;
        color: black;
    }

    .tag-row:hover {
        background-color: #788585;
     }

    .green {
        background-color: #00b932;
    }

    .red {
        background-color: #e80b0b;
    }
</style>
