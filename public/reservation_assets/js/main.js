
jQuery(document).ready(function($) {

    $('#Activity-slider').slick({
        dots: false,
        infinite:true,
        speed: 500,
        loop:true,
        slidesToShow: 3,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 2000,
        arrows: true,
        responsive: [{
            breakpoint: 991,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 1
            }
        },
            {
                breakpoint:768,
                settings: {

                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
    });

    $('.selectpicker').selectpicker();
});