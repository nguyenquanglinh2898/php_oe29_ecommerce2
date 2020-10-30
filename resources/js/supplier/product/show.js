$(".mini-content").click(function() {
    let miniArea = $(this).parent().find('.mini-area');
    if (miniArea.css('display') == 'none') {
        miniArea.show();
    } else {
        miniArea.hide();
    }
});
