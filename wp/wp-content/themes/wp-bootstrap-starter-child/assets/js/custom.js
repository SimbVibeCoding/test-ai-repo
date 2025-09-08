jQuery(document).ready(function(){
	jQuery('#slider-home').slick({
		dots: true,
        arrows: false,
		infinite: true,
		speed: 500,
		fade: true,
		cssEase: 'linear',
		autoplay: true,
	});





    function updateStickyState() {
      // Forza sticky su pagine prodotto WooCommerce o dove indicato da classe
      if (jQuery('body').hasClass('always-sticky') || jQuery('body').hasClass('single-product')) {
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
 
  // Aggiunge placeholder ai campi login dentro .home-login
  function addHomeLoginPlaceholders() {
    jQuery('.home-login form').each(function(){
      var $form = jQuery(this);
      var $user = $form.find('input[name="log"], #user_login, input[name="username"], input[type="email"], input[type="text"]');
      var $pass = $form.find('input[name="pwd"], #user_pass, input[name="password"], input[type="password"]');

      if ($user.length) {
        $user.each(function(){
          if (!this.placeholder) {
            this.placeholder = 'Nome utente o email';
          }
        });
      }

      if ($pass.length) {
        $pass.each(function(){
          if (!this.placeholder) {
            this.placeholder = 'Password';
          }
        });
      }
    });
  }

  // Evidenzia "Dubbi?" nei titoli richiesti
  function highlightDubbiHeading() {
    jQuery('h2.wp-block-heading').each(function(){
      var $h2 = jQuery(this);
      if ($h2.find('span.dubbi-highlight').length) return; // già processato

      var text = $h2.text().trim();
      if (text.indexOf('Dubbi?') === 0) {
        var html = $h2.html();
        // Prova a sostituire all'inizio dell'HTML
        var replaced = html.replace(/^(\s*)Dubbi\?/,
          '$1<span class="dubbi-highlight" style="color:#3C3C3B;">Dubbi?</span>'
        );
        if (replaced !== html) {
          $h2.html(replaced);
        } else {
          // Fallback: agisci sul primo text node
          var node = $h2.contents().filter(function(){
            return this.nodeType === 3 && this.nodeValue.trim().length;
          }).first();
          if (node.length) {
            var val = node[0].nodeValue;
            if (val.indexOf('Dubbi?') === 0) {
              var rest = val.substring('Dubbi?'.length);
              var span = jQuery('<span class="dubbi-highlight" style="color:#3C3C3B;">Dubbi?</span>');
              node[0].nodeValue = rest;
              span.insertBefore(node);
            }
          }
        }
      }
    });
  }

  // Esegui al ready e dopo eventuali caricamenti AJAX
  addHomeLoginPlaceholders();
  highlightDubbiHeading();
  jQuery(document).on('ajaxComplete', function(){
    addHomeLoginPlaceholders();
    highlightDubbiHeading();
  });
 


	});



// Open when someone clicks on the span element
