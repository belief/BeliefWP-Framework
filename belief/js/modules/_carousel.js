define(['owl'], function() {
	var $win, $doc;

	return {
		init: function($w, $d) {
			$win = $w;
			$doc = $d;

			$doc.ready(function() {





                if (javascript_args.wp_debug) { console.log('carousel loaded'); }
			});
		}
	}
});