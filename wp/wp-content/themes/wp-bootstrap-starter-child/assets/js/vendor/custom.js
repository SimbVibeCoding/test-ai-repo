jQuery(document).ready(function(){
	jQuery('#rotator').slick({
		dots: false,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
	});

	jQuery('#carousel').on('init', function(event, slick, direction){
 			jQuery( "#carousel .slick-slide > div" ).addClass( "image-box" );
	});


  jQuery('.home .products').slick(
		{
  speed: 300,
  slidesToShow: 5,
  slidesToScroll: 1,
	autoplay: true,
  responsive: [
    {
      breakpoint: 1284,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1,
        infinite: true,
        autoplay: true
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 1,
				infinite: true,
				autoplay: true
      }
    },
    {
      breakpoint: 480,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1,
				infinite: true,
				autoplay: true
      }
    }
		]
	}
		);

    jQuery('.product').matchHeight();
    jQuery('.info-box ').matchHeight({
					property: 'height',
		});
    jQuery( '.footer-widgets' ).wrap( '<div class="footer-wrap"></div>' );
    jQuery( '.site-info' ).wrap( '<div class="site-info-wrap"></div>' );

  /*
	  jQuery('#carousel .slick-slide').matchHeight();
    jQuery('.product-category a img').matchHeight();
    jQuery('.box-centrali .widget-single').matchHeight();
    jQuery('.page-template .content img').matchHeight();
    jQuery('.page-template-contatti .contatti-page').matchHeight();
    jQuery('.box-list .single-box .widget_media_image').matchHeight();
    jQuery('.contatti-text').matchHeight();
	jQuery(".reset_variations").click(function(){
	    jQuery(".woocommerce-variation-description p").slideToggle(1000);
	});
	*/

	jQuery(".toggle-menu-mobile").click(function(){
		jQuery(this).toggleClass('opened')
		jQuery(".menu-primary-menu-container").slideToggle(1000);
	});

});


// Open when someone clicks on the span element

function openNav() {
    document.getElementById("main-nav").style.width = "100%";
}
// Close when someone clicks on the "x" symbol inside the overlay
function closeNav() {
    document.getElementById("main-nav").style.width = "0%";
}
