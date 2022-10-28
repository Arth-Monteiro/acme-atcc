<div class="card card-link" onclick="window.location='{{ route('users_view_edit', ['id' => $user->id] ) }}'">
    <div class="card-header {{ $user->email === Auth::user()->email ? 'green' : ''}}">
        {{ $user->name }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Email</th>
                <td>{{ $user->email }}</td>
            </tr>
        </table>
    </div>
</div>
