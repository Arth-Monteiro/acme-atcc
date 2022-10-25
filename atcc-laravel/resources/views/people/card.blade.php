<div class="card card-link" onclick="window.location='{{ route('view_edit_people', ['id' => $person->id] ) }}'">
    <div class="card-header cpf {{ $person->status === 'Active' ? 'green' : 'red' }}">
        {{ $person->cpf }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Name</th>
                <td>{{ $person->firstname  . ' ' . $person->lastname }}</td>
            </tr>
            <tr>
                <th>Qualification</th>
                <td>{{ $person->qualification }}</td>
            </tr>
        </table>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.cpf').mask('000.000.000-00');
    })
</script>
