$(document).ready(function() {
    $('#tripForm').submit(function(event) {

        event.preventDefault();

        var tripDate = $('#tripDate').val();


        $.ajax({
            url: 'get_trips.php', // Замените на путь к вашему серверному скрипту
            type: 'GET',
            data: { tripDate: tripDate },
            success: function(response) {
                $('#tripResults').html(response);
            },
            error: function(xhr, status, error) {
                console.error(xhr.responseText);
            }
        });
    });
});