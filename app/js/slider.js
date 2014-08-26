var slider, callbackOnLastEvent;

//slider object
function Slider(ulSlidersID, ulInfoID, viewPortWrapperID) {
  this.ulImages = $('#'+ulSlidersID);
  this.ulInfo = $('#'+ulInfoID);
  this.viewPort = $('#'+viewPortWrapperID);
  this.li_items = null;
  this.currentIndex = 0;
  this.totalImages = 0;

  // initializes sizes and item amount
  this.init = function() {
    if (this.ulImages.length) {
      this.li_items = this.ulImages.children();

      var thisBackground = slider.li_items.eq(0).attr('data-src');
      this.li_items.eq(0).css('background-image', 'url('+thisBackground+ ')');

      this.totalImages = this.li_items.length;

      totalWidth = this.viewPort.width() * this.totalImages;
      this.ulImages.css('width',totalWidth);
      this.li_items.css('width',this.viewPort.width());
    } else {
      console.log("incorrect slider ul");
    }

    if (this.ulInfo.length && !this.currentIndex) {
      this.ulInfo.children().eq(0).fadeIn();
    }
  };

  //get the current view port's width
  this.getViewPortWidth = function() {
    return this.viewPort.width();
  };
}

//slide to xposition of slide
function slideTo(imageIndex, slider) {
  var direction, numOfImagesToGo, distance;

  if (slider.ulInfo.length && slider.currentIndex != imageIndex) {
    slider.ulInfo.children().eq(slider.currentIndex).fadeOut(function() {
      if (slider.li_items.eq(imageIndex).css('background-image') == 'none') {
        var thisBackground = slider.li_items.eq(imageIndex).attr('data-src');
        slider.li_items.eq(imageIndex).css('background-image', 'url('+thisBackground+ ')');
      }
      slider.ulInfo.children().eq(imageIndex).fadeIn();
    });
  }

  numOfImagesToGo = Math.abs(imageIndex - slider.currentIndex);
  direction = slider.currentIndex > imageIndex ? 1 : -1;
  currentPosition = -1 * slider.currentIndex * slider.viewPort.width();
  distance = parseInt(currentPosition + direction  * numOfImagesToGo * slider.getViewPortWidth());

  slider.ulImages.animate({
      left: distance
    }, 500, function(){
      slider.currentIndex = imageIndex;
    });
}

$(document).ready( function() {
  //sliderobject
  slider = new Slider('image-sliders', 'info-sliders', 'slider-viewport');
  slider.init();

  //previous listener
  $('.slideshow-prev').on('click', function() {
      if (slider.currentIndex === 0) {
        slideTo(slider.totalImages-1,slider);
      } else {
        slideTo(slider.currentIndex-1,slider);
      }
    });

  //next listener
  $('.slideshow-next').on('click', function() {
      if (slider.currentIndex === slider.totalImages - 1) {
        slideTo(0,slider);
      } else {
        slideTo(slider.currentIndex+1,slider);
      }
    });

  //resizing
  $(window).bind('resizeEnd', function() {
    slider.init();
    slideTo(slider.currentIndex,slider);
  });
});
