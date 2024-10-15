// Code for showing alert message
$(document).ready(function() {
    setTimeout(function() {
        $(".alert").fadeOut("slow", function() {
            $(this).remove();
        });
    }, 8000); // Time in milliseconds (3000ms = 3 seconds)
});


