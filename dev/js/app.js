require.config({
    waitSeconds: 120,
    paths: {
        jquery: '/wp-content/themes/beliefWP/assets/js/vendor/jquery-1.11.0.min',
        jqueryui: '/wp-content/themes/beliefWP/assets/js/vendor/jqueryui.min.js',
        modernizr: '/wp-content/themes/beliefWP/assets/js/vendor/modernizr',
        fastclick: '/wp-content/themes/beliefWP/assets/js/vendor/fastclick',
        froogaloop: '/wp-content/themes/beliefWP/assets/js/vendor/froogaloop',
        history: '/wp-content/themes/beliefWP/assets/js/vendor/history',
        infinitescroll: '/wp-content/themes/beliefWP/assets/js/vendor/infinitescroll',
        isotope: '/wp-content/themes/beliefWP/assets/js/vendor/isotope',
        owl: '/wp-content/themes/beliefWP/assets/js/vendor/owl.carousel.min',
        lazyload: '/wp-content/themes/beliefWP/assets/js/vendor/lazyload',
        mediaelement: '/wp-content/themes/beliefWP/assets/js/vendor/mediaelement',
        spin: '/wp-content/themes/beliefWP/assets/js/vendor/spin.min',
        imagesloaded: '/wp-content/themes/beliefWP/assets/js/vendor/imagesloaded.pkgd.min',
        masonry: '/wp-content/themes/beliefWP/assets/js/vendor/masonry.pkgd.min',
        _common: '/wp-content/themes/beliefWP/assets/js/modules/_common',
        _nav: '/wp-content/themes/beliefWP/assets/js/modules/_nav',
        _carousel: '/wp-content/themes/beliefWP/assets/js/modules/_carousel'
    },
    shim: {
      'jquery': {
          exports: '$'
      },
      'mediaelement' : ['jquery'],
      'lazyload' : ['jquery']
    }
});

define(['require', 'jquery', '_common', 'modernizr'], function(require, $, _common) {

  var $win = $(window),
      $doc = $(document),
      moduleNames = [
        'carousel'
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
