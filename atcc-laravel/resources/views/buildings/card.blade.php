<div class="card card-link" id="{{ $building->unique }}">
    <div class="card-header" onclick="window.location='{{ route('floors_index', ['building_id' => $building->id] ) }}'">
            {{ $building->name }}
    </div>
    <div class="card-body" onclick="window.location='{{ route('buildings_view_edit', ['id' => $building->id] ) }}'">
        <table class="table">
            <tr>
                <th>Company</th>
                <td>{{ $building->company_name }}</td>
            </tr>
        </table>
    </div>
</div>
