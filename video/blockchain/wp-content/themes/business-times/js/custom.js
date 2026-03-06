/**
 * File skip-link-focus-fix.js.
 *
 * Helps with accessibility for keyboard only users.
 *
 * Learn more: https://git.io/vWdr2
 */
( function() {
    var isIe = /(trident|msie)/i.test( navigator.userAgent );

    if ( isIe && document.getElementById && window.addEventListener ) {
        window.addEventListener( 'hashchange', function() {
            var id = location.hash.substring( 1 ),
                element;

            if ( ! ( /^[A-z0-9_-]+$/.test( id ) ) ) {
                return;
            }

            element = document.getElementById( id );

            if ( element ) {
                if ( ! ( /^(?:a|select|input|button|textarea)$/i.test( element.tagName ) ) ) {
                    element.tabIndex = -1;
                }

                element.focus();
            }
        }, false );
    }
} )();

jQuery(document).ready(function($){

	  /** Variables from Customizer for Slider settings */
    if( business_times_data.auto == '1' ){
        var slider_auto = true;
    }else{
        slider_auto = false;
    }
    
    if( business_times_data.loop == '1' ){
        var slider_loop = true;
    }else{
        var slider_loop = false;
    }
    
    if( business_times_data.pager == '1' ){
        var slider_control = true;
    }else{
        slider_control = false;
    }


    if( business_times_data.animation == 'fade' ){
        var slider_animation = 'fade';
    }else{
        slider_animation = '';
    }
    
   
    /** Home Page  Banner Slider */
   
	$('.fadeout').owlCarousel({
		items: 1,
		animateOut: slider_animation,// animation
		loop: slider_loop, // loop
		margin: 10,
		nav: true,
		navText:["<i class='fa fa-chevron-left'></i>","<i class='fa fa-chevron-right'></i>"],
		autoplay: slider_auto, //auto play
		dots:  slider_control, //slider control
		slideSpeed       : business_times_data.speed,
		autoplayTimeout: business_times_data.pause
	});

    
    $('.product-slider').owlCarousel({
        loop: true, // loop
        margin: 10,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        autoplay: true, //auto play
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            480:{
                items:2,
                nav:false
            },
            768:{
                items:4,
                nav:true,
                loop:false
            }
        }
    });

    $('.testimonial-slider').owlCarousel({
        thumbs: true,
        loop: true, // loop
        margin: 10,
        nav: true,
        navText: ["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
        autoplay: true, //auto play
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            480:{
                items:1,
                nav:false
            },
            768:{
                items:1,
                nav:true,
                loop:false
            }
        }
    });

    // responsive menu

    $('#responsive-menu-button').sidr({
        name: 'sidr-main',
        source: '#site-navigation',
        side: 'right'
    });

});