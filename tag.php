<?php
/**
 * The template for displaying tagged posts
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */

get_header(); ?>
	<main class="main blog-main clearfix">
		<header class='blog-header'>
			<h2><?php echo single_tag_title("", false); ?> Tagged Posts</h2>
		</header>

  		<?php $vars = $wp_query->query_vars ?>
  		<?php $vars = array_merge($vars, array( 'post__not_in' => get_option('sticky_posts'), 'posts_per_page' => 5 )) ?>
  		
  		<?php query_posts( $vars ); ?>

	  	<?php include('lib/views/blog_partial.php'); ?>

	  	<?php if ( !have_posts()) { ?>
	  	<article>
	  		No Posts with that tag
	  	</article>
	  	<?php } ?>
	</main><!-- #content -->
	<div class="more-post-wrapper">
		<a id="load-more-posts" class="posts-more-to-load" href="javascript:void(0);">Load More Posts</a>
	</div>

<?php
get_footer('blog');