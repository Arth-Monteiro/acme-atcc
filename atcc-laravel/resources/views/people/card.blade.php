<div class="card card-link" id="{{ $person->unique }}">
    <div class="card-header link cpf"
         onclick="window.location='{{ route('people_view_tag', [$person->id, $person->tag_id ?? 0] ) }}'"
    >
        {{ $person->cpf }}
    </div>
    <div class="card-body" onclick="window.location='{{ route('people_view_edit', ['id' => $person->id] ) }}'">
        <table class="table">
            <tr>
                <th>Nome</th>
                <td>{{ $person->firstname  . ' ' . $person->lastname }}</td>
            </tr>
            <tr>
                <th>Qualificação</th>
                <td>{{ $person->qualification }}</td>
            </tr>
            @if(Auth::user()->getRole('code') === 'super_admin')
                <tr>
                    <th>Empresa</th>
                    <td>{{ $person->company }}</td>
                </tr>
            @endif
        </table>
    </div>
    <button type="button" class="history"
            onclick="window.location='{{ route('people_view_history', [$person->id] ) }}'">
        Consultar Histórico
    </button>
</div>

<style>
    .history {
        background-color:  #4b89e2;
        border: none;
        border-radius: 0 0 var(--bs-card-inner-border-radius) var(--bs-card-inner-border-radius);
        padding: var(--bs-card-cap-padding-y) var(--bs-card-cap-padding-x);
        color: #fff;
        font-weight: bold;
        text-align: center;
    }
    .history:hover {
        background-color: #3dd5f3;
        color: #000;
    }
</style>

<script>
    $(document).ready(function() {
        $('.cpf').mask('000.000.000-00');
    })
</script>
