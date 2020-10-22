$('#search-input input').on('keyup', function() {
    table.search(this.value).draw();
});

$(document).ready(function() {
    $(".deleteDialog").click(function() {
        var voucher_id = $(this).attr('data-id');
        var url = $(this).attr('data-url');
        var notification = $(this).attr('data-noti');
        var mess = $(this).attr('data-mess');
        var form = $('.remove_form').serialize();
        Swal.fire({
            type: 'question',
            title: notification,
            text: mess,
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            showLoaderOnConfirm: true,
            preConfirm: () => {
                $.ajax({
                    type: 'POST',
                    url: $(this).attr('data-url'),
                    data: $('.remove_form').serialize(),

                }).done(function(res) {
                    $('.box-body').html(res);
                });
            },
        })
    });
});
