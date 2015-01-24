<?php
/*
 * Template Name: Network Blog Archive Page
 */

global $num_posts;

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );
require_once ( get_template_directory() .'/lib/blog-context.php' );

// Customize query
$context['posts'] = Timber::get_posts('posts_per_page='. $num_posts .'&offset='. ($num_posts + 1)); // TODO: Finish paging

// Render the page
Timber::render('blog/archive.twig', $context);
