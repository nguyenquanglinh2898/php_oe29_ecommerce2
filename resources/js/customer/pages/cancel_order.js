$('.cancel-order').click(function() {
    var url = $(this).attr('data-url');
    var url2 = $(this).attr('data-url2');
    $.ajax({
        url: url,
        type: 'POST',
        data: $('.cancel-form').serialize(),
        success: function(data) {
            Swal.fire({
                title: data.success,
                text: data.msg,
                type: 'success',
            }).then((result) => {
                window.location = url2;
            });
        },
        error: function(data) {
            var errors = data.responseJSON;
            Swal.fire({
                title: errors.error,
                text: errors.msg,
                type: 'error',
            })
        }
    });
});
