removeMask = function(value) {
    return value.replace(/[+-.()\s]/gm, '');
}

$(document).ready(function() {
    $('#delete').on('click', function(evt) {
        evt.preventDefault();
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
    })
})


