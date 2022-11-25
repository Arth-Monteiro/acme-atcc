removeMask = function(value) {
    return value.replace(/[+-.()\s]/gm, '');
}

formatDateTime = function(datetime) {
    let dateTimeSplit = datetime.split(' ');
    let dateSplit = dateTimeSplit[0].split('-');
    return dateSplit[2] + '/' + dateSplit[1] + '/' + dateSplit[0] + ' ' + dateTimeSplit[1];
}

$(document).ready(function() {
    $('#delete').on('click', function(evt) {
        evt.preventDefault();
        if (confirm('Are you sure to delete this item')) {
            $.ajax({
                type: 'DELETE',
                // url: "http://localhost:8000/tags/list?page=1&active=1",
                url:  window.location.pathname,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    window.location = response.location;
                },
                error: function (request) {
                    alert(request.responseJSON.msg);
                }
            });
        }
    })
})


