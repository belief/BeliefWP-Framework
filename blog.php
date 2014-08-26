<?php
/**
 * Template Name: Blog Homepage
 *
 * The template for displaying all pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other 'pages' on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */

get_header(); ?>

	<main class="main blog-main clearfix">

		<?php query_posts( array( 'post__not_in' => get_option('sticky_posts'), 'posts_per_page' => 5 ) ); ?>

	  	<?php include('lib/views/blog_partial.php'); ?>

	</main><!-- #content -->
	<div class="more-post-wrapper">
		<a id="load-more-posts" class="posts-more-to-load" href="javascript:void(0);">Load More Posts</a>
	</div>

<?php
get_footer('blog');