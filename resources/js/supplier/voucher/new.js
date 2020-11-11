$(document).ready(function() {
    const FREESHIP_VOUCHER = 0;
    const DISCOUNT_VOUCHER = 1;
    const DISCOUNT_FREESHIP_VOUCHER = 2;
    if ($('.select-apply-for').val() == DISCOUNT_VOUCHER ) {
        $('.discount').css("display","inline");
    } else if ($('.select-apply-for').val() == DISCOUNT_FREESHIP_VOUCHER) {
        $('.discount').css("display","inline");
    } else {
        $('.discount').css("display","none");
    }

    $('.select-apply-for').on('change', function() {
        if (this.value == DISCOUNT_VOUCHER ) {
            $('.discount').css("display","inline");
            $('.freeship-input').val(null);
        } else if (this.value == DISCOUNT_FREESHIP_VOUCHER) {
            $('.discount').css("display","inline");
            $('.freeship-input').val(DISCOUNT_VOUCHER);
        } else {
            $('.discount').css("display","none");
            $('.freeship-input').val(DISCOUNT_VOUCHER);
            $('.discount-input').val(FREESHIP_VOUCHER);
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
