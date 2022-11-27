<div class="card card-link" id="{{ $floor->unique }}">
    <div class="card-header" onclick="window.location='{{ route('rooms_index', ['floor_id' => $floor->id, 'building_id' => $building_id] ) }}'">
        {{ $floor->name }}
    </div>
    <div class="card-body" onclick="window.location='{{ route('floors_view_edit', ['id' => $floor->id, 'building_id' => $building_id] ) }}'">
        <table class="table">
            <tr>
                <th>Ordem</th>
                <td>{{ $floor->order }}</td>
            </tr>
        </table>
    </div>
</div>
