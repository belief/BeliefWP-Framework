<?php
/**
 * Template Name: 404
 *
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

// Setup the context
require_once ( get_template_directory() .'/app/util/template-context.php' );

// Use home page banner & foreground
$home_page = new TimberPost( $home_page_id );
$context['header_bg'] = set_bg_id( $home_page->hero_graphic, 'hero-graphic' );
$context['foreground'] = $home_page->foreground;

// Render the page
Timber::render('pages/404.twig', $context);
