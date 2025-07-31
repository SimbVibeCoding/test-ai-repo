jQuery(document).ready(function(){
	jQuery('#slider-home').slick({
		dots: false,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
		autoplay: true,
	});

	jQuery('#carousel').on('init', function(event, slick, direction){
 			jQuery( "#carousel .slick-slide > div" ).addClass( "image-box" );
	});


  jQuery('#carousel-home .row .container').slick({
  speed: 300,
  slidesToShow:5,
  slidesToScroll: 1,
	infinite: true,
	autoplay: true,
	responsive: [
    {
      breakpoint: 1240,
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
	});
});


// Open when someone clicks on the span element
