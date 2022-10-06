@extends('layouts.app')

@section('content')
    <div class="container w-75 d-flex flex-column gap-lg-5">
        <div class="d-flex align-items-center justify-content-between">
            <input id="code" type="text" class="form-control w-25" name="code" autofocus placeholder="Procurar pelo CODE...">
            <a class="register-button" href="{{ route('view_create_tag') }}">{{ __('Registrar Tag') }}</a>
        </div>


        <table class="list-table">
            <thead>
                <tr class="list-row header">
                    <th width="63%">Code</th>
                    <th width="15%">Sub Status</th>
                    <th width="12%" class="text-center">Access Level</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tags as $tag)
                    <tr onclick="window.location='{{ route('view_edit_tag', ['id' => $tag->id]) }}'" class="list-row body {{$tag->status === 'Active' ? "green" : "red" }}">
                        <td width="63%">{{ $tag->code }}</td>
                        <td width="15%">{{ $tag->sub_status }}</td>
                        <td width="12%" class="text-center">{{ $tag->access_level }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
