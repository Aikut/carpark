
$(document).ready(function(){
    $('.owl-three').owlCarousel({
        loop:true,
        nav:false,
        items:3,
        center:true,
        dots:true,
        margin:50,
        paginationNumbers:true,
    });

});

$(document).ready(function () {

    $('.opinion-carousel').slick({
        fade: true,
        speed: 700
    });

    $('.stage-carousel').slick({
        fade: false
    });

    $('.blog-carousel').slick({
        infinite: true,
        slidesToShow: 3,
        slidesToScroll: 3,
        dots: true,
        arrows: false,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 3,
                    slidesToScroll: 3,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }
            // You can unslick at a given breakpoint now by adding:
            // settings: "unslick"
            // instead of a settings object
        ]
    }

    );

    if ( $('.product__slider-main').length ) {
        var $slider = $('.product__slider-main')
            .on('init', function(slick) {
                $('.product__slider-main').fadeIn(1000);
            })
            .slick({
                slidesToShow: 1,
                slidesToScroll: 1,
                arrows: true,
                autoplay: true,
                lazyLoad: 'ondemand',
                autoplaySpeed: 3000,
                asNavFor: '.product__slider-thmb'
            });

        var $slider2 = $('.product__slider-thmb')
            .on('init', function(slick) {
                $('.product__slider-thmb').fadeIn(1000);
            })
            .slick({
                slidesToShow: 4,
                slidesToScroll: 1,
                lazyLoad: 'ondemand',
                asNavFor: '.product__slider-main',
                dots: false,
                centerMode: false,
                focusOnSelect: true
            });

        //remove active class from all thumbnail slides
        $('.product__slider-thmb .slick-slide').removeClass('slick-active');

        //set active class to first thumbnail slides
        $('.product__slider-thmb .slick-slide').eq(0).addClass('slick-active');

        // On before slide change match active thumbnail to current slide
        $('.product__slider-main').on('beforeChange', function (event, slick, currentSlide, nextSlide) {
            var mySlideNumber = nextSlide;
            $('.product__slider-thmb .slick-slide').removeClass('slick-active');
            $('.product__slider-thmb .slick-slide').eq(mySlideNumber).addClass('slick-active');
        });


        // init slider
        require(['js-sliderWithProgressbar'], function(slider) {

            $('.product__slider-main').each(function() {

                me.slider = new slider($(this), options, sliderOptions, previewSliderOptions);

                // stop slider
                //me.slider.stop();

                // start slider
                //me.slider.start(index);

                // get reference to slick slider
                //me.slider.getSlick();

            });
        });
        var options = {
            progressbarSelector    : '.bJS_progressbar'
            , slideSelector        : '.bJS_slider'
            , previewSlideSelector : '.bJS_previewSlider'
            , progressInterval     : ''
            // add your own progressbar animation function to sync it i.e. with a video
            // function will be called if the current preview slider item (".b_previewItem") has the data-customprogressbar="true" property set
            , onCustomProgressbar : function($slide, $progressbar) {}
        }

        // slick slider options
        // see: https://kenwheeler.github.io/slick/
        var sliderOptions = {
            slidesToShow   : 1,
            slidesToScroll : 1,
            arrows         : false,
            fade           : true,
            autoplay       : true
        }

        // slick slider options
        // see: https://kenwheeler.github.io/slick/
        var previewSliderOptions = {
            slidesToShow   : 3,
            slidesToScroll : 1,
            dots           : false,
            focusOnSelect  : true,
            centerMode     : true
        }
    }


  clickModal();

 }
);

$(document).ready(function () {
    var menu = $('.take-fixed-pos');
    var left = $('.left-side-menu');
    var origOffsetY = menu.offset().top;

    function scroll() {
        if ($(window).scrollTop() >= origOffsetY) {
            $('.left-side-nav').addClass('fixed-info');
        } else {
            $('.left-side-nav').removeClass('fixed-info');
        }
    }

    document.onscroll = scroll;

});

function showCitizenArea() {
    var checkBox = document.getElementById("citizen");
    var text = document.getElementById("hide-content");
    if (checkBox.checked == true){
        text.style.display = "block";
    } else {
        text.style.display = "none";
    }
}

function getHomeNumber(id) {
  $.ajax({
    type: "POST",
    dataType: "html",
    url: Routing.generate('get_home_number', {id: id}),
    success: function (data) {
      $('#homeNumbers').html(data);
    }
  });
}

function extraActivity(name) {
    $('#extraActivities').val("");
  $.ajax({
    type: "POST",
    dataType: "html",
    url: Routing.generate('add_extra_activity', {name: name}),
    success: function (data) {
      $('#other').append(data);
    }
  });
}



