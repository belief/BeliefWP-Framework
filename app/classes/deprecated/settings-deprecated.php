<?php 

class Belief_Settings {

	public function __construct() {
		$this->instance =& $this;
		//initialize the theme structure
		//
		if ( is_admin() && !function_exists('optionsframework_init') ):
			add_action( 'admin_init', array( $this, 'belief_initialize_theme_options' ) );

			add_action( 'admin_menu', array( $this, 'belief_settings_api_init') );
		endif;
	}

	/**
	    Dashboard Menu

	*/

	public function belief_settings_api_init() {
	  add_theme_page(
	    'Edit ' . BELIEF_THEME_TITLE .' Theme',          // The title to be displayed in the browser window for this page.
	    BELIEF_THEME_TITLE.' Theme',          // The text to be displayed for this menu item
	    'administrator',          // Which type of users can see this menu item
	    BELIEF_THEME_SLUG.'_theme_options',      // The unique ID - that is, the slug - for this menu item
	    array( $this, 'belief_theme_inputs')       // The name of the function to call when rendering this menu's page
	  );

	  add_menu_page(
	    'Edit ' . BELIEF_THEME_TITLE .' Theme',          // The value used to populate the browser's title bar when the menu page is active
	    BELIEF_THEME_TITLE.' Theme',          // The text of the menu in the administrator's sidebar
	    'administrator',          // What roles are able to access the menu
	    BELIEF_THEME_SLUG.'_theme_menu',       // The ID used to bind submenu items to this menu
	    array( $this, 'belief_theme_inputs')       // The callback function used to render this menu
	  );
	}


	/**
	    Setup Theme Options

	*/
	

