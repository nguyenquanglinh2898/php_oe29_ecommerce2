$(document).ready(function() {
    for (let i = 0; i < $('.product-thumbnail').length; i++) {
        let productThumbnailClass = $('.image-product:eq(' + i +')');
        productThumbnailClass.css('background-image', 'url(' + productThumbnailClass.attr('data-url') + ')');
        productThumbnailClass.css('background-repeat', 'no-repeat');
        productThumbnailClass.css("padding-top", "100%");
    }

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
