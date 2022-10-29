<div class="card card-link" onclick="window.location='{{ route('rooms_view_edit', [$building_id, $floor_id, $room->id] ) }}'">
    <div class="card-header {{ $room->is_exit ? 'green' : 'red' }}">
        {{ $room->name }}
    </div>
    <div class="card-body">
        <table class="table">

        </table>
    </div>
</div>
