<?php
/*
 * Template Name: Network Blog Category Page
 */

// Setup the context
require_once ( get_template_directory() .'/lib/init-context.php' );

// Customize query
$context['posts'] = Timber::get_posts('cat='. $term->ID .'&posts_per_page=60'); // TODO: Finish paging

// Render the page
Timber::render('blog/category.twig', $context);
