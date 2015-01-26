<?php

  /**
   *  WARNING: This file is part of the core belief_theme_slug Theme Framework. DO NOT edit this file under any circumstances. Please do all modifications in the form of a child theme.
   *
   * File contains initialization of belief_theme_slug Design features created at init hook
   *
   *
   *
   * @package WordPress
   * @subpackage Belief Theme
   * @author  BeliefAgency
   * @license GPL-2.0+
   * @since Belief Theme Theme 1.1
   */

class Belief_WP {
  public $instance;

  public function __construct() {
    $this->instance =& $this;
    //initialize the theme structure
    add_action( 'init', array( $this, 'initialize' ) );

    //setup enqueue scripts
    add_action( 'wp_enqueue_scripts', array($this,'belief_scripts') );


    if (! function_exists('belief_setup')) {
      add_action( 'after_setup_theme', array($this, 'belief_setup') );
    }

    //filters for excerpt
    add_filter('the_excerpt', 'belief_excerpt');
    add_filter('excerpt_more', 'belief_excerpt_more');
    add_filter('excerpt_length', 'belief_excerpt_length');
  }

  public function initialize() {

    //initialize frameworks
    add_action('belief_init', array( $this, 'belief_framework') );

    //metaboxe module addon
    add_action( 'belief_init', array( $this, 'be_initialize_cmb_meta_boxes') );

    do_action('belief_init');
  }

  /**
      Framework

   */
  public function belief_framework() {


    require_once( dirname( __FILE__ ) . '/util/constants.php' );
    require_once( dirname( __FILE__ )  . '/admin/belief_metaboxes_controller.php' );
    require_once( dirname( __FILE__ )  . '/util/timber.php' );

    //classes
    require_once( BELIEF_ADMIN_DIR . '/belief_nav_menu.php' );
    require_once( dirname( __FILE__ )  . '/classes/post_types.php' );
    require_once( dirname( __FILE__ )  . '/classes/settings.php' );
  }

  /**
      Register Post Types

   */


  /**
   * Initialize Metabox Class
   * see /app/admin/metabox/example-functions.php for more information
   *
   */
  public function be_initialize_cmb_meta_boxes() {
      if ( !class_exists( 'cmb_Meta_Box' ) ) {
        require_once( BELIEF_METABOX_DIR . '/init.php');
      }
  }

  /**
      Scripts

   */

  //register scripts
  public function belief_scripts() {

    //app stylesheet
    wp_enqueue_style( BELIEF_THEME_SLUG.'-app-style', get_template_directory_uri() . '/assets/css/app.min.css', array(), null);

      //add requireJ
    wp_enqueue_script( BELIEF_THEME_SLUG.'-require-js', get_template_directory_uri() . '/assets/js/vendor/require.js', array(), null);

    $args = array(
        'wp_debug' => WP_DEBUG
    );

      //add requireJS Config
    wp_enqueue_script( BELIEF_THEME_SLUG.'-config-requirejs', get_template_directory_uri() . '/assets/js/main.min.js', array(), null);

    //localize the requireJS Config
    wp_localize_script( BELIEF_THEME_SLUG.'-config-requirejs', 'javascript_args', $args );

    //custom app stylesheet
    wp_enqueue_style( BELIEF_THEME_SLUG.'-custom-style', get_template_directory_uri() . '/style.css', array(), null);  }


  /**
      Other

   */
  function belief_setup() {

    //enable post thumbnails
    add_theme_support( 'post-thumbnails' );
    set_post_thumbnail_size( 672, 372, true );

    //register primary menu
    register_nav_menus( array(
      'primary' => __( 'Top Primary Menu', 'belief_theme_slug' ),
    ) );
  }


  /**
   * Excerpt
   * @link http://codex.wordpress.org/Function_Reference/the_excerpt
   *
   */
  function belief_excerpt($output) {
    global $post;
    return "<p>".$output."</p>";
  }

  function belief_excerpt_more( $more ) {
    return ' ...';
  }

  function belief_excerpt_length($length) {
    return 100; // Or whatever you want the length to be.
  }
}

new Belief_WP;
require_once( dirname( __FILE__ )  . '/admin/belief_admin_init.php' );

