$(document).ready(function() {

    var slider = displayGallery(0);

    $("#slide-advertise").owlCarousel({
        items: 2,
        autoplay: true,
        loop: true,
        margin: 10,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        responsive:{
            0:{
                items: 1,
            },
            992:{
                items: 2,
                animateOut: 'zoomInRight',
                animateIn: 'zoomOutLeft',
            }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
    });
    var height_description = $('#description').height();

    if(height_description > 768) {
        $('#description').animate({
            height: '768px',
        }, 500);
        $('#description .loadmore').css('display', 'block');
    }

    $('#description .loadmore a').click(function() {
        $('#description').animate({
            height: height_description + 20 +'px',
        }, 500);
        $('#description .loadmore').css('display', 'none');
        $('#description .hidemore').css('display', 'block');
    });

    $('#description .hidemore a').click(function() {
        $('#description').animate({
            height: '768px',
        }, 500);
        $('#description .loadmore').css('display', 'block');
        $('#description .hidemore').css('display', 'none');
    });

    $(".rating-product").rate();

    if($('.color-product .color-inner.active').attr('can-buy') == 0) {
        $('.form-payment .row>div>button').prop('disabled', true);
    }

    $('.select-color .color-inner').click(function() {
        var key = $(this).attr('data-key');
        if(!$(this).hasClass("active")) {
            $('.select-color .color-inner').removeClass('active');
            $(this).addClass('active');
            $('.price-product>div').css('display', 'none');
            $('.price-product>.product-' + key).css('display', 'block');
            if(!!slider.destroy) slider.destroy();
            $('.section-infomation .image-product>div').css('display', 'none');
            $('.section-infomation .image-product>.image-gallery-' + key).css('display', 'block');
            slider = displayGallery(key);
        }
        var can_by = $(this).attr('can-buy');
        $('#qty').val(can_by);
        if(can_by == 0)
            $('.form-payment .row>div>button').prop('disabled', true);
        else
            $('.form-payment .row>div>button').prop('disabled', false);
        var qty = $(this).attr('data-qty');
        $('#qty').attr('max', qty);
    });

    $('button.add_to_cart').click(function() {
        var url = $(this).attr('data-url');
        var url2 = $(this).attr('data-url2');
        $.ajax({
            url: url,
            type: 'GET',
            data: $('.product_detail_form').serialize(),
            success: function(data) {
                $('.support-cart').remove();
                $('.cart').load(url2);
                Swal.fire({
                    title: data.success,
                    text: data.msg,
                    type: 'success',
                })
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

    $('button.buy_now').click(function() {
        var url = $(this).attr('data-url');
        var url2 = $(this).attr('data-url2');
        $.ajax({
            url: url,
            type: 'GET',
            data: $('.product_detail_form').serialize(),
            success: function(data) {
                window.location = url2;
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

    $(function() {
        $('.atribute').on('change', function(e) {
            $.ajax({
                type: 'POST',
                url: $(this).attr('data-url'),
                data: $('.select_form').serialize(),
            }).done(function(res) {
                var data = JSON.parse(res);
                if (data[0]) {
                    $('.price').html(data[0].price);
                    $('.remaining').html(data[0].remaining);
                    $('#product_detail_id').val(data[0].id);
                    $('.vnd').css('display', 'inline');
                } else {
                    $('.remaining').html(data.msg);
                    $('.price').html(data.msg);
                    $('#product_detail_id').val(-1);
                    $('.vnd').css('display', 'none');
                }
            });
        });
    });

    function scrollToxx() {
      $('html, body').animate({ scrollTop: $('.tab-description').offset().top }, 'slow');
      $('.tab-header .nav-tab-custom>li.active').removeClass('active');
      $('.tab-header .nav-tab-custom>li.active, .tab-content>div.active').removeClass('active in');
      $('.tab-header .nav-tab-custom>li:nth-child(2)').addClass('active');
      $('.tab-header .nav-tab-custom>li:nth-child(2), #vote').addClass('active in');
    }

    function displayGallery(key) {
      var slider = $('#imageGallery-' + key).lightSlider({
          gallery:true,
          item:1,
          loop:true,
          thumbItem:5,
          slideMargin:0,
          enableDrag: true,
          controls: false,
          slideMargin: 1,
          currentPagerPosition:'middle',
          onSliderLoad: function(el) {
              el.lightGallery({
                  selector: '#imageGallery-' + key + ' .lslide',
              });
          },
          onBeforeSlide: function (el) {
            $('body').addClass('lg-on');
          },
          onAfterSlide: function (el) {
            $('body').removeClass('lg-on');
          }
      });
      return slider;
    }

    $(".comment-form").submit(function(eventObj) {
        $("<input />").attr("type", "hidden")
            .attr("name", "rate")
            .attr("value", $(".rating-product").rate("getValue"))
            .appendTo(".section-rating .rating-form form");

            return true;
    });

    $('.btn-form-edit-rate').click(function() {
        if ($(".rating-product").rate("getValue").length != 0) {
            $('.input-rate-edit').val($(".rating-product").rate("getValue"));
        }
        $('.edit-comment-rate-form').submit();
    });

    $('.edit-comment').click(function() {
        if ($('.edit-section-rating').css("display") == "none") {
            $('.edit-section-rating').show();
        } else $('.edit-section-rating').hide();
    });

    $('.remove-edit').click(function() {
        $('.edit-section-rating').hide();
    });

    $('.delete-comment').click(function() {
        $('.delete-comment-form').submit();
    });

    $('.edit-comment-star').click(function() {
        if ($('.rate-edit-star').css("display") == "none") {
            $('.rate-edit-star').show();
            $('.rate-edit-star').addClass('rating-product rate-product ');
            $(".rating-product").rate();
        } else {
            $('.rate-edit-star').hide();
            $('.rate-edit-star').removeClass('rating-product rate-product ');
        }
    });

   $(document).on('click', '.comment-reply', function() {
        var id = $(this).attr('data-id')
        $('.reply-parent-id').val(id);
    });

    $('.reply-comment-save').click(function() {
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: 'POST',
            data: $('.comment-reply-form').serialize(),
            success: function(data) {
                $('#dialog1').modal('hide');
                $('#vote').html(data);
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

    $(document).on('click', '.edit-comment-reply', function() {
        var id = $(this).attr('data-id');
        var idChildren = $(this).attr('data-id-children');
        $('.edit-reply-parent-id').val(id);
        $('.edit-reply-id').val(idChildren);
    });

    $('.edit-reply-comment-save').click(function() {
        var url = $(this).attr('data-url');
        $.ajax({
            url: url,
            type: 'POST',
            data: $('.edit-comment-reply-form').serialize(),
            success: function(data) {
                $('#dialog2').modal('hide');
                $('#vote').html(data);
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

    $(document).on('click', '.delete-reply-comment', function() {
        var mess = $(this).attr('data-mess');
        var url = $(this).attr('data-url');
        var idChildren = $(this).attr('data-id');
        Swal.fire({
            title: 'delete',
            text: mess,
            type: 'error',
            preConfirm: () => {
                $.ajax({
                    type: 'POST',
                    url: url,
                    data: $('.delete-reply-comment-form-' + idChildren).serialize(),
                }).done(function(res) {
                    $('#vote').html(res);
                });
            },
        })
    });
});
