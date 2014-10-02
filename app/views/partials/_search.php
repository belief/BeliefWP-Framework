<section id="primary" class="content-area">
	<div id="content" class="site-content" role="main">

	  <?php if ( have_posts() ) : ?>

	  <header class="page-header">
	    <h1 class="page-title"><?php printf( __( 'Search Results for: %s', 'kerf_theme' ), get_search_query() ); ?></h1>
	  </header><!-- .page-header -->

	    <?php
	      // Start the Loop.
	      while ( have_posts() ) : the_post();

	        get_template_part( 'content', get_post_format() );

	      endwhile;

	    else :
	      // If no content, include the "No posts found" template.
	      get_template_part( 'content', 'none' );

	    endif;
	  ?>

	</div><!-- #content -->
</section><!-- #primary -->