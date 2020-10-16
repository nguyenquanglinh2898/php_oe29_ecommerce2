$(document).ready(function(){
    $("#slide-advertise").owlCarousel({
        items: 1,
        autoplay: true,
        autoplayHoverPause: true,
        loop: true,
        nav: true,
        dots: true,
        dotsData: true,
        responsive:{
            0:{
                nav:false,
                dots: false
            },
            641:{
                nav:true,
                dots: true
            }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>'],
        dotsContainer: '.custom-dots-slide-advertises'
    });

    $("#slide-favorite").owlCarousel({
        items: 5,
        autoplay: true,
        autoplayHoverPause: true,
        nav: true,
        dots: false,
        responsive:{
            0:{
                items:1,
                nav:false
            },
            480:{
                items:2,
                nav:false
            },
            769:{
                items:3,
                nav:true
            },
            992:{
                items:4,
                nav:true,
            },
            1200:{
                items:5,
                nav:true
            }
        },
        navText: ['<i class="fas fa-angle-left"></i>', '<i class="fas fa-angle-right"></i>']
    });
});
