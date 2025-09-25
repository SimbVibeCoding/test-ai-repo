jQuery(document).ready(function(){



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
      if ($h2.find('span.dubbi-highlight').length) return; // gia processato

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
 


	
  function closeMobileMenu(next) {
    var $containers = jQuery('.wp-block-navigation__responsive-container.is-menu-open');

    if (!$containers.length) {
      if (typeof next === 'function') {
        next();
      }
      return;
    }

    var $closeButton = $containers.find('.wp-block-navigation__responsive-container-close').first();

    if ($closeButton.length) {
      $closeButton.trigger('click');
      setTimeout(function(){
        if (typeof next === 'function') {
          next();
        }
      }, 250);
    } else if (typeof next === 'function') {
      next();
    }
  }

  function getIconSvg(type) {
    var icons = {
      account: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.5" fill="none"></circle><path d="M4.75 19.25c0-3.75 3.25-5.75 7.25-5.75s7.25 2 7.25 5.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"></path></svg>',
      search: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5" fill="none"></circle><line x1="15.5" y1="15.5" x2="20" y2="20" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></line></svg>',
      language: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="false"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5" fill="none"></circle><path d="M3 12h18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path><path d="M12 3c3 3 3 15 0 18" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill="none"></path></svg>'
    };

    return icons[type] || '';
  }

  function createIconLink(type, href, label) {
    var $link = jQuery('<a class="mobile-menu__icon mobile-menu__icon--' + type + '" aria-label="' + label + '"></a>');
    $link.attr('href', href || '#');
    $link.append(getIconSvg(type));
    return $link;
  }

  function buildMobileMenuIcons($icons, accountUrl) {
    if (accountUrl) {
      $icons.append(createIconLink('account', accountUrl, 'Vai al tuo account'));
    }

    var $searchLink = createIconLink('search', '#', 'Apri la ricerca');
    $searchLink.attr({
      'data-open-search-panel': 'true',
      'role': 'button'
    });
    $icons.append($searchLink);

    var $languageSource = jQuery('#header .wpml-language-switcher-block').first();
    if ($languageSource.length) {
      var $languageWrapper = jQuery('<div class="mobile-menu__icon mobile-menu__icon--language"></div>');
      var $languageToggle = jQuery('<button type="button" class="mobile-menu__language-toggle" aria-label="Cambia lingua" aria-expanded="false"></button>');
      $languageToggle.append(getIconSvg('language'));
      $languageWrapper.append($languageToggle);

      var $languageClone = $languageSource.clone(true);
      $languageClone.removeAttr('id');
      $languageClone.addClass('mobile-menu__language-dropdown');
      $languageWrapper.append($languageClone);

      $icons.append($languageWrapper);
    }
  }

  function initRicercaToggle(){
    var $trigger = jQuery('#ricerca');
    var $panel = jQuery('#ricerca-panel');

    if (!$trigger.length || !$panel.length) {
      return;
    }

    var animationSpeed = 220;
    var $close = $panel.find('.header-search-panel__close');
    var $input = $panel.find('#ricerca-input');
    var $form = $panel.find('.header-search-panel__form');

    if (!$trigger.attr('aria-controls')) {
      $trigger.attr('aria-controls', 'ricerca-panel');
    }
    if (!$trigger.attr('aria-expanded')) {
      $trigger.attr('aria-expanded', 'false');
    }
    if (!$panel.attr('role')) {
      $panel.attr('role', 'region');
    }

    $panel.attr('aria-hidden', 'true');

    function focusInput() {
      if (!$input.length) {
        return;
      }
      setTimeout(function(){
        $input.trigger('focus');
      }, animationSpeed);
    }

    function openPanel() {
      if ($panel.hasClass('is-open') || $panel.is(':animated')) {
        focusInput();
        return;
      }
      $panel.addClass('is-open').attr('aria-hidden', 'false').stop(true, true).slideDown(animationSpeed, focusInput);
      $trigger.attr('aria-expanded', 'true');
    }

    function closePanel(restoreFocus) {
      if (!$panel.hasClass('is-open')) {
        return;
      }
      $panel.stop(true, true).slideUp(animationSpeed, function(){
        $panel.removeClass('is-open');
        $panel.attr('aria-hidden', 'true');
        if (restoreFocus) {
          $trigger.trigger('focus');
        }
      });
      $trigger.attr('aria-expanded', 'false');
    }

    function togglePanel() {
      if ($panel.hasClass('is-open')) {
        closePanel(false);
      } else {
        openPanel();
      }
    }

    $trigger.on('click', function(event){
      event.preventDefault();
      togglePanel();
    });

    $close.on('click', function(event){
      event.preventDefault();
      closePanel(true);
    });

    jQuery(document).on('click', function(event){
      if (!$panel.hasClass('is-open')) {
        return;
      }
      var $target = jQuery(event.target);
      if ($target.closest('#ricerca-panel').length || $target.closest('#ricerca').length) {
        return;
      }
      closePanel(false);
    });

    jQuery(document).on('keydown', function(event){
      if (event.key === 'Escape') {
        closePanel(true);
      }
    });

    if ($form.length) {
      $form.on('submit', function(){
        closePanel(false);
      });
    }

    jQuery(document).on('click', '[data-open-search-panel]', function(event){
      event.preventDefault();
      closeMobileMenu(function(){
        openPanel();
      });
    });
  }

  function initMobileMenuEnhancements(){
    var $mobileData = jQuery('#mobile-menu-data');
    var $nav = jQuery('#header .wp-block-navigation').first();

    if (!$mobileData.length || !$nav.length) {
      return;
    }

    var accountUrl = $mobileData.data('mobile-account') || '';
    var brandText = $mobileData.data('mobile-brand') || '';

    var applyEnhancements = function(){
      var $responsiveContent = $nav.find('.wp-block-navigation__responsive-container-content').first();
      if (!$responsiveContent.length) {
        return;
      }

      if (!$responsiveContent.find('.mobile-menu__brand').length) {
        var $brandWrapper = jQuery('<div class="mobile-menu__brand"></div>');
        var $logo = jQuery('#header .wp-block-image').first().clone(true);
        if ($logo.length) {
          $brandWrapper.append($logo);
        } else if (brandText) {
          $brandWrapper.append(jQuery('<span class="mobile-menu__brand-text"></span>').text(brandText));
        }
        $responsiveContent.prepend($brandWrapper);
      }

      if (!$responsiveContent.find('.mobile-menu__icons').length) {
        var $icons = jQuery('<div class="mobile-menu__icons" role="group" aria-label="Collegamenti rapidi"></div>');
        buildMobileMenuIcons($icons, accountUrl);
        $responsiveContent.append($icons);
      }

      var $container = $nav.find('.wp-block-navigation__responsive-container').first();
      if ($container.length && !$container.data('mobileMenuObserver') && window.MutationObserver) {
        var observer = new MutationObserver(function(){
          var isOpen = $container.hasClass('is-menu-open') && !$container.is('[hidden]');
          jQuery('body').toggleClass('mobile-menu-open', isOpen);
        });
        observer.observe($container[0], { attributes: true, attributeFilter: ['class', 'hidden'] });
        $container.data('mobileMenuObserver', observer);
      }
    };

    applyEnhancements();

    jQuery(document).on('click', '.wp-block-navigation__responsive-container-open', function(){
      setTimeout(applyEnhancements, 10);
    });
  }

  initRicercaToggle();
  initMobileMenuEnhancements();

  jQuery(document).on('click', '.mobile-menu__language-toggle', function(){
    var $button = jQuery(this);
    var expanded = $button.attr('aria-expanded') === 'true';
    $button.attr('aria-expanded', expanded ? 'false' : 'true');
    $button.closest('.mobile-menu__icon--language').toggleClass('is-open', !expanded);
  });

});



// Open when someone clicks on the span element
