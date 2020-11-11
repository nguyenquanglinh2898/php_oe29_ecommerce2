$(document).ready(function() {
    var image = $('.site-user .upload-avatar .avatar-preview').attr('data-image');
    $('.site-user .upload-avatar .avatar-preview').css('background-image', 'url("' + image + '")');
    $('.site-user .upload-avatar .avatar-preview').css("padding-top", '100%');
    $(".input-upload").css("display", "none");
    $("#upload").change(function() {
        $('.site-user .upload-avatar .avatar-preview').css('background-image', 'url("' + getImageURL(this) + '")');
    });

    function getImageURL(input) {
        return URL.createObjectURL(input.files[0]);
    };
});
