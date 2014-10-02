"use strict";

require.config({
    baseUrl: the_js_reference.path,
    paths: {
        jquery: [
          'https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min',
          'vendor/jquery-1.11.0.min'
        ],
        jqueryui: [
          'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.1/jquery-ui.min',
        ],
        modernizr: 'vendor/modernizr',
        fastclick: 'vendor/fastclick',
        froogaloop: 'vendor/froogaloop',
        history: 'vendor/history',
        infinitescroll: 'vendor/infinitescroll',
        isotope: 'vendor/isotope',
        mediaelement: 'vendor/mediaelement',
        spin: 'vendor/spin.min',
        _common: 'modules/_common',
        _nav: 'modules/_nav',
        _formpages: 'modules/_formpages'
    },
    shim: {
      'jquery': {
          exports: '$'
      },
      'mediaelement' : ['jquery']
    }
});

require(['_common'], function(runMethod) {
  runMethod.init($(window),$(document));
});