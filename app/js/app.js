//for logging purposes
$.fn.log = function() {
  console.log.apply(console, this);
  return this;
};

//scrolling to elements on page
function scrollToElementID(elemID) {
  var currentTop = 0;
  var elem = $(elemID);
  if (elem.length) {
    currentTop += elem.offset().top;
    // adjsut for scrolling navigation
    currentTop -= 135;
    // adjust for wordpress nav
    if ( $('#wpadminbar').length ) {
      currentTop += $('#wpadminbar').height();
    }

  }
  $('html, body').animate({
      scrollTop: currentTop
    }, 1000);
}

$(document).ready(function() {
  $(window).resize(function() {
    if(this.resizeTO) {
      clearTimeout(this.resizeTO);
    }
    this.resizeTO = setTimeout(function() {
      $(this).trigger('resizeEnd');
    }, 500);
  });
});
