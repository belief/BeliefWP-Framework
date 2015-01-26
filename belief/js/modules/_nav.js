'use strict';

define(['jquery'], function($) {

  var $win, $doc,
      $body = $('body'),
      $main = $('main');

  var toggleMobileMenu = function() {
    $body.toggleClass('is-active');
  };

  var removeMobileMenu = function() {
    $body.removeClass('is-active');
  };

  var addEventHandlers = function() {

    $win.resize(function(){
      if ( $win.outerWidth() > 640 ) {
        removeMobileMenu();
      }
    });
  };

  return {
    init: function($w, $d) {
      $win = $w;
      $doc = $d;
      
      addEventHandlers();

      if (javascript_args.wp_debug) { console.log('nav loaded'); }
    },

    toggleMobileMenu: toggleMobileMenu,
    removeMobileMenu: removeMobileMenu
  };

});