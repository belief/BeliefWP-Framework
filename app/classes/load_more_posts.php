<?php
//bootstrap WP
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );


$args = array( 	'post__not_in' => get_option('sticky_posts'), 
					'posts_per_page' => 5
	);

if ( isset( $_GET['tag'])  && $_GET['tag'] !== "" ) {
	$args['tag'] = $_GET['tag'];
}

if ( isset( $_GET['category_name'] ) && $_GET['category_name'] !== "" ) {
	$args['category_name'] = $_GET['category_name'];
}

if ( isset($_GET['author_name']) && $_GET['author_name'] !== "") {
	$args['author_name'] = $_GET['author_name'];
}

if ( isset($_GET['exclude_ids']) ) {
	$ids = $_GET['exclude_ids'];
	$args['post__not_in'] = explode(",",$_GET['exclude_ids']);
}

$postsQ = query_posts( $args );
$count = count($postsQ);


$posts = array();
while(have_posts()): the_post();
	$cat_urls = array();
	foreach (get_the_category($post->ID) as $catObj) {
		array_push($cat_urls, get_category_link($catObj->term_id));
	}

	$tag_urls = array();
	foreach (get_the_tags() as $tagObj) {
		array_push($tag_urls, get_tag_link($tagObj->term_id));
	}

	array_push($posts, array(
		'post_id'		=> $post->ID,
		'title' 	=> get_the_title(),
		'tags'		=> get_the_tags(),
		'tag_urls' 	=> $tag_urls,	
		'cats'		=> get_the_category($post->ID),
		'cat_urls' 	=> $cat_urls,	
		'thumbnail'	=> wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0],
		'author'	=> get_the_author_meta('first_name'),
		'author_link' => get_author_posts_url( get_the_author_meta( 'ID' ) ),
		'excerpt'	=> get_the_excerpt(),
		'read_more'	=> esc_attr( get_post_meta( $post->ID, 'custom_read_more', true ) ),
		'permalink'	=> get_permalink()

		));
endwhile;

$return = array(
			'status'		=> 200,
			'post_count'	=> $count,
			'posts'			=> $posts
	);

wp_send_json($return);

?>