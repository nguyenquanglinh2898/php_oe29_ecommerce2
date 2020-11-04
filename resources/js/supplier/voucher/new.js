$(document).ready(function() {
    if ($('.select-apply-for').val() == 1 ) {
        $('.discount').css("display","inline");
    } else if ($('.select-apply-for').val() == 2) {
        $('.discount').css("display","inline");
    } else {
        $('.discount').css("display","none");
    }

    $('.select-apply-for').on('change', function() {
        if (this.value == 1 ) {
            $('.discount').css("display","inline");
            $('.freeship-input').val(null);
        } else if (this.value == 2) {
            $('.discount').css("display","inline");
            $('.freeship-input').val(1);
        } else {
            $('.discount').css("display","none");
            $('.freeship-input').val(1);
            $('.discount-input').val(0);
        }
    });
    $('button.voucher-btn').click(function() {
        var url = $(this).attr('data-url');
        var url2 = $(this).attr('data-url2');
        $.ajax({
            url: url,
            type: 'POST',
            data: $('.voucher-form').serialize(),
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
                $('.text-red').text("");
                Object.entries(errors.errors).forEach(([key, value]) => {
                    $('.message-' + key).text(" " + value);
                });
            }
        });
    });
});
