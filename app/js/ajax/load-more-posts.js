$('#load-more-posts').on('click', function () {
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
				for (var i = 0; i < postArray.length; i++) {
					var counter = 0,
					html = '<article>';
					html 	+= '<section class="post-featured-image">';
					html += '<img src=' + postArray[i].thumbnail + '>';
					html += '</section>';
					html += '<section class="post-wrapper">';
					html += '<aside class="post-meta-wrapper">'
					html += '<div class="post-meta">';
					html += "<span class='post-author'>Posted By <a href='" + postArray[i].author_link + "'>" + postArray[i].author + "</a></span>";
					html += '<ul class="post-tags">';

					for (var key in postArray[i].cats) {
						html += '<li><a href="' + postArray[i].cat_urls[counter] + '">' + postArray[i].cats[key]['name'] + '</a></li>';
						counter++;
					}

					counter = 0
					for (var key in postArray[i].tags) {
						html += '<li><a href="' + postArray[i].tag_urls[counter] + '">' + postArray[i].tags[key]['name'] + '</a></li>';
					}
					html += '</ul></div></aside>';
					html += '<div class="post-content-wrapper">';
					html += '<h1 class="post-heading">' + postArray[i].title + '</h1>';
					html += '<div class="content"><p>' + postArray[i].excerpt + '</p></div>';
					if (postArray[i].read_more === "") {
						html += '<a class="post-read-more" href="' + postArray[i].permalink + '">Read More</a>';
					} else {
						html += '<a class="post-read-more" href="' + postArray[i].permalink + '">' + postArray[i].read_more + '</a>';
					}
					html += '</div></section></article>';
					$(html).appendTo('.main');

					exclude_ids = exclude_ids+','+postArray[i].post_id;
				}
				if ( data.post_count < 5 ) {
					$('#load-more-posts').removeClass('posts-more-to-load');
					$('#load-more-posts').addClass('posts-none-to-load');
					$('#load-more-posts').html('No More Posts');
				}
			} else {
				$('#load-more-posts').removeClass('posts-more-to-load');
				$('#load-more-posts').addClass('posts-none-to-load');
				$('#load-more-posts').html('Error, Reload Page');
			}
		},
		error:function(){
			$('#load-more-posts').removeClass('posts-more-to-load');
			$('#load-more-posts').addClass('posts-none-to-load');
			$('#load-more-posts').html('Error, Reload Page');
		}   
    }); 
});
