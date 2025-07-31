/**
 * main.js
 * http://www.codrops.com
 *
 * Licensed under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Copyright 2016, Codrops
 * http://www.codrops.com
 */
;
(function(window) {
  'use strict';
  //console.log(document.querySelector('.search').querySelector('.search__input'));

  var openCtrl = document.getElementById('btn-search'),
  openCtrlMobile = document.querySelector('.storefront-handheld-footer-bar .search a'),
    closeCtrl = document.getElementById('btn-search-close'),
    searchContainer = document.querySelector('.search-form-custom'),
    inputSearch = searchContainer.querySelector('.search__input');

  function init() {
    initEvents();
  }

  function initEvents() {

    openCtrl.addEventListener('click', function(e){openSearch(e)});
    openCtrlMobile.addEventListener('click', function(e){openSearch(e)});
    closeCtrl.addEventListener('click', function(e){closeSearch(e)});
    document.addEventListener('keyup', function(ev) {
      // escape key.
      if (ev.keyCode == 27) {
        closeSearch();
      }
    });
  }

  function openSearch(e) {
    console.log (e)
    searchContainer.classList.add('search--open');
    inputSearch.focus();
    e.preventDefault()
  }

  function closeSearch(e) {
    searchContainer.classList.remove('search--open');
    inputSearch.blur();
    inputSearch.value = '';
  }

  init();

})(window);
