$(document).ready(function() {
    $("#search-box").keyup(function() {
        $.ajax({
            type: "POST",
            url: $(this).attr('data-url'),
            data:'name=' + $(this).val(),
            success: function(data) {
                $(".search-data").html(data);
            }
        });
    });
});
