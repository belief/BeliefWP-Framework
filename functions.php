<?php
/**
 * BELIEF_THEME_TEMPLATE functions and definitions
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link http://codex.wordpress.org/Theme_Development
 * @link http://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * @link http://codex.wordpress.org/Plugin_API
 *
 * @package WordPress
 * @subpackage BELIEF_THEME_TEMPLATE_theme
 * @since BELIEF_THEME_TEMPLATE Theme 1.0
 */

require_once( dirname( __FILE__ ) . '/app/app_init.php' );
require_once( dirname( __FILE__ )  . '/app/admin/app_admin_init.php' );

if (! function_exists('belief_theme_slug_setup')) {
  function kerf_setup() {

    //enable post thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 672, 372, true );

    //register primary menu
    register_nav_menus( array(
      'primary' => __( 'Top Primary Menu', 'belief_theme_slug' ),
      'anchored' => __( 'Anchored Home Page Menu', 'belief_theme_slug' )
    ) );
  }
  add_action( 'after_setup_theme', 'belief_theme_slug_setup' );

  /*
   * Modify Insert Media into post with custom attributes
   */
  function html5_insert_image($html, $id, $caption, $title, $align, $url, $size) {

      $image_attributes = wp_get_attachment_image_src( $id , 'full'); 
      $html5 = "<figure id='post-$id media-$id' class='figure align$align'>";
      $html5 .=  "<img id='post-$id media-$id' class='post-img-full-width align$align' src='$image_attributes[0]' width='100%'>";
      if ($caption) {
          $html5 .= "<figcaption>$caption</figcaption>";
      }
      $html5 .= "</figure>";
      return $html5;
  }
  add_filter( 'image_send_to_editor', 'html5_insert_image', 10, 9 );

  /*
   * Enable support for Post Formats.
   * See http://codex.wordpress.org/Post_Formats
   */
  add_theme_support( 'post-formats', array(
    'gallery'
  ) );

  //register scripts
  function belief_theme_slug_scripts() {
    //normalize css
    wp_enqueue_style( 'belief_theme_slug-normalize', get_template_directory_uri() . '/app/css/normalize.min.css', array(), null);

    //app stylesheet
    wp_enqueue_style( 'belief_theme_slug-style', get_template_directory_uri() . '/style.css', array(), null);

    //add modernizer
    wp_enqueue_script( 'belief_theme_slug-modernizr', get_template_directory_uri() . '/app/js/vendor/modernizr-2.6.2-respond-1.1.0.min.js', array( 'jquery' ), '2014720', true);

    //add main app script
    wp_enqueue_script( 'belief_theme_slug-app', get_template_directory_uri() . '/app/js/app.js', array( 'jquery' ), '2014720', true);

    //front page only scripts
    if ( is_front_page() ) {
      wp_enqueue_script( 'belief_theme_slug-slider', get_template_directory_uri() . '/app/js/slider.js', array( 'jquery' ), '2014720', true);
      wp_enqueue_script( 'belief_theme_slug-staff', get_template_directory_uri() . '/app/js/staff.js', array( 'jquery' ), '2014723', true);
      wp_enqueue_script( 'belief_theme_slug-dotdotdot', get_template_directory_uri() . '/app/js/vendor/jquery.dotdotdot.min.js', array( 'jquery' ), '2014720', true);
    } else {

      //load more posts
      wp_enqueue_script( 'belief_theme_slug-load-more-posts', get_template_directory_uri() . '/app/js/ajax/load-more-posts.js', array('jquery'), '2014723', true);
    }
  }
  add_action( 'wp_enqueue_scripts', 'belief_theme_slug_scripts' );

  /**
   * Excerpt
   * @link http://codex.wordpress.org/Function_Reference/the_excerpt
   *
   */
  function belief_theme_slug_excerpt($output) {
   global $post;
   return "<p>".$output."</p>";
  }
  add_filter('the_excerpt', 'belief_theme_slug_excerpt');

  function belief_theme_slug_new_excerpt_more( $more ) {
    return ' ...';
  }
  add_filter('excerpt_more', 'belief_theme_slug_new_excerpt_more');

  function belief_theme_slug_excerpt_length($length) {
    return 100; // Or whatever you want the length to be.
  }
  add_filter('excerpt_length', 'belief_theme_slug_excerpt_length');

  /**
   * Create Metaboxes
   * @link http://www.billerickson.net/wordpress-metaboxes/
   *
   */
  function metaboxes( $meta_boxes ) {
    $meta_boxes['read_more'] = array(
      'id' => 'custom-read-more',
      'title' => __('BELIEF_THEME_TITLE Custom Read More...'),
      'pages' => array('post','kerf_sliders'),
      'context' => 'normal',
      'priority' => 'high',
      'show_names' => true,
      'fields' => array(
        array(
          'name' => 'Read more...',
          'desc' => 'Replaces the default template trailing link to the above custom text.',
          'id' => 'custom_read_more',
          'type' => 'text'
        )
      )
    );

    $meta_boxes['home-sticky-highlight'] = array(
      'id' => 'featured-highlight',
      'title' => _('BELIEF_THEME_TITLE Homepage Sticky Highlight'),
      'pages' => array('post'),
      'context' => 'normal',
      'priority' => 'high',
      'show_names' => true,
      'fields' => array(
        array(
          'name' => __('Featured-Image Highlight Color'),
          'desc' => __('Select a color that will be the highlight color for the featured image of this post.'),
          'id'   => 'belief_theme_slug_featured_highlight',
          'type' => 'title'
        ),
        array(
          'name'    => __('Highlight Color'),
          'desc'    => __('Select a color'),
          'id'      => 'belief_theme_slug_featured_highlight_title',
          'type'    => 'colorpicker',
          'default' => '#FFFFFF'
        )
      )
    );

    return $meta_boxes;
  }
  add_filter( 'cmb_meta_boxes' , 'metaboxes' );

  /**
   * Custom built metabox for adding user-specific amount of form elements
   * @link http://www.billerickson.net/wordpress-metaboxes/
   *
   */
  function belief_theme_slug_form_pages_metabox_create() {
    add_meta_box( 'belief_theme_slug_form_pages_meta', 
                  'BELIEF_THEME_TITLE Form Elements', 
                  'belief_theme_slug_form_pages_metabox_function', 
                  'belief_theme_slug_form_pages', 'normal', 'high' );
  }
  add_action('add_meta_boxes', 'belief_theme_slug_form_pages_metabox_create' );

  function kerf_form_pages_metabox_function( $post ) {
    include('app/views/form_metabox_view.php');
  }

  /**
   * Saving for kerf_form_pages custom post type
   * @link http://codex.wordpress.org/Plugin_API/Action_Reference/save_post
   *
   */
  function belief_theme_slug_form_pages_metabox_save( $post_id ) {
    //expected post type slug
    $slug = 'belief_theme_slug_form_pages';

    if ( $slug != $_POST['post_type']) {
      return;
    }

    // update the post's metadata (transfer to array of variables!)
    add_post_meta($post_id, '_ss_be_mbe_title', strip_tags($_POST['ss_be_mbe_title']) , true )
              or update_post_meta( $post_id, '_ss_be_mbe_title', strip_tags($_POST['ss_be_mbe_title']) );

  }
  add_action('save_post', 'belief_theme_slug_form_pages_metabox_save');


  /**
   * Motify Permissions
   * @link http://codex.wordpress.org/Function_Reference/add_meta_box
   * Credit to Belief Agency
   *
   */
  function belief_theme_slug_capabilities_mod() {
    $editor_role = get_role('editor');
    $editor_role -> remove_cap('publish_pages');
    $editor_role -> add_cap('add_users');
    $editor_role -> add_cap('create_users');

    $author_role = get_role('author');
    $author_role -> remove_cap('publish_pages');
  }
  add_action('admin_init','belief_theme_slug_capabilities_mod');

  function belief_theme_slug_menu_mod() {
    global $submenu;
    unset($submenu['edit.php?post_type=page'][10]);
    $submenu['edit.php?post_type=page'][10][1] = 'publish_pages';
  }
  add_action('admin_menu','belief_theme_slug_menu_mod');

  function kerf_hide_add_button() {
    global $current_screen;
    if($current_screen->post_type == 'page' && !current_user_can('publish_pages')) {
      echo '<style>.add-new-h2{display: none;}</style>';
    }
  }
  add_action('admin_head','belief_theme_slug_hide_add_button');

  function belief_theme_slug_redirect() {
    $result = stripos($_SERVER['REQUEST_URI'], 'post-new.php?post_type=page');
    if ($result!==false && !current_user_can('publish_pages')) {
      wp_redirect(get_option('siteurl') . '/wp-admin/index.php?permissions_error=true');
    }
  }
  add_action('admin_menu','belief_theme_slug_redirect');

  function belief_theme_slug_restrict_notice() {
    if($_GET['permissions_error'])
    {
      echo "<div id='permissions-warning' class='error fade'><p><strong>".__('You do not have permission for this access.')."</strong></p></div>";
    }
  }
  add_action('admin_init','belief_theme_slug_restrict_notice');

  /**
   * Add Theme Admin Menu
   * @link http://codex.wordpress.org/Administration_Menus
   *
   */
}

function tokenTruncate($string, $your_desired_width) {
  $parts = preg_split('/([\s\n\r]+)/', $string, null, PREG_SPLIT_DELIM_CAPTURE);
  $parts_count = count($parts);

  $length = 0;
  $last_part = 0;
  for (; $last_part < $parts_count; ++$last_part) {
    $length += strlen($parts[$last_part]);
    if ($length > $your_desired_width) { break; }
  }

  return implode(array_slice($parts, 0, $last_part));
}
