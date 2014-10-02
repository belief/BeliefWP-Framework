<?php
/**
 * Template Name: Kerf Pages Single Post
 *
 * The template for displaying a single post
 *
 * @package WordPress
 * @subpackage kerf_theme
 * @since Kerf Theme 1.0
 */
/**
 *  CONSTANTS
 *
 * 
 */
define("SESSION_USERID", 'kerfdesign_com_uid');
  
$seo_kerf_title = "Kerf Design Form: " . get_the_title($post->ID);
$seo_kerf_description = "Work with us to get more information about your project.";

include("lib/classes/form_data.php");

session_start();
$_SESSION[get_the_title()] = true;
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

  $previousPermalink;
  $previousButtonURL;
  $nextButtonURL;
  $counter = 0;

  $args = array( 'post_type' => 'kerf_form_pages', 'orderby' => 'menu_order', 'order' => 'ASC');
  $loop = new WP_Query( $args );

  $process = "<ul class='form-headers'>";
  while ( $loop->have_posts() ) : $loop->the_post();

      $itemClass = '';
      $itemContent = get_the_title( $loop->post->ID );

      if ( isset($session[$loop->post->post_title]) ) {
        $itemClass = 'class="finished"';
        $itemContent = "<a href='" . get_permalink( $loop->post->ID ) . "'>" . get_the_title( $loop->post->ID ) . "</a>";
      }

      if ( $loop->post->ID == $storedPost->ID ) {
        $itemClass = 'class="active"';
        $itemContent = get_the_title( $loop->post->ID );
        $finishedPosts = false;
        $previousButtonURL = ( isset($previousPermalink) ) ? $previousPermalink : NULL;
      } else if ($finishedPosts) {
        $itemClass = 'class="finished"';
        $itemContent = "<a href=" . get_permalink( $loop->post->ID ) . ">" . get_the_title( $loop->post->ID ) . "</a>";
      } else if ( !isset($nextButtonURL) ) {
        $nextButtonURL = get_permalink( $loop->post->ID );
      }
      $process .= "<li ".$itemClass.">" . $itemContent . "</a></li>";

      $previousPermalink = get_permalink( $loop->post->ID );
      $counter++;

  endwhile; wp_reset_query();
  $process .= "</ul>";

  echo $process; 

  if ( !isset($nextButtonURL) ) {
    return array($previousButtonURL, NULL, $counter);
  } else if ( !isset($previousButtonURL) ) {
    return array(NULL, $nextButtonURL, $counter);
  } else {
    return array($previousButtonURL, $nextButtonURL, $counter);
  }
}

get_header(); 
?>

  <header class="form-header">
    <div class="header-line"></div>
    <?php

      $prevNextArray = createNavigation($post, $session_vars);

      $previousButtonURL = $prevNextArray[0];
      $nextButtonURL = $prevNextArray[1];
      $counter = $prevNextArray[2];
    ?>
  </header>
  <main id="form-main" class="main form-main clearfix">
<!--     <section class="header">
      <h1 class="post-heading"><?php the_title(); ?></h1>
    </section> -->

    <?php $kerf_form_data = get_post_meta($post->ID, '_kerf_form_data', true); ?>

    <?php new Form_Data($kerf_form_data, $session_vars); ?>
    
    <!-- <?php var_dump($session_vars); ?> -->
    <!-- <br /><br /><br /> -->
    <!-- <?php var_dump($kerf_form_data); ?> -->
    
    <section class="footer">
      <?php 

      if ( $nextButtonURL != NULL ) {
        echo '<a id="next-button" href="' . $nextButtonURL. '" class="button red-button next-form">Next ></a>';
      } else {
        echo '<div class="submit-wrapper">';
        echo '<a id="submit-form" class="button red-button submit-form">Submit</a>';
        echo '</div>';
      }

      if ( $previousButtonURL != NULL ) {
        $colorClass = 'red-button';
        if ( !$nextButtonURL ) {
          $colorClass = 'subtle-red-button';
        }
        echo '<a id="prev-button" href="' . $previousButtonURL . '" class="button prev-form ' . $colorClass .' prev-form">< Back</a>';
      }
      ?>
    </section>
  </main><!-- #content -->

  <?php $options = get_option( 'kerf_theme_inputs_options' ); ?>
  <?php  if ( $nextButtonURL == NULL) { ?>
    <div class="submit-spinner-wrapper" style="display: none;">
      <div class="progress-spinner"></div>
      <p>Please wait while we prepare and send your information.</p>
    </div>
    <main id="submitted-main" class="main form-main clearfix" style="display: none;">
      <section>
        <h2><?php echo $options['kerf_submission_success_title']; ?></h2>
        <div class="description-text">
          <?php echo nl2br($options['kerf_submission_success_description']); ?>
        </div>
        <div class="submit-wrapper">
          <a href="/" class="button done-form"><?php echo $options['kerf_submission_success_button']; ?></a>
        </div>
      </section>
    </main>
  <?php } else { ?>
  <div class="spinner-wrapper" style="display: none;">
    <div class="progress-spinner"></div>
  </div>
  <?php } ?>


  <script> 
    var pluginURL = "<?php bloginfo('template_url'); ?>"; 
    require(['form-pages'], function(handler) {
      handler.init($(window));
    });
  </script>
<?php
get_footer();
