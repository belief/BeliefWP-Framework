<?php
/**
 * Template Name: Archived Kerf Pages 
 *
 * The template for displaying archived Form Pages posts
 *
 * @package WordPress
 * @subpackage kerf_theme
 * @since Kerf Theme 1.0
 */
$seo_kerf_title = "Kerf Design Form ";
$seo_kerf_description = "Work with us to get more information about your project.";

include("lib/classes/form_data.php");

session_start();
$session_vars = $_SESSION;

if (isset( $_COOKIE[SESSION_USERID]) )   {
  $uid = str_replace(".","_",$_COOKIE[SESSION_USERID]);

  //check if there is a current project open
  if (isset( $_COOKIE[$uid])) {
    $pid = str_replace(".","_",$_COOKIE[$uid]);

    $uid_info = $_COOKIE[$pid];
    $uid_info = stripslashes($uid_info);
    $uid_info = json_decode($uid_info,true);
    if (is_array($uid_info) ) {
      foreach ($uid_info as $key => $itemValue) {
        $session_vars[$key] = $itemValue;
      }
    }
  }
}

function createNavigation($storedPost, $session) {
  $finishedPosts = true;

  $previousButtonURL;
  $nextButtonURL;
  $currentTitle;
  $currentData;
  $counter = 0;

  $args = array( 'post_type' => 'kerf_form_pages', 'orderby' => 'menu_order', 'order' => 'ASC');
  $loop = new WP_Query( $args );

  $process = "<ul class='form-headers'>";
  while ( $loop->have_posts() ) : $loop->the_post();
    if ($loop->post) {
      $itemClass = '';
      $itemContent = get_the_title( $loop->post->ID );

      if ( isset($session[get_the_title( $loop->post->ID )]) ) {
        $itemClass = 'class="finished"';
        $itemContent = "<a href=" . get_permalink( $loop->post->ID ) . ">" . get_the_title( $loop->post->ID ) . "</a>";
      }
      
      if ( $counter == 0 ) {
        $itemClass = 'class="active"';
        $itemContent = get_the_title( $loop->post->ID );
        $currentTitle = get_the_title( $loop->post->ID );
        $currentData = get_post_meta($loop->post->ID, '_kerf_form_data', true);
        $finishedPosts = false;
      } else if ($finishedPosts) {
        $itemClass = 'class="finished"';
        $itemContent = "<a href=" . get_permalink( $loop->post->ID ) . ">" . get_the_title( $loop->post->ID ) . "</a>";
      } else if ( !isset($nextButtonURL) ) {
        $nextButtonURL = get_permalink( $loop->post->ID );
      }
      $process .= "<li ".$itemClass.">" . $itemContent . "</a></li>";

      $counter++;
    }
  endwhile; wp_reset_query();
  $process .= "</ul>";

  echo $process; 

  if ( !isset($nextButtonURL) ) {
    return array($previousButtonURL, NULL, $currentTitle, $currentData, $counter);
  } else if ( !isset($previousButtonURL) ) {
    return array(NULL, $nextButtonURL, $currentTitle, $currentData, $counter);
  } else {
    return array($previousButtonURL, $nextButtonURL, $currentTitle, $currentData, $counter);
  }
}

get_header(); ?>
  <header class="form-header">
    <div class="header-line"></div>
    <?php

      $prevNextArray = createNavigation(null, $session_vars);

      $previousButtonURL = $prevNextArray[0];
      $nextButtonURL = $prevNextArray[1];
      $title = $prevNextArray[2];
      $data = $prevNextArray[3];
      $counter = $prevNextArray[4];
    ?>
  </header>
  <main id="form-main" class="main form-main clearfix">
<!--     <section class="header">
	  	<h1 class="post-heading"><?php echo $title ?></h1>
  	</section> -->

  	<?php new Form_Data($data, $session_vars); ?>

  	<section class="footer">
  	  <?php 

  	  if ( $nextButtonURL ) {
  	    echo '<a id="next-button" href="' . $nextButtonURL. '" class="button red-button next-form">Next ></a>';
  	  } else {
        echo '<div class="submit-wrapper">';
  	    echo '<a class="button red-button submit-form">Submit</a>';
        echo '</div>';
  	  }

  	  if ( $previousButtonURL ) {
  	    $colorClass = 'red-button';
  	    if ( !$nextButtonURL ) {
  	      $colorClass = 'subtle-red-button';
  	    }
  	    echo '<a id="prev-button" href=' . $previousButtonURL . ' class="button prev-form ' . $colorClass .' prev-form">< Back</a>';
  	  }
  	  ?>
  	</section>
  </main><!-- #content -->
  <script> 
    var pluginURL = "<?php bloginfo('template_url'); ?>"; 
    require(['form-pages'], function(handler) {
      handler.init($(window));
    });
  </script>
<?php
get_footer();
