<?php
/*
 * Template Name: Network Blog Category Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );
require_once ( get_template_directory() .'/lib/blog-context.php' );

// Customize query
$context['posts'] = Timber::get_posts('tag='. $term->name .'&posts_per_page=60'); // TODO: Finish paging

// Render the page
Timber::render('blog/tag.twig', $context);
