jQuery(function ($) {

    var MOBILE_MENU_MAX_WIDTH = 450;
    var mobileMenuEnhancementsEnabled = false;
    var mobileMenuEnhancementsInitialized = false;

    function initProductGalleryThumbSlider(
        $scope
    ) {
        var $context = $scope && $scope.length ? $scope : $(document);
        var $galleries = $context.is('.product-gallery')
            ? $context
            : $context.find('.product-gallery');

        if (!$galleries.length) {
            return;
        }

        $galleries.each(function () {
            var $gallery = $(this);
            var $navItems = $gallery.find('ol.flex-control-nav');

            if (!$navItems.length) {
                var attempts = $gallery.data('thumbSlickAttempts') || 0;

                if (attempts < 6) {
                    $gallery.data('thumbSlickAttempts', attempts + 1);

                    setTimeout(function () {
                        initProductGalleryThumbSlider($gallery);
                    }, 120);
                }

                return;
            }

            $gallery.removeData('thumbSlickAttempts');

            $navItems.each(function () {
                var $nav = $(this);
                var itemCount = $nav.children().length;
                var baseSlides = itemCount >= 4 ? 4 : itemCount || 1;

                if ($nav.hasClass('slick-initialized')) {
                    $nav.slick('refresh');
                    return;
                }

                $nav.slick({
                    dots: false,
                    infinite: itemCount > baseSlides,
                    arrows: true,
                    speed: 500,
                    slidesToShow: baseSlides,
                    slidesToScroll: 1,
                    autoplay: false,                   
                });
            });
        });
    }

    // Inizializza Slick sui thumbnails quando WooCommerce rende la gallery
    initProductGalleryThumbSlider();

    $(window).on('load', function () {
        initProductGalleryThumbSlider();
    });

    $(document.body).on(
        'wc-product-gallery-after-init',
        '.woocommerce-product-gallery',
        function () {
            var $galleryWrapper = $(this).closest('.product-gallery');
            var $scope = $galleryWrapper.length ? $galleryWrapper : $(this);

            setTimeout(function () {
                initProductGalleryThumbSlider($scope);
            }, 100);
        }
    );

    $(document.body).on(
        'found_variation.wc-variation-form reset_image',
        function () {
            setTimeout(function () {
                initProductGalleryThumbSlider();
            }, 100);
        }
    );

    var $slider = $('#home-nuoviprodotti .products, .related-by-category .products');

    function initSlider() {
        if ($(window).width() < 576) {
            if (!$slider.hasClass('slick-initialized')) {
                $slider.slick({
                    dots: false,
                    infinite: true,
                    arrows: true,
                    speed: 500,
                    slidesToShow: 1,
                    slidesToScroll: 1,
                    fade: true,
                    cssEase: 'linear',
                    autoplay: true,
                    autoplaySpeed: 2500
                });
            }
        } else if ($slider.hasClass('slick-initialized')) {
            $slider.slick('unslick');
        }
    }

    // Al load
    initSlider();

    // Al resize
    $(window).on('resize', function () {
        initSlider();
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
        jQuery('.home-login form').each(function () {
            var $form = jQuery(this);
            var $user = $form.find(
                'input[name="log"], #user_login, input[name="username"], input[type="email"], i' +
                'nput[type="text"]'
            );
            var $pass = $form.find(
                'input[name="pwd"], #user_pass, input[name="password"], input[type="password"]'
            );

            if ($user.length) {
                $user.each(function () {
                    if (!this.placeholder) {
                        this.placeholder = 'Nome utente o email';
                    }
                });
            }

            if ($pass.length) {
                $pass.each(function () {
                    if (!this.placeholder) {
                        this.placeholder = 'Password';
                    }
                });
            }
        });
    }

    // Evidenzia "Dubbi?" nei titoli richiesti
    function highlightDubbiHeading() {
        jQuery('h2.wp-block-heading').each(function () {
            var $h2 = jQuery(this);
            if ($h2.find('span.dubbi-highlight').length) 
                return; // gia processato
            
            var text = $h2
                .text()
                .trim();
            if (text.indexOf('Dubbi?') === 0) {
                var html = $h2.html();
                // Prova a sostituire all'inizio dell'HTML
                var replaced = html.replace(
                    /^(\s*)Dubbi\?/,
                    '$1<span class="dubbi-highlight" style="color:#3C3C3B;">Dubbi?</span>'
                );
                if (replaced !== html) {
                    $h2.html(replaced);
                } else {
                    // Fallback: agisci sul primo text node
                    var node = $h2
                        .contents()
                        .filter(function () {
                            return this.nodeType === 3 && this
                                .nodeValue
                                .trim()
                                .length;
                        })
                        .first();
                    if (node.length) {
                        var val = node[0].nodeValue;
                        if (val.indexOf('Dubbi?') === 0) {
                            var rest = val.substring('Dubbi?'.length);
                            var span = jQuery(
                                '<span class="dubbi-highlight" style="color:#3C3C3B;">Dubbi?</span>'
                            );
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
    jQuery(document).on('ajaxComplete', function () {
        addHomeLoginPlaceholders();
        highlightDubbiHeading();
    });

    function closeMobileMenu(next) {
        var $containers = jQuery(
            '.wp-block-navigation__responsive-container.is-menu-open'
        );

        var finalize = function () {
            var $currentContainers = jQuery('.wp-block-navigation__responsive-container');
            var $toggleButtons = jQuery('.wp-block-navigation__responsive-container-open');

            if ($currentContainers.length) {
                $currentContainers
                    .removeClass('is-menu-open')
                    // .attr('hidden', 'hidden');
            }

            if ($toggleButtons.length) {
                $toggleButtons.each(function () {
                    var $btn = jQuery(this);
                    var openLabel = $btn.attr('data-mobile-menu-label-open') || 'Apri menu';
                    $btn.removeClass('is-active');
                    $btn.attr({'aria-expanded': 'false', 'aria-label': openLabel});
                });
            }

            jQuery('body').removeClass('mobile-menu-open');

            if (typeof next === 'function') {
                next();
            }
        };

        if (!$containers.length) {
            finalize();
            return;
        }

        var $closeButton = $containers
            .find(
                '.wp-block-navigation__responsive-container-close'
            )
            .first();

        if ($closeButton.length) {
            $closeButton.trigger('click');
            setTimeout(finalize, 250);
        } else {
            finalize();
        }
    }

    function getIconSvg(type) {
        var icons = {
            account: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="' +
                    'false"><circle cx="12" cy="8" r="3.5" stroke="currentColor" stroke-width="1.5"' +
                    ' fill="none"></circle><path d="M4.75 19.25c0-3.75 3.25-5.75 7.25-5.75s7.25 2 7' +
                    '.25 5.75" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" fill' +
                    '="none"></path></svg>',
            search: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="' +
                    'false"><circle cx="11" cy="11" r="6" stroke="currentColor" stroke-width="1.5" ' +
                    'fill="none"></circle><line x1="15.5" y1="15.5" x2="20" y2="20" stroke="current' +
                    'Color" stroke-width="1.5" stroke-linecap="round"></line></svg>',
            language: '<svg width="24" height="24" viewBox="0 0 24 24" aria-hidden="true" focusable="' +
                    'false"><circle cx="12" cy="12" r="9" stroke="currentColor" stroke-width="1.5" ' +
                    'fill="none"></circle><path d="M3 12h18" stroke="currentColor" stroke-width="1.' +
                    '5" stroke-linecap="round"></path><path d="M12 3c3 3 3 15 0 18" stroke="current' +
                    'Color" stroke-width="1.5" stroke-linecap="round" fill="none"></path></svg>'
        };

        return icons[type] || '';
    }

    function createIconLink(type, href, label) {
        var $link = jQuery(
            '<a class="mobile-menu__icon mobile-menu__icon--' + type + '" aria-label="' +
            label + '"></a>'
        );
        $link.attr('href', href || '#');
        $link.append(getIconSvg(type));
        return $link;
    }

    function buildMobileMenuIcons($icons, accountUrl, extraUrl, extraLabel) {
        var accountHref = accountUrl || '#';
        $icons.append(createIconLink('account', accountHref, 'Vai al tuo profilo'));

        var $searchLink = createIconLink('search', '#', 'Apri la ricerca');
        $searchLink.attr({'data-open-search-panel': 'true', 'role': 'button'});
        $icons.append($searchLink);

        var extraHref = extraUrl || '#';
        var extraText = extraLabel || 'Cambia lingua';
        $icons.append(createIconLink('language', extraHref, extraText));
    }

    function initRicercaToggle() {
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
            setTimeout(function () {
                $input.trigger('focus');
            }, animationSpeed);
        }

        function openPanel() {
            if ($panel.hasClass('is-open') || $panel.is(':animated')) {
                focusInput();
                return;
            }
            $panel
                .addClass('is-open')
                .attr('aria-hidden', 'false')
                .stop(true, true)
                .slideDown(animationSpeed, focusInput);
            $trigger.attr('aria-expanded', 'true');
        }

        function closePanel(restoreFocus) {
            if (!$panel.hasClass('is-open')) {
                return;
            }
            $panel
                .stop(true, true)
                .slideUp(animationSpeed, function () {
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

        $trigger.on('click', function (event) {
            event.preventDefault();
            togglePanel();
        });

        $close.on('click', function (event) {
            event.preventDefault();
            closePanel(true);
        });

        jQuery(document).on('click', function (event) {
            if (!$panel.hasClass('is-open')) {
                return;
            }
            var $target = jQuery(event.target);
            if ($target.closest('#ricerca-panel').length || $target.closest('#ricerca').length) {
                return;
            }
            closePanel(false);
        });

        jQuery(document).on('keydown', function (event) {
            if (event.key === 'Escape') {
                closePanel(true);
            }
        });

        if ($form.length) {
            $form.on('submit', function () {
                closePanel(false);
            });
        }

        jQuery(document).on('click', '[data-open-search-panel]', function (event) {
            event.preventDefault();
            closeMobileMenu(function () {
                openPanel();
            });
        });
    }

    function initMobileMenuEnhancements() {
        if (!mobileMenuEnhancementsEnabled) {
            return;
        }

        var $mobileData = jQuery('#mobile-menu-data');
        var $nav = jQuery('#header .wp-block-navigation').first();

        if (!$mobileData.length || !$nav.length) {
            return;
        }

        var accountUrl = $mobileData.data('mobile-account') || '';
        var brandText = $mobileData.data('mobile-brand') || '';
        var logoUrl = $mobileData.data('mobile-logo') || '';
        var logoAlt = $mobileData.data('mobile-logo-alt') || brandText || '';
        var logoLink = $mobileData.data('mobile-logo-link') || '';
        var extraUrl = $mobileData.data('mobile-extra') || '#';
        var extraLabel = $mobileData.data('mobile-extra-label') || '';
        var $toggle = $nav
            .find('.wp-block-navigation__responsive-container-open')
            .first();
        var toggleLabelOpen = 'Apri menu';
        var toggleLabelClose = 'Chiudi menu';

        if ($toggle.length) {
            if ($toggle.attr('aria-label')) {
                toggleLabelOpen = $toggle.attr('aria-label');
            }
            $toggle.attr({'aria-expanded': 'false', 'aria-label': toggleLabelOpen});
            $toggle.attr('data-mobile-menu-label-open', toggleLabelOpen);
            $toggle.attr('data-mobile-menu-label-close', toggleLabelClose);
        }

        var updateMenuState = function ($container) {
            if (!mobileMenuEnhancementsEnabled) {
                jQuery('body').removeClass('mobile-menu-open');
                if ($toggle.length) {
                    $toggle.removeClass('is-active');
                    $toggle.attr('aria-expanded', 'false');
                    $toggle.attr('aria-label', toggleLabelOpen);
                }
                return;
            }

            if (!$container || !$container.length) {
                jQuery('body').removeClass('mobile-menu-open');
                if ($toggle.length) {
                    $toggle.removeClass('is-active');
                    $toggle.attr('aria-expanded', 'false');
                    $toggle.attr('aria-label', toggleLabelOpen);
                }
                return;
            }

            var isOpen = $container.hasClass('is-menu-open') && !$container.is('[hidden]');
            jQuery('body').toggleClass('mobile-menu-open', isOpen);

            if ($toggle.length) {
                $toggle.toggleClass('is-active', isOpen);
                $toggle.attr(
                    'aria-expanded',
                    isOpen
                        ? 'true'
                        : 'false'
                );
                $toggle.attr(
                    'aria-label',
                    isOpen
                        ? toggleLabelClose
                        : toggleLabelOpen
                );
            }
        };

        var applyEnhancements = function () {
            if (!mobileMenuEnhancementsEnabled) {
                return;
            }

            var $responsiveContent = $nav
                .find(
                    '.wp-block-navigation__responsive-container-content'
                )
                .first();
            var $container = $nav
                .find('.wp-block-navigation__responsive-container')
                .first();

            if (!$responsiveContent.length) {
                updateMenuState($container);
                return;
            }

            if (!$responsiveContent.find('.mobile-menu__brand').length) {
                var $brandWrapper = jQuery('<div class="mobile-menu__brand"></div>');
                var hasContent = false;

                if (logoUrl) {
                    var $logoElement = jQuery(
                        '<img class="mobile-menu__brand-image" alt="" loading="lazy">'
                    );
                    $logoElement.attr('src', logoUrl);
                    if (logoAlt) {
                        $logoElement.attr('alt', logoAlt);
                    }
                    var $logoContainer = $logoElement;
                    var targetLogoLink = logoLink || '/';
                    if (targetLogoLink) {
                        $logoContainer = jQuery('<a class="mobile-menu__brand-link"></a>').attr(
                            'href',
                            targetLogoLink
                        );
                        $logoContainer.append($logoElement);
                    }
                    $brandWrapper.append($logoContainer);
                    hasContent = true;
                }

                if (brandText) {
                    $brandWrapper.append(
                        jQuery('<span class="mobile-menu__brand-text"></span>').text(brandText)
                    );
                    hasContent = true;
                }

                if (!hasContent) {
                    var $fallbackLogo = jQuery('#header .wp-block-image')
                        .first()
                        .clone(true);
                    if ($fallbackLogo.length) {
                        $brandWrapper.append($fallbackLogo);
                    }
                }

                if ($brandWrapper.children().length) {
                    $responsiveContent.prepend($brandWrapper);
                }
            }

            if (!$responsiveContent.find('.mobile-menu__icons').length) {
                var $icons = jQuery(
                    '<div class="mobile-menu__icons" role="group" aria-label="Collegamenti rapidi">' +
                    '</div>'
                );
                buildMobileMenuIcons($icons, accountUrl, extraUrl, extraLabel);
                $responsiveContent.append($icons);
            }

            if ($container.length) {
                updateMenuState($container);

                if (!$container.data('mobileMenuObserver') && window.MutationObserver) {
                    var observer = new MutationObserver(function () {
                        updateMenuState($container);
                    });
                    observer.observe($container[0], {
                        attributes: true,
                        attributeFilter: ['class', 'hidden']
                    });
                    $container.data('mobileMenuObserver', observer);
                }
            } else {
                updateMenuState(null);
            }
        };

        applyEnhancements();

        if (mobileMenuEnhancementsInitialized) {
            return;
        }

        mobileMenuEnhancementsInitialized = true;

        jQuery(document).on(
            'click',
            '.wp-block-navigation__responsive-container-open',
            function () {
                setTimeout(applyEnhancements, 10);
            }
        );

        jQuery(document).on(
            'click',
            '.wp-block-navigation__responsive-container-close',
            function () {
                setTimeout(applyEnhancements, 10);
            }
        );
    }

    initRicercaToggle();

    var mobileMenuQuery = window.matchMedia('(max-width: ' + MOBILE_MENU_MAX_WIDTH + 'px)');

    function handleMobileMenuQuery(event) {
        mobileMenuEnhancementsEnabled = event.matches;

        if (mobileMenuEnhancementsEnabled) {
            initMobileMenuEnhancements();
            return;
        }

        closeMobileMenu();
    }

    handleMobileMenuQuery(mobileMenuQuery);

    if (typeof mobileMenuQuery.addEventListener === 'function') {
        mobileMenuQuery.addEventListener('change', handleMobileMenuQuery);
    } else if (typeof mobileMenuQuery.addListener === 'function') {
        mobileMenuQuery.addListener(handleMobileMenuQuery);
    }

});

// Open when someone clicks on the span element
document.addEventListener('DOMContentLoaded', function () {
    // Trasforma ogni .tablepress in blocchi-card (una volta sola)
    document.querySelectorAll('.tablepress').forEach(function(table, tIndex){
      if (table.dataset.tpBuilt === '1') return;
  
      // 1) Prendi le etichette dalle TH (fallback: prima riga TBODY)
      let labels = [];
      const ths = table.querySelectorAll('thead th');
      if (ths.length){
        labels = Array.from(ths).map(th => th.textContent.trim());
      } else {
        const firstRow = table.querySelector('tbody tr');
        if (firstRow){
          labels = Array.from(firstRow.children).map(td => td.textContent.trim());
        }
      }
      if (!labels.length) return;
  
      // 2) Crea contenitore cards dopo la tabella
      const cards = document.createElement('div');
      cards.className = 'tp-cards';
      cards.setAttribute('aria-hidden','true'); // è solo una resa alternativa
      table.insertAdjacentElement('afterend', cards);
  
      // 3) Per ogni riga del TBODY crea una card (2 colonne: labels/values)
      table.querySelectorAll('tbody tr').forEach(function(row){
        const tds = Array.from(row.children);
        if (!tds.length) return;
  
        const card = document.createElement('div');
        card.className = 'tp-card';
  
        const grid = document.createElement('div');
        grid.className = 'tp-card-grid';
  
        const colLabels = document.createElement('div');
        colLabels.className = 'tp-col tp-labels';
  
        const colValues = document.createElement('div');
        colValues.className = 'tp-col tp-values';
  
        labels.forEach(function(lbl, i){
          const labDiv = document.createElement('div');
          labDiv.className = 'tp-item';
          labDiv.textContent = lbl;
          colLabels.appendChild(labDiv);
  
          const valDiv = document.createElement('div');
          valDiv.className = 'tp-item';
          valDiv.textContent = (tds[i] ? tds[i].textContent.trim() : '');
          colValues.appendChild(valDiv);
        });
  
        grid.appendChild(colLabels);
        grid.appendChild(colValues);
        card.appendChild(grid);
        cards.appendChild(card);
      });
  
      // 4) Marca come costruita e collega cards alla tabella
      table.dataset.tpBuilt = '1';
      table.dataset.tpCardsId = 'tp-cards-' + tIndex;
      cards.id = table.dataset.tpCardsId;
    });
  
    // 5) (Opzionale) toggle ARIA per accessibilità in base alla larghezza
    function updateARIA(){
      const isMobile = window.innerWidth <= 450;
      document.querySelectorAll('.tablepress').forEach(t => t.removeAttribute('aria-hidden'));
      document.querySelectorAll('.tp-cards').forEach(c => c.removeAttribute('aria-hidden'));
      if (isMobile){
        document.querySelectorAll('.tp-cards').forEach(c => c.setAttribute('aria-hidden','false'));
        document.querySelectorAll('.tablepress').forEach(t => t.setAttribute('aria-hidden','true'));
      } else {
        document.querySelectorAll('.tp-cards').forEach(c => c.setAttribute('aria-hidden','true'));
        document.querySelectorAll('.tablepress').forEach(t => t.setAttribute('aria-hidden','false'));
      }
    }
    updateARIA();
    window.addEventListener('resize', updateARIA);
  });











