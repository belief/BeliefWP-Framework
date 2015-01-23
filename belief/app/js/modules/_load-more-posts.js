define(['jquery'], function($, FastClick, _nav) {

	var $win,
		$doc,
		$element = $('[data-feature="load-more-posts"]'),
		pluginURL = $win.pluginURL,
		exclude_ids = $win.exclude_ids,
		category_filter = $win.category_filter,
		tag_filter = $win.tag_filter,
		author_filter = $win.author_filter,

	var renderHTMLTemplate = function( postArray ) {
		var counter, 
			html,
			thumbnailSrc = postArray[i].thumbnail,
			authorLink = postArray[i].author_link,
			authorName = postArray[i].author,
			catUrls = postArray[i].cat_urls,	//array of category urls with keys from category names
			catNames =  postArray[i].cats,		//array of category names
			title = postArray[i].title,
			excerpt = postArray[i].excerpt,
			readMore = postArray[i].read_more,
			permalink = postArray[i].permalink;


		exclude_ids = exclude_ids+','+postArray[i].post_id;
		$win.exclude_ids = exclude_ids;
	}

	return {
		init: function($w, $d) {
			$win = $w;
			$doc = $d;

			$element.on('click', function () {
				$.ajax({
					url: pluginURL+'/lib/classes/load_more_posts.php?'
						+ 'category_name=' + category_filter 
						+ '&tag=' + tag_filter
						+ '&author_name=' + author_filter
						+ '&exclude_ids=' + exclude_ids,
					type: "GET",
					datatype: 'json',
					success: function(data){
						if ( data.status == 200 ) {
							var postArray = data.posts;
							renderHTMLTemplate( postArray );

							if ( data.post_count < 5 ) {
								$element.removeClass('posts-more-to-load');
								$element.addClass('posts-none-to-load');
								$element.html('No More Posts');
							}
						} else {
							$element.removeClass('posts-more-to-load');
							$element.addClass('posts-none-to-load');
							$element.html('Error, Reload Page');
						}
					},
					error:function(){
						$element.removeClass('posts-more-to-load');
						$element.addClass('posts-none-to-load');
						$element.html('Error, Reload Page');
					}   
			    }); 
			});
		}
	}
});
