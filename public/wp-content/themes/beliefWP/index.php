<?php
/**
 *
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

// Customize blog queries
$context['posts'] = Timber::get_posts('offset=1&posts_per_page='. $num_posts);
// Paging behavior
$context['more_articles'] = true; // TODO: total > $num_posts + 1

// Render the page
Timber::render('pages/home.twig', $context);
