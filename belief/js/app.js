"use strict";

require.config({
    // baseURL: the_js_reference.path,
    baseUrl: 'public/assets/js',
    waitSeconds: 120,
    paths: {
        jquery: 'vendor/jquery-1.11.0.min',
        jqueryui: 'vendor/jqueryui.min.js',
        modernizr: 'vendor/modernizr',
        fastclick: 'vendor/fastclick',
        froogaloop: 'vendor/froogaloop',
        history: 'vendor/history',
        infinitescroll: 'vendor/infinitescroll',
        isotope: 'vendor/isotope',
        mediaelement: 'vendor/mediaelement',
        spin: 'vendor/spin.min',
        imagesloaded: 'vendor/imagesloaded.pkgd.min',
        masonry: 'vendor/masonry.pkgd.min',
        _common: 'modules/_common',
        _nav: 'modules/_nav',
    },
    shim: {
      'jquery': {
          exports: '$'
      },
      'mediaelement' : ['jquery']
    }
});

define(['require', 'jquery', '_common', 'modernizr'], function(require, $, _common) {

  var $win = $(window),
      $doc = $(document),
      moduleNames = [
        'homepage'
      ],
      moduleQueue = [];

  // checking for any data features and loading them
  function initModules() {
    moduleQueue = [];

    $('*[data-module]').each(function(i, el) {
      // Set array of module names
      var modules = $(el).data('module').split('|');

      // loop through each module name
      $.each(modules, function(i, module) {

        // check if param name exists in moduleNames array
        if ( moduleNames.indexOf(module) != -1 ) {

          // param name exists, push it to the moduleQueue to be ready for loading
          // console.log('load _' + module);
          moduleQueue.push('_' + module);
        }

      });
    });

    // require module and initialize
    require(moduleQueue, function() {
      for ( var i = 0; i < arguments.length; i++ ) {
        var module = arguments[i];

        module.init($win, $doc);
      }
    });
  }

  return {
    init: function($w, $d) {
      jQuery = $;
      _common.init($win, $doc);
      initModules();
    },
  };

});
