"use strict";define(["jquery"],function(e){var i,n,t=e("body"),o=(e(".main"),function(){t.toggleClass("is-active")}),u=function(){t.removeClass("is-active")},c=function(){i.resize(function(){i.outerWidth()>640&&u()})};return{init:function(e,t){i=e,n=t,c()},toggleMobileMenu:o,removeMobileMenu:u}});