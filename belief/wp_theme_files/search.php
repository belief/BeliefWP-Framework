<?php
/**
 * Template Name: Search Results
 *
 *
 * 
 * @package BeliefWP Framework
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.2
 */

global $num_posts;

// Setup the context
require_once ( get_template_directory() .'/app/util/template-context.php' );

// Customize query
$context['posts'] = Timber::get_posts('posts_per_page='. $num_posts .'&offset='. ($num_posts + 1)); // TODO: Finish paging

// Render the page
Timber::render('pages/search.twig', $context);
