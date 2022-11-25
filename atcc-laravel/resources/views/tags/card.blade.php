<div class="card card-link" id={{ $tag->unique }} onclick="window.location='{{ route('tags_view_edit', ['id' => $tag->id] ) }}'">
    <div class="card-header {{ $tag->status === 'Ativo' ? 'green' : 'red' }}">
        {{ $tag->code }}
    </div>
    <div class="card-body">
        <table class="table">
            <tr>
                <th>Sub Status</th>
                <td>{{ $tag->sub_status }}</td>
            </tr>
            <tr>
                <th>Access Level</th>
                <td>{{ $tag->access_level }}</td>
            </tr>
        </table>
    </div>
</div>
