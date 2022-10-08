$(document).ready(function(){
    $("#code").on("keyup", function() {
        const value = $(this).val().toLowerCase();
        $(".card").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});
