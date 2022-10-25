<div class="card card-link" onclick="window.location='{{ route('view_edit_tags', ['id' => $tag->id] ) }}'">
    <div class="card-header {{ $tag->status === 'Active' ? 'green' : 'red' }}">
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
