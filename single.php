<?php
/**
 * The template for displaying a single post
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */

get_header(); ?>

  <main class="main blog-main clearfix">
  	<header class='blog-header'>
  		<?php $postcats = get_the_category($post->ID); ?>
  		<?php $cats_string_delim = ""; ?>
  		<?php foreach ($postcats as $cat ) { 
  			$cat_item = "<a class='breadcrumb-cat' href='" . get_category_link($cat->term_id) . "'>".$cat->name."</a>";
  			$cats_string_delim .= $cat_item . " "; 
  		} ?>
  		<h5 class="breadcrumb-header"><?php echo $cats_string_delim; ?> &#8658; <span class="breadcrumb-title"><?php the_title(); ?></span></h5>
  	</header>

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
              <div class="content"><?php echo the_content(); ?>  </div>
            </div>
          </section>
        </article>
        <?php array_push($used_posts, $post->ID ); ?>
      <?php endwhile; endif; ?>  

      <script> 
        var pluginURL = "<?php bloginfo('template_url'); ?>"; 
        var category_filter = "<?php echo $vars['category_name'] ?>";
        var tag_filter = "<?php echo $vars['tag']; ?>";
        var author_filter = "<?php echo $vars['author_name'] ?>";
        var exclude_ids = "<?php echo implode(',',$used_posts); ?>";
      </script>


  </main><!-- #content -->

<?php
get_footer( 'blog' );