	public function belief_theme_inputs() {
	?>
	 <div class="wrap">

	   <div id="icon-themes" class="icon32"></div>
	   <h2><?php _e( BELIEF_THEME_TITLE.' Theme Options' ); ?></h2>
	   <?php settings_errors(); ?>

	   <form method="post" action="/wp-admin/options.php">
       <input type="hidden" value="/wp-admin/options.php?page=[<?php echo BELIEF_THEME_SLUG;?>_theme_inputs_options]" name="_wp_http_referer">
	     <?php

	       settings_fields( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	       do_settings_sections( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	       submit_button();

	     ?>
	   </form>
	 </div>
	<?php
	}

	public function belief_initialize_default_theme_options() {
	  $defaults = array(
	  	'heromp4link' => '',
	  	'herowebmlink' => '',
	  	'ga_tracking_id' => '',
	  	'gtm_tracking' => '',
	  	'office_address' => '',
	  	'phone' => '',
	  	'copyright' => '',
	  	'facebook_url' => '',
	  	'vimeo_url' => '',
	  	'youtube_url' => '',
	  	'twitter_url' => '',
	  	'gplus_url' => '',
	  	'instagram_url' => '',
	  	'linkedin_url' => '',
	  	'pinterest_url' => '',
	  	'github_url' => ''

	  );
	  update_option( BELIEF_THEME_SLUG.'_theme_inputs_options', $defaults );
	}

	public function belief_initialize_theme_options() {
	  if( false == get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' ) ) {
	    $this->belief_initialize_default_theme_options();
	  }

	  //video
	  add_settings_section(
	    BELIEF_THEME_SLUG.'_video_info_section',
	    __( 'Video'),
	    array( $this, 'belief_video_info_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options'
	  );

	  add_settings_field(
	    'heromp4link',
	    __( 'Hero mp4 URL' ),
	    array( $this, 'belief_hero_mp4_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_video_info_section'
	  );

	  add_settings_field(
	    'herowebmlink',
	    __( 'Hero Webm URL'),
	    array( $this, 'belief_hero_webm_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_video_info_section'
	  );

	  //analytics
	  add_settings_section(
	    BELIEF_THEME_SLUG.'_analytics_section',
	    __( 'Analytics'),
	    array( $this, 'belief_analytics_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options'
	  );

	  add_settings_field(
	    'ga_tracking_id',
	    __( 'Analytics Tracking ID' ),
	    array( $this, 'belief_ga_tracking_id_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_analytics_section'
	  );

	  add_settings_field(
	    'gtm_tracking',
	    __( 'Google Tag Manager Code'),
	    array( $this, 'belief_gtm_tracking_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_analytics_section'
	  );

	  //business
	  add_settings_section(
	    BELIEF_THEME_SLUG.'_biz_section',
	    __( 'Business Info'),
	    array( $this, 'belief_biz_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options'
	  );

	  add_settings_field(
	    'office_address',
	    __( 'Office Address'),
	    array( $this, 'belief_office_address_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_biz_section'
	  );

	  add_settings_field(
	    'phone',
	    __( 'Phone'),
	    array( $this, 'belief_phone_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_biz_section'
	  );

	  add_settings_field(
	    'copyright',
	    __( 'Copyright'),
	    array( $this, 'belief_copyright_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_biz_section'
	  );

	  //social
	  add_settings_section(
	    BELIEF_THEME_SLUG.'_social_section',
	    __( 'Social'),
	    array( $this, 'belief_social_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options'
	  );

	  add_settings_field(
	    'facebook_url',
	    __( 'Facebook URL'),
	    array( $this, 'belief_facebook_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'vimeo_url',
	    __( 'Vimeo URL'),
	    array( $this, 'belief_vimeo_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'youtube_url',
	    __( 'Youtube URL'),
	    array( $this, 'belief_youtube_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'twitter_url',
	    __( 'Twitter URL'),
	    array( $this, 'belief_twitter_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'gplus_url',
	    __( 'Google Plus URL'),
	    array( $this, 'belief_gplus_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'instagram_url',
	    __( 'Instagram URL'),
	    array( $this, 'belief_instagram_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'linkedin_url',
	    __( 'LinkedIn URL'),
	    array( $this, 'belief_linkedin_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'pinterest_url',
	    __( 'Pinterest URL'),
	    array( $this, 'belief_pinterest_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  add_settings_field(
	    'github_url',
	    __( 'Github URL'),
	    array( $this, 'belief_github_url_callback'),
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_social_section'
	  );

	  //register them!
	  register_setting(
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    BELIEF_THEME_SLUG.'_theme_inputs_options',
	    array( $this, 'belief_options_validate_inputs')
	  );
	}

	/**
	    Section Callbacks

	*/

	/*------------------------------------------------------------------------ *
	 * Headers Callbacks
	 * ------------------------------------------------------------------------
	 */
	public function belief_video_info_callback() {
	  echo '<p>' . __( 'Video Tag Settings') . '</p>';
	}

	public function belief_analytics_callback() {
	  echo '<p>' . __( 'Google Analytics Settings') . '</p>';
	}

	public function belief_biz_callback() {
	  echo '<p>' . __( 'Business Information') . '</p>';
	}

	public function belief_social_callback() {
	  echo '<p>' . __( 'Social Information') . '</p>';
	}

	/*------------------------------------------------------------------------ *
	 * Analytics Callbacks
	 * ------------------------------------------------------------------------
	 */
	public function belief_ga_tracking_id_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['ga_tracking'] ) ) {
		  $url = $options['ga_tracking'];
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[ga_tracking]" type="text" id="ga_tracking" value="' . $url . '" class="large-text code">
		    <p class="description">Your Analytics Property ID: UA-XXXXXXXX-X</p>';
	}

	public function belief_gtm_tracking_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$gtm_tracking = '';
		if( isset( $options['gtm_tracking'] ) ) {
		  $gtm_tracking = $options['gtm_tracking'];
		}

	  echo '<textarea rows="5" cols="50" name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[gtm_tracking]" id="gtm_tracking" class="large-text code">' . $gtm_tracking . '</textarea>
		    <p class="description">Overwrites GA Code! Provide full gtm snippet here.</p>';
	}

	/*------------------------------------------------------------------------ *
	 * Video Callbacks
	 * ------------------------------------------------------------------------
	 */
	public function belief_hero_mp4_callback() {
	  $options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	  $url = '';
	  if( isset( $options['heromp4link'] ) ) {
	    $url = esc_url( $options['heromp4link'] );
	  }

	  echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[heromp4link]" type="text" id="heromp4link" value="' . $url . '" class="large-text code">
	      <p class="description">direct link to the mp4 video for the preview hero.</p>';
	}

	public function belief_hero_webm_callback() {
	  $options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	  $url = '';
	  if( isset( $options['herowebmlink'] ) ) {
	    $url = esc_url( $options['herowebmlink'] );
	  }

	  echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[herowebmlink]" type="text" id="herowebmlink" value="' . $url . '" class="large-text code">
	      <p class="description">direct link to the mp4 video for the preview hero.</p>';
	}

	/*------------------------------------------------------------------------ *
	 * Business Callbacks
	 * ------------------------------------------------------------------------
	 */
	public function belief_office_address_callback() {
	  $options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	  $office_address = '';
	  if( isset( $options['office_address'] ) ) {
	    $office_address = $options['office_address'];
	  }

	  echo '<textarea rows="5" cols="50" name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[office_address]" id="office_address" class="large-text code">' . $office_address . '</textarea>';
	}

	public function belief_phone_callback() {
	  $options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	  $phone = '';
	  if( isset( $options['phone'] ) ) {
	    $phone = $options['phone'];
	  }

	  echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[phone]" type="text" id="phone" value="' . $phone . '" class="large-text code">
	      <p class="description">direct link to the mp4 video for the preview hero.</p>';
	}

	public function belief_copyright_callback() {
	  $options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
	  $copyright = '';
	  if( isset( $options['copyright'] ) ) {
	    $copyright = $options['copyright'];
	  }

	  echo '<textarea rows="5" cols="50" name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[copyright]" id="copyright" class="large-text code">' . $copyright . '</textarea>';
	}

	/*------------------------------------------------------------------------ *
	 * Social Callbacks
	 * ------------------------------------------------------------------------
	 */
	public function belief_facebook_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['facebook_url'] ) ) {
		  $url = esc_url( $options['facebook_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[facebook_url]" type="text" id="facebook_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_vimeo_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['vimeo_url'] ) ) {
		  $url = esc_url( $options['vimeo_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[vimeo_url]" type="text" id="vimeo_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_youtube_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['youtube_url'] ) ) {
		  $url = esc_url( $options['youtube_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[youtube_url]" type="text" id="youtube_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_twitter_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['twitter_url'] ) ) {
		  $url = esc_url( $options['twitter_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[twitter_url]" type="text" id="twitter_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_gplus_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['gplus_url'] ) ) {
		  $url = esc_url( $options['gplus_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[gplus_url]" type="text" id="gplus_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_instagram_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['instagram_url'] ) ) {
		  $url = esc_url( $options['instagram_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[instagram_url]" type="text" id="instagram_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}

	public function belief_linkedin_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['linkedin_url'] ) ) {
		  $url = esc_url( $options['linkedin_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[linkedin_url]" type="text" id="linkedin_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}
	
	public function belief_pinterest_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['pinterest_url'] ) ) {
		  $url = esc_url( $options['pinterest_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[pinterest_url]" type="text" id="pinterest_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}
	
	public function belief_github_url_callback() {
		$options = get_option( BELIEF_THEME_SLUG.'_theme_inputs_options' );
		$url = '';
		if( isset( $options['github_url'] ) ) {
		  $url = esc_url( $options['github_url'] );
		}

		echo '<input name="'.BELIEF_THEME_SLUG.'_theme_inputs_options[github_url]" type="text" id="github_url" value="' . $url . '" class="large-text code">
		    <p class="description"></p>';
	}


	/* ------------------------------------------------------------------------ *
	 * Input Validations
	 * ------------------------------------------------------------------------ */

	public function belief_options_validate_inputs( $input ) {

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
