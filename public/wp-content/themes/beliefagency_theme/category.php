<?php
/**
 * The template for displaying posts of category
 *
 *
 *
 * @package WordPress
 * @subpackage Belief Theme
 * @author  BeliefAgency
 * @license GPL-2.0+
 * @since Belief Theme Theme 1.1
 */

$title = single_cat_title("", false);
get_header(); ?>
	<main class="main blog-main clearfix">
		<header class='blog-header'>
		</header>

		<?php $vars = $wp_query->query_vars ?>
		<?php $vars = array_merge($vars, array( 'post__not_in' => get_option('sticky_posts'), 'posts_per_page' => 5 )) ?>
		
		<?php query_posts( $vars ); ?>

	  	<?php include('lib/views/partials/blog_partial.php'); ?>

	  	<?php if ( !have_posts()) { ?>
	  	<article>
	  		No Posts under that Category
	  	</article>
	  	<?php } ?>
	</main><!-- #content -->

<?php get_footer('blog');