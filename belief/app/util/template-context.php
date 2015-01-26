<?php
/*
 * Use to initialize context and reduce duplication
 * in our template files.
 */

if ( !class_exists('Timber') ) {
	echo 'Timber not activated. Activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
}

$context = Timber::get_context();
$context['settings'] = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
$context['nowhere'] = 'javascript:void(0)';

//get post information
$post_id = 0;
if ( $post ) {
	$post_id = $post->ID;
}
if ( is_home() ) {
	$post_id = get_option('page_for_posts');
}
if ( $post_id ) {
	$post = $page = new TimberPost( $post_id );
	$context['page'] = $context['post'] = $post;
}

if ( get_queried_object() ) {
	// Page might be a category rather than a post
	$term_id = get_queried_object()->term_id;
	$term_taxonomy = get_queried_object()->taxonomy;
	if ( $term_id ) {
		$term = new TimberTerm( $term_id, $term_taxonomy );
		$context['term'] = $term;
	}
}