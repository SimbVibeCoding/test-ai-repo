jQuery(document).ready(function(){
	jQuery('#slider-home').slick({
		dots: false,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
		autoplay: true,
	});





    function updateStickyState() {
      // Se siamo sulla pagina con body.page-id-808
      if (jQuery('body').hasClass('always-sticky')) {
          jQuery('#header').addClass('sticky');
          // Disattiva il controllo scroll
          return;
      }
  
      // Comportamento dinamico per tutte le altre pagine
      if (jQuery(window).scrollTop() > 0) {
          jQuery('#header').addClass('sticky');
      } else {
          jQuery('#header').removeClass('sticky');
      }
  }
  
  // Inizializza sempre al load
  jQuery(window).on('load scroll resize', updateStickyState);  
 


	});



// Open when someone clicks on the span element
