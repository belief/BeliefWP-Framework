<?php

if ( !defined('BELIEF_THEME_SLUG') ) {
	define( 'BELIEF_THEME_SLUG', 'test_theme');
}

if ( !defined('BELIEF_THEME_SLUG_UPPERCASE') ) {
	define( 'BELIEF_THEME_SLUG_UPPERCASE', strtoupper( BELIEF_THEME_SLUG ));
}

if ( !defined('BELIEF_THEME_TITLE') ) {
	define( 'BELIEF_THEME_TITLE', ucwords( str_replace("_"," ",BELIEF_THEME_SLUG) ) );
}


//directory location constants
define( 'PARENT_DIR', get_template_directory() );

//2nd tier
define( 'BELIEF_APP_DIR', PARENT_DIR . '/app' );
define( 'BELIEF_DIST_DIR', PARENT_DIR . '/dist' );

//3rd tier
define( 'BELIEF_IMAGES_DIR', BELIEF_DIST_DIR . '/images' );
define( 'BELIEF_CSS_DIR', BELIEF_DIST_DIR . '/css' );

define( 'BELIEF_JS_DIR', BELIEF_APP_DIR . '/js' );
define( 'BELIEF_FONTS_DIR', BELIEF_APP_DIR . '/fonts' );
define( 'BELIEF_ADMIN_DIR', BELIEF_APP_DIR . '/admin' );
define( 'BELIEF_CLASSES_DIR', BELIEF_APP_DIR . '/classes' );

define( 'BELIEF_METABOX_DIR', BELIEF_ADMIN_DIR . '/metabox' );