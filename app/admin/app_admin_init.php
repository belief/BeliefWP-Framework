<?php
  /**
   * Add Theme Admin Menu
   * @link http://codex.wordpress.org/Settings_API
   *
   */
class Belief_Theme_Classes_Admin {
  var $instance;

  function __construct() {
    $this->instance =& $this;
    add_action( 'init', array( $this, 'initialize' ) );
  }

  function initialize() {
    add_action( 'admin_menu', array( $this, 'belief_theme_slug_settings_api_init') );

    add_action( 'admin_init', array( $this, 'belief_theme_slug_initialize_theme_options' ) );

  }

  function belief_theme_slug_settings_api_init() {
    add_theme_page(
      'Edit belief_theme_slug Theme',          // The title to be displayed in the browser window for this page.
      'belief_theme_slug Theme',          // The text to be displayed for this menu item
      'administrator',          // Which type of users can see this menu item
      'belief_theme_slug_theme_options',      // The unique ID - that is, the slug - for this menu item
      array( $this, 'belief_theme_slug_theme_inputs')       // The name of the function to call when rendering this menu's page
    );

    add_menu_page(
      'Edit belief_theme_slug Theme',          // The value used to populate the browser's title bar when the menu page is active
      'belief_theme_slug Theme',          // The text of the menu in the administrator's sidebar
      'administrator',          // What roles are able to access the menu
      'belief_theme_slug_theme_menu',       // The ID used to bind submenu items to this menu
      array($this, 'belief_theme_slug_theme_inputs')       // The callback function used to render this menu
    );
  }

  function belief_theme_slug_theme_inputs() {
  ?>
    <div class="wrap">

      <div id="icon-themes" class="icon32"></div>
      <h2><?php _e( 'belief_theme_slug Theme Options' ); ?></h2>
      <?php settings_errors(); ?>

      <form method="post" action="options.php">
        <?php

          settings_fields( 'belief_theme_slug_theme_inputs_options' );
          do_settings_sections( 'belief_theme_slug_theme_inputs_options' );
          submit_button();

        ?>
      </form>
    </div>
  <?php
  }

  function belief_theme_slug_theme_default_input_options() {
    $defaults = array(
      'processheader' => 'Human. Useful. Beautiful.',
      'processdescription' => '',
      'aboutbelief_theme_slug' => '',
      'contactbelief_theme_slug' => '',
      'heromp4link' => '',
      'herowebmlink' => '',
      'belief_theme_slugaddress' => '',
      'belief_theme_slugemail' => '',
      'belief_theme_slugphone' => ''
    );
    update_option( 'belief_theme_slug_theme_inputs_options', $defaults );
  }

  function belief_theme_slug_initialize_theme_options() {
    if( false == get_option( 'belief_theme_slug_theme_inputs_options' ) ) {
      $this->belief_theme_slug_theme_default_input_options();
    }

    add_settings_section(
      'info_belief_theme_slug_section',
      __( 'Info'),
      array( $this, 'belief_theme_slug_info_callback'),
      'belief_theme_slug_theme_inputs_options'
    );

    add_settings_field(
      'heromp4link',
      __( 'Hero mp4 URL' ),
      array( $this, 'belief_theme_slug_hero_mp4_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'herowebmlink',
      __( 'Hero Webm URL'),
      array( $this, 'belief_theme_slug_hero_webm_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'processheader',
      __( 'Process Header'),
      array( $this, 'belief_theme_slug_process_header_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'processdescription',
      __( 'Header Description'),
      array( $this, 'belief_theme_slug_header_description_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'aboutbelief_theme_slug',
      __( 'About belief_theme_slug'),
      array( $this, 'belief_theme_slug_about_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'contactbelief_theme_slug',
      __( 'Contact Description'),
      array( $this, 'belief_theme_slug_contact_description_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'belief_theme_slugaddress',
      __( 'Contact Address:'),
      array( $this, 'belief_theme_slug_address_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'belief_theme_slugemail',
      __( 'Contact Email'),
      array( $this, 'belief_theme_slug_email_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    add_settings_field(
      'belief_theme_slugphone',
      __( 'Contact Phone Number'),
      array( $this, 'belief_theme_slug_phone_callback'),
      'belief_theme_slug_theme_inputs_options',
      'info_belief_theme_slug_section'
    );

    register_setting(
      'belief_theme_slug_theme_inputs_options',
      'belief_theme_slug_theme_inputs_options',
      array( $this, 'belief_theme_slug_theme_validate_inputs')
    );
  }

  /*------------------------------------------------------------------------ *
   * Section Callbacks
   * ------------------------------------------------------------------------
   */

  function belief_theme_slug_info_callback() {
    echo '<p>' . __( 'Administrative settings for belief_theme_slug Design') . '</p>';
  }

  function belief_theme_slug_hero_mp4_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $url = '';
    if( isset( $options['heromp4link'] ) ) {
      $url = esc_url( $options['heromp4link'] );
    }

    echo '<input name="belief_theme_slug_theme_inputs_options[heromp4link]" type="text" id="heromp4link" value="' . $url . '" class="large-text code">
        <p class="description">direct link to the mp4 video for the preview hero.</p>';
  }

  function belief_theme_slug_hero_webm_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $url = '';
    if( isset( $options['herowebmlink'] ) ) {
      $url = esc_url( $options['herowebmlink'] );
    }

    echo '<input name="belief_theme_slug_theme_inputs_options[herowebmlink]" type="text" id="herowebmlink" value="' . $url . '" class="large-text code">
        <p class="description">direct link to the mp4 video for the preview hero.</p>';
  }

  function belief_theme_slug_process_header_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $header = '';
    if( isset( $options['processheader'] ) ) {
      $header = $options['processheader'];
    }

    echo '<input name="belief_theme_slug_theme_inputs_options[processheader]" type="text" id="processheader" value="' . $header . '" class="large-text">';
  }

  function belief_theme_slug_header_description_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $headerDesc = '';
    if( isset( $options['processdescription'] ) ) {
      $headerDesc = $options['processdescription'];
    }

    echo '<textarea rows="5" cols="50" name="belief_theme_slug_theme_inputs_options[processdescription]" id="processdescription" class="large-text code">' . $headerDesc . '</textarea>
        <p class="description">In a few words, explain a top level view of the process.</p>';
  }

  function belief_theme_slug_about_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $about = '';
    if( isset( $options['aboutbelief_theme_slug'] ) ) {
      $about = $options['aboutbelief_theme_slug'];
    }

    echo '<textarea rows="10" cols="50" name="belief_theme_slug_theme_inputs_options[aboutbelief_theme_slug]" id="aboutbelief_theme_slug" class="large-text code">' . $about . '</textarea>
        <p class="description">In a few words, explain who you are and why you are different.</p>';
  }

  function belief_theme_slug_contact_description_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $contactDesc = '';
    if( isset( $options['contactbelief_theme_slug'] ) ) {
      $contactDesc = $options['contactbelief_theme_slug'];
    }

    echo '<textarea rows="5" cols="50" name="belief_theme_slug_theme_inputs_options[contactbelief_theme_slug]" id="contactbelief_theme_slug" class="large-text code">' . $contactDesc . '</textarea><p class="description">direct link to the mp4 video for the preview hero.</p>';
  }

  function belief_theme_slug_address_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $address = '';
    if( isset( $options['belief_theme_slugaddress'] ) ) {
      $address = $options['belief_theme_slugaddress'];
    }

    echo '<textarea rows="5" cols="50" name="belief_theme_slug_theme_inputs_options[belief_theme_slugaddress]" id="belief_theme_slugaddress" class="large-text code">' . $address . '</textarea>';
  }

  function belief_theme_slug_email_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $email = '';
    if( isset( $options['belief_theme_slugemail'] ) ) {
      $email = $options['belief_theme_slugemail'];
    }

    echo '<input name="belief_theme_slug_theme_inputs_options[belief_theme_slugemail]" type="text" id="belief_theme_slugemail" value="' . $email . '" class="large-text">';
  }

  function belief_theme_slug_phone_callback() {
    $options = get_option( 'belief_theme_slug_theme_inputs_options' );
    $phone = '';
    if( isset( $options['belief_theme_slugphone'] ) ) {
      $phone = $options['belief_theme_slugphone'];
    }

    echo '<input name="belief_theme_slug_theme_inputs_options[belief_theme_slugphone]" type="text" id="belief_theme_slugphone" value="' . $phone . '" class="large-text">';
  }

  /* ------------------------------------------------------------------------ *
   * Input Validations
   * ------------------------------------------------------------------------ */

  function belief_theme_slug_theme_validate_inputs( $input ) {

    // Create our array for storing the validated options
    $output = array();

    // Loop through each of the incoming options
    foreach( $input as $key => $value ) {

      // Check to see if the current option has a value. If so, process it.
      if( isset( $input[$key] ) ) {

        // Strip all HTML and PHP tags and properly handle quoted strings
        $output[$key] = strip_tags( stripslashes( $input[ $key ] ) );

      } // end if

    } // end foreach

    // Return the array processing any additional functions filtered by this action
    return apply_filters( 'belief_theme_slug_theme_validate_inputs', $output, $input );

  }
}

new belief_theme_slug_Admin;
