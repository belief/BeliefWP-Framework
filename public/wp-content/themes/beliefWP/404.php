<?php
/**
 * Template Name: 404
 *
 *
 * 
 * @package BeliefWP Framework
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.2
 */

// Setup the context
require_once ( get_template_directory() .'/app/util/template-context.php' );

// Render the page
Timber::render('pages/404.twig', $context);
