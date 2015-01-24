<?php
/**
 * The template for displaying a single post
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

get_header(); ?>

  <main class="main blog-single clearfix">

    <?php include('app/views/partials/_single.php'); ?>

  </main><!-- #content -->

<?php get_footer( 'single' );
