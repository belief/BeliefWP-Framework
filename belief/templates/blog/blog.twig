<?php $used_posts = get_option('sticky_posts'); ?>
<?php if(have_posts()): while(have_posts()): the_post(); ?>
	<article>
  		<section class="post-featured-image"><?php echo '<img src=' . wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' )[0] . '>' ?></section> 
  		<section class="post-wrapper">
	  		<aside class='post-meta-wrapper'>
	  			<div class='post-meta'>
		  			<span class='post-author'>Posted By <a href="<?php echo get_author_posts_url( get_the_author_meta( 'ID' ) ); ?>"><?php echo get_the_author_meta('first_name'); ?></a></span>
		  			<ul class="post-tags">
		  			<?php

		  			$postcats = get_the_category($post->ID);
		  			if ($postcats) {
		  			  foreach($postcats as $cat) {
		  			    echo '<li><a href="' . get_category_link($cat->term_id) . '">' . $cat->name . '</a></li>'; 
		  			  }
		  			}
		  			
		  			$posttags = get_the_tags();
		  			if ($posttags) {
		  			  foreach($posttags as $tag) {
		  			    echo '<li><a href="' . get_tag_link($tag->term_id) . '">' . $tag->name . '</a></li>'; 
		  			  }
		  			}
		  			?>
		  			</ul>
		  		</div>
	  		</aside>

	  		<div class="post-content-wrapper">
		  		<h1 class="post-heading"><?php the_title(); ?></h1>  
		  		<div class="content"><?php the_excerpt(); ?>  </div>

		  		<?php 
		  		$readmore = esc_attr( get_post_meta( $post->ID, 'custom_read_more', true ) );
            	$readmore = ($readmore) ? $readmore : "Read More"; 
            	?>
		  		<a class='post-read-more' href="<?php the_permalink(); ?>"><?php echo $readmore ?></a>  
		  	</div>
	  	</section>
  	</article>
	<?php array_push($used_posts, $post->ID ); ?>
<?php endwhile; endif; ?>  

<script> 
	var $(window).pluginURL = "<?php bloginfo('template_url'); ?>"; 
		$(window).category_filter = "<?php echo $vars['category_name'] ?>";
		$(window).tag_filter = "<?php echo $vars['tag']; ?>";
		$(window).author_filter = "<?php echo $vars['author_name'] ?>";
		$(window).exclude_ids = "<?php echo implode(',',$used_posts); ?>";
</script>
