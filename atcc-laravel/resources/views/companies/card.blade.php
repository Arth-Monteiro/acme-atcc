<div class="card card-link" id={{ $company->unique }} onclick="window.location='{{ route('companies_view_edit', ['id' => $company->id] ) }}'">
    <div class="card-header cnpj">
        {{ $company->cnpj }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Nome Fantasia</th>
                <td>{{ $company->fantasy_name }}</td>
            </tr>
            <tr>
                <th>Email de Contato</th>
                <td>{{ $company->contact_email }}</td>
            </tr>
        </table>
    </div>
</div>
