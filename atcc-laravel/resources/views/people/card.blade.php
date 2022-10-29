<div class="card card-link">
    <div class="card-header link cpf {{ $person->status === 'Active' ? 'green' : 'red' }}"
         onclick="window.location='{{ route('people_view_tag', [$person->id, $person->tag_id ?? 0] ) }}'"
    >
        {{ $person->cpf }}
    </div>
    <div class="card-body" onclick="window.location='{{ route('people_view_edit', ['id' => $person->id] ) }}'">
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
