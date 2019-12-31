jQuery(document).ready(function ($){

    var brtl;

    if ($("body").hasClass('rtl')) {

        brtl = true;

    }else{

        brtl = false;
    }

    /**
     * Banner Slider
    */
    $(".features-slider").owlCarousel({
       items: 1,
       loop: true,
       smartSpeed: 2000,
       dots: true,
       nav: false,
       autoplay: true,
       mouseDrag: true,
       rtl: brtl,
       responsive: {
          0: {
             nav: false,
             mouseDrag: false,
             touchDrag:false,
          },
          600: {
             nav: false,
             mouseDrag: false,
             touchDrag:false,

          },
          1000: {
             nav: true,
             mouseDrag: true,
             touchDrag:true,

          }
       }
    });


    /**
     * Post Gallery Image Slider ( post format Gallery)
    */
    $(".postgallery-carousel").owlCarousel({
       items: 1,
       loop: true,
       dots: false,
       autoplay: true,
       mouseDrag: true,
       rtl: brtl,
    });


    /**
     * Theia sticky slider
    */
    var sticky_sidebar = businessroy_script.sticky_sidebar;

    if( sticky_sidebar == 'enable' ){
        try{
            $('.content-area').theiaStickySidebar({
                additionalMarginTop: 30
            });

            $('.widget-area').theiaStickySidebar({
                additionalMarginTop: 30
            });
        }
        catch(e){
            //console.log( e );
        }
    }

    /**
     * Video popup
    */
    $('.popup-youtube, .popup-vimeo, .popup-gmaps').magnificPopup({
        disableOn: 700,
        type: 'iframe',
        mainClass: 'mfp-fade',
        removalDelay: 160,
        preloader: false,
        fixedContentPos: false
    });


    /**
     * Isotop Portfolio
    */
    if ($('.businessroyportfolio-posts').length > 0) {

        var first_class = $('.businessroyportfolio-cat-name:first').data('filter');

        var $container = $('.businessroyportfolio-posts').imagesLoaded(function() {

            $container.isotope({
                itemSelector: '.businessroyportfolio',
                filter: first_class
            });

            var elems = $container.isotope('getFilteredItemElements');

            elems.forEach(function(item, index) {
                if (index == 0 || index == 4) {
                    //$(item).addClass('wide');
                    var bg = $(item).find('.businessroyportfolio-image').attr('href');
                    $(item).find('.businessroyportfolio-wrap').css('background-image', 'url(' + bg + ')');
                } else {
                    $(item).removeClass('wide');
                }
            });

            GetMasonary();

            setTimeout(function() {
                $container.isotope({
                    itemSelector: '.businessroyportfolio',
                    filter: first_class,
                });
            }, 2000);

            $(window).on('resize', function() {
                GetMasonary();
            });

        });

        $('.businessroyportfolio-cat-name-list').on('click', '.businessroyportfolio-cat-name', function() {

            $('.businessroyportfolio-cat-name-list').find('.businessroyportfolio-cat-name').removeClass('active');

            var filterValue = $(this).attr('data-filter');

            $container.isotope({
                filter: filterValue
            });

            var elems = $container.isotope('getFilteredItemElements');

            elems.forEach(function(item, index) {
                if (index == 0 || index == 4) {
                    //$(item).addClass('wide');
                    var bg = $(item).find('.businessroyportfolio-image').attr('href');
                    $(item).find('.businessroyportfolio-wrap').css('background-image', 'url(' + bg + ')');
                } else {
                    $(item).removeClass('wide');
                }
            });

            GetMasonary();

            var filterValue = $(this).attr('data-filter');
            $container.isotope({
                filter: filterValue
            });

            $('.businessroyportfolio-cat-name').removeClass('active');
            $(this).addClass('active');
        });

        function GetMasonary() {
            var winWidth = window.innerWidth;
            if (winWidth > 580) {

                $container.find('.businessroyportfolio').each(function() {
                    var image_width = $(this).find('img').width();
                    if ($(this).hasClass('wide')) {
                        $(this).find('.businessroyportfolio-wrap').css({
                            height: (image_width * 2) + 15 + 'px'
                        });
                    } else {
                        $(this).find('.businessroyportfolio-wrap').css({
                            height: image_width + 'px'
                        });
                    }
                });

            } else {
                $container.find('.businessroyportfolio').each(function() {
                    var image_width = $(this).find('img').width();
                    if ($(this).hasClass('wide')) {
                        $(this).find('.businessroyportfolio-wrap').css({
                            height: (image_width * 2) + 8 + 'px'
                        });
                    } else {
                        $(this).find('.businessroyportfolio-wrap').css({
                            height: image_width + 'px'
                        });
                    }
                });
            }
        }

    }


    /**
     * Portfolio Open Light Box
    */
    $('.businessroyportfolio-image').magnificPopup({
        type: 'image',
        closeOnContentClick: true,
        mainClass: 'mfp-img-mobile',
        image: {
            verticalFit: true
        }
    });

    /**
     * Success Product Counter
    */
    $('.businessroyteam-counter-wrap').waypoint(function() {
        setTimeout(function() {
          $('.odometer1').html($('.odometer1').data('count'));
        }, 500);
        setTimeout(function() {
          $('.odometer2').html($('.odometer2').data('count'));
        }, 1000);
        setTimeout(function() {
          $('.odometer3').html($('.odometer3').data('count'));
        }, 1500);
        setTimeout(function() {
          $('.odometer4').html($('.odometer4').data('count'));
        }, 2000);
        setTimeout(function() {
          $('.odometer5').html($('.odometer5').data('count'));
        }, 2500);
        setTimeout(function() {
          $('.odometer6').html($('.odometer6').data('count'));
        }, 3000);
        setTimeout(function() {
          $('.odometer7').html($('.odometer7').data('count'));
        }, 3500);
        setTimeout(function() {
          $('.odometer8').html($('.odometer8').data('count'));
        }, 4000);
    }, {
      offset: 800,
      triggerOnce: true
    });


    /**
     * Masonry Posts Layout
    */
    var grid = document.querySelector(
            '.businessroy-masonry'
        ),
        masonry;

    if (
        grid &&
        typeof Masonry !== undefined &&
        typeof imagesLoaded !== undefined
    ) {
        imagesLoaded( grid, function( instance ) {
            masonry = new Masonry( grid, {
                itemSelector: '.hentry',
                gutter: 15
            } );
        } );
    }

    /**
     * Testimonial
    */
    $('.testimonial_slider').owlCarousel({
        loop: true,
        margin: 10,
        dots: false,
        smartSpeed: 2000,
        autoplay: true,
        autoplayTimeout: 6000,
        items: 3,
        center:true,
        rtl: brtl,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 2
            },
            1000: {
                items: 3
            }
        }
    });


    /**
     * Responsive Menu Toggle
    */
    $('.header-nav-toggle').click(function(){
        $('.header-nav-toggle').toggleClass('on');
        $('.box-header-nav').slideToggle('1000');
    });

    /**
     * Add Icon Sub Menu
    */
    $('.box-header-nav .menu-item-has-children').append('<span class="sub-toggle"><i class="fas fa-plus"></i></span>');
    //$('.box-header-nav .page_item_has_children').append('<span class="sub-toggle-children"> <i class="fas fa-plus"></i> </span>');

    $('.box-header-nav .sub-toggle').click(function () {
        $(this).parent('.menu-item-has-children').children('ul.sub-menu').first().toggle();
        $(this).children('.fa-plus').first().toggleClass('fa-minus');
    });


    /**
     *  search
    */
    $('.search_main_menu a').click(function () {
        $('.ss-content').addClass('ss-content-act');
    });

    $('.ss-close').click(function () {
        $('.ss-content').removeClass('ss-content-act');
    });


});