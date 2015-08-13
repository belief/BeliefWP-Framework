define(['_nav','fastclick', 'lazyload'], function(_nav, FastClick) {

    var $win, $doc, $body;

    var loadImages = function() {
        $("img.lazy").lazyload({
            event           : "ready",
            effect           : "fadeIn"
        });
    }


    return {
        init: function($w, $d) {
            $win = $w;
            $doc = $d;
            $body = $('body');

            $doc.ready(function() {

                _nav.init($win, $doc); // initialize menu
                FastClick.attach($body[0]); // faster response times for device clicks

                // Disable overscroll / viewport moving on everything but scrollable divs
                $body.on('touchmove', function (e) {
                    if ( $body.hasClass('is-active') ) e.preventDefault();
                });

                $win.resize(function() {
                    if(this.resizeTO) {
                        clearTimeout(this.resizeTO);
                    }
                    this.resizeTO = setTimeout(function() {
                        $(this).trigger('resizeEnd');
                    }, 200);
                });

                if (javascript_args.wp_debug) { console.log('common loaded'); }
            });
        }
    };
});
