define(['_nav'], function(_nav) {

    var $win, $doc, $body;

    return {
        init: function($w, $d) {
            $win = $w;
            $doc = $d;
            $body = $('body');
            _nav.init($win, $doc); // initialize menu
            FastClick.attach($body[0]); // faster response times for device clicks

            // Disable overscroll / viewport moving on everything but scrollable divs
            $body.on('touchmove', function (e) {
                if ( $body.hasClass('is-active') ) e.preventDefault();
            });

            $(window).resize(function() {
                if(this.resizeTO) {
                    clearTimeout(this.resizeTO);
                }
                this.resizeTO = setTimeout(function() {
                    $(this).trigger('resizeEnd');
                }, 200);
            });

            console.log('common loaded');
        }
    };
});
