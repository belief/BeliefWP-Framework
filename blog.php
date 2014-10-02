<?php
/**
 * Template Name: Blog Homepage
 *
 * The template for displaying all pages
 *
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

get_header(); ?>

	<main class="main blog-main clearfix">

		<?php query_posts( array( 'post__not_in' => get_option('sticky_posts'), 'posts_per_page' => 5 ) ); ?>

	  	<?php include('lib/views/partials/blog_partial.php'); ?>

	</main><!-- #content -->

<?php get_footer('blog');