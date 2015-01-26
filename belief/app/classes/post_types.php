<?php


class Belief_Post_Types {
	public $instance;

	public function __construct() {
	  $this->instance =& $this;
	  //initialize the theme structure
	  add_action( 'belief_init_post_types', array( $this, 'form_post_type' ) );

	  do_action('belief_init_post_types');
	}

	/**
	 * Register Custom Form Post Type
	 * @link http://codex.wordpress.org/Function_Reference/register_post_type
	 * @since 1.0
	 */
	public function form_post_type() {
	  $labels = array(
	    'name' => __( 'Form Pages' ),
	    'singular_name' => __( 'Form Page' ),
	    'add_new' => __( 'Add New' ),
	    'add_new_item' => __( 'Add New Form Page' ),
	    'edit_item' => __( 'Edit Form Page' ),
	    'new_item' => __( 'New Form Page' ),
	    'view_item' => __( 'View Form Page' ),
	    'search_items' => __( 'Search Form Pages' ),
	    'not_found' =>  __( 'No Form Pages found' ),
	    'not_found_in_trash' => __( 'No Form Pages found in trash' ),
	    'menu_name' => __( 'Form Pages' ),
	  );

	  $args = array(
	    'labels' => $labels,
	    'public' => true,
	    'publicly_queryable' => true,
	    'show_ui' => true,
	    'show_in_menu' => true,
	    'query_var' => true,
	    'rewrite' => array( 'slug' => 'form' ),
	    'capability_type' => 'post',
	    'has_archive' => true,
	    'hierarchical' => false,
	    'menu_position' => 5,
	    'supports' => array('title','page-attributes')
	  );

	  register_post_type( 'belief_form_pages', $args );
	}
}

new Belief_Post_Types;
?>