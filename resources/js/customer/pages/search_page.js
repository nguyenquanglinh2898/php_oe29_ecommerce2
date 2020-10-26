$(document).ready(function(){
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
});
