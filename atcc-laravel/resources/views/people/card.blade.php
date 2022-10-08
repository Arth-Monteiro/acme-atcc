<div class="card card-link" onclick="window.location='{{ route('view_edit_person', ['id' => $person->id] ) }}'">
    <div class="card-header {{ $person->status === 'Active' ? 'green' : 'red' }}">
        {{ $person->cpf }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Name</th>
                <td>{{ $person->firstname  . ' ' . $person->lastname}}</td>
            </tr>
            <tr>
                <th>Qualification</th>
                <td>{{ $person->qualification }}</td>
            </tr>
        </table>
    </div>
</div>
