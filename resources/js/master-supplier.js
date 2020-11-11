$(document).ready(function(){
    @if(session('alert'))
    Swal.fire(
        '{{ session('alert')['title'] }}',
        '{{ session('alert')['content'] }}',
        '{{ session('alert')['type'] }}'
        )
    @endif
    $('#logout').click(function(){
        Swal.fire({
            title: 'Đăng Xuất',
            text: "Bạn có chắc muốn đăng xuất khỏi hệ thống!",
            type: 'question',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Đăng Xuất',
        }).then((result) => {
            if(result.value)
                document.getElementById('logout-form').submit();
        })
    });
});
$(function() {
    $('#sidebar-search-form').on('submit', function(e) {
        e.preventDefault();
    });
    $('.sidebar-menu li.active').data('lte.pushmenu.active', true);
    $('#sidebar-search-form input').on('keyup', function() {
        var term = $(this).val().trim();
        if (term.length === 0) {
            $('.sidebar-menu li').each(function() {
                $(this).show(0);
                $(this).removeClass('active');
                if ($(this).data('lte.pushmenu.active')) {
                    $(this).addClass('active');
                }
            });
            return;
        }
        $('.sidebar-menu li').each(function() {
            if ($(this).text().toLowerCase().indexOf(term.toLowerCase()) === -1) {
                $(this).hide(0);
                $(this).removeClass('pushmenu-search-found', false);
                if ($(this).is('.treeview')) {
                    $(this).removeClass('active');
                }
            } else {
                $(this).show(0);
                $(this).addClass('pushmenu-search-found');
                if ($(this).is('.treeview')) {
                    $(this).addClass('active');
                }
                var parent = $(this).parents('li').first();
                if (parent.is('.treeview')) {
                    parent.show(0);
                }
            }
            if ($(this).is('.header')) {
                $(this).show();
            }
        });
        $('.sidebar-menu li.pushmenu-search-found.treeview').each(function() {
            $(this).find('.pushmenu-search-found').show(0);
        });
    });
});

$('.close').click(function() {
    var url = $(this).attr('data-url');
    $.ajax({
        url: url,
        type: 'GET',
        success: function(data) {
            $('.num').html(data);
        },
    });
});
