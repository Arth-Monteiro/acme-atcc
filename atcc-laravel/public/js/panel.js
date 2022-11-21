function showFloors(id){
    $("#floors .card-floor").hide();
    $("#floors div[aria-building='" + id + "']").show();
    $(".roof").show();
    $("#buildings #" + id).addClass("panel-selected-card");
    $('.card-building').not(document.getElementById(id)).removeClass("panel-selected-card");
    $('.card-floor').removeClass("panel-selected-card");
    $('#rooms').empty();
    $('#people-panel table').empty();
}

function showRooms(id){
    $('.card-floor').not(document.getElementById(id)).removeClass("panel-selected-card");
    $("#floors #" + id ).addClass("panel-selected-card");
    $(".card-conjuntos").empty();
    $('#rooms').empty();
    $('#people-panel table').empty();

    $.ajax({
        type: 'GET',
        url: window.location.origin + '/panel/rooms',
        dataType: 'JSON',
        data: {
            "floor_id": id
        },
        success: function (response) {
            let html = '<svg class="card-rooms" width="500" height="400" xmlns="http://www.w3.org/2000/svg">';

            let rooms = response.rooms;
            rooms.forEach(function(room){
                let blueprint = room.blueprint.split('</text>');
                html += '<a id="' + room.id + '">'
                        + blueprint[0] + room.name + ' - ' + "0" + '</text>' + blueprint[1]
                        + '</a>';
            });

            html += '</svg>';

            $('#rooms').append(html);

            $("svg.card-rooms > *").on("click", function() {
                $("svg.card-rooms > *").not(this).removeClass("selected-room");
                $(this).addClass("selected-room");
                showContacts($(this).attr("id"));
            });

            getCount();
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function showContacts(id){
    $('#people-panel table').empty();

    $.ajax({
        type: 'GET',
        url: window.location.origin + '/panel/people',
        dataType: 'JSON',
        data: {
            "room_id": id
        },
        success: function (response) {

            let pessoasHTML = ` <tr aria-room='header'>
                                    <th> Nome </th>
                                    <th> Qualificação </th>
                                    <th> Entrada </th>
                                </tr>`;

            response.people.forEach(function(person){
                pessoasHTML += `<tr class='panel-card card-contato'>
                                    <td><a href='/people/` + person.id + `'>` + person.firstname + " " + person.lastname + `</a></td>
                                    <td>` + person.qualification + `</td>
                                    <td>` + formatDateTime(person.created_at) + `</td>
                                </tr>`;
            });

            $("#people-panel table").append(pessoasHTML);
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function formatDateTime(datetime){
    let dateTimeSplit = datetime.split(' ');
    let dateSplit = dateTimeSplit[0].split('-');
    return dateSplit[2] + '/' + dateSplit[1] + '/' + dateSplit[0] + ' ' + dateTimeSplit[1];
}

function getCount(){
    $.ajax({
        type: 'GET',
        url: window.location.origin + '/panel/count',
        success: function (response) {

            $(".card-number").html(0);

            $("#rooms svg a text").each(function(){
                let roomSVGText = $(this).html().split(' - ');
                $(this).html(roomSVGText[0] + ' - 0');
            });


            $.each(response.count, function(buildingId) {
                $("#buildings #" + buildingId + " .card-number").html(this.total);

                $.each(this, function (key, value) {
                    if (key !== 'total') {
                        $("#floors #" + key + " .card-number").html(value.total);

                        $.each(value, function (keyInside, valueInside) {
                            if (keyInside !== 'total') {
                                let textTag = $("#rooms svg #" + keyInside + " text");
                                if(textTag && textTag.html()){
                                    let roomSVGText = textTag.html().split(' - ');
                                    textTag.html(roomSVGText[0] + ' - ' + valueInside.total);
                                }
                            }
                        });
                    }

                });
            });
        },
        error: function (response) {
            console.log(response);
        }
    });
}

function automaticRefresh(){
    getCount();
    setTimeout(function(){ automaticRefresh(); }, 30000);
}

automaticRefresh();
