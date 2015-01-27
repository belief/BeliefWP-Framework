##BeliefWP [![Built With Gulp](http://img.shields.io/badge/built%20with-gulp.js-red.png)](http://gulpjs.com)

Wordpress Theme Framework which uses Wordpress' Template Heirarchy, Custom Metabox Types, SCSS and RequireJS builds using Gulp Worflow.

##Features##
* belief folder consists of all app functionality
* Uses Gulp to transfer all files into theme folder
* Customizable theme naming with easy option and metaboxes
* Pre-built Design
* [Use Bourbon SCSS](http://bourbon.io/)
* [Using NEAT grid layout](http://neat.bourbon.io/)
* [requireJS Module Builds](http://requirejs.org/)
* [Uses Options Framework Plugin](http://www.billerickson.net/wordpress-metaboxes/)
* [Uses Twig Templating](https://wordpress.org/plugins/timber-library/)
* [Uses Custom Wordpress Metaboxes](http://www.billerickson.net/wordpress-metaboxes/)
* [Uses Wordpress Template Heirarchy](http://codex.wordpress.org/Template_Hierarchy)

##Note On Compatibility##
1. RequireJS
	* IE 6+ .......... compatible ✔
	* Firefox 2+ ..... compatible ✔
	* Safari 3.2+ .... compatible ✔
	* Chrome 3+ ...... compatible ✔
	* Opera 10+ ...... compatible ✔
2. [@mixin calc](http://caniuse.com/#feat=calc)
	* IE 10+ (Mobile 10+) 		...... compatible ✔
	* Firefox 4+ (Android 33+)  ...... compatible ✔
	* Chrome 19+ (Android 39+) 	...... compatible ✔
	* Safari 6+ (Mobile 6.1+)	...... compatible ✔
	* Opera 15+ (Mobile 24+)	...... compatible ✔
	* Android 4.4 (Partially)
3. [CSS Viewport (VH, VW, VMIN, VMAX)](http://caniuse.com/#feat=viewport-units)
	* IE 9 (Partially) (Mobile 10 Partially)
	* Firefox 19+				...... compatible ✔
	* Chrome 26+				...... compatible ✔
	* Safari 6.1+ (Mobile 8+)	...... compatible ✔	
	* Android 4.4+				...... compatible ✔
	* Opera 15+					...... compatible ✔

## Check us Out! ##

[![Follow us on Twitter](http://iod.unh.edu/Images/Twitter_follow_us.png "Follow us on Twitter")](https://twitter.com/beliefagency)

##Dev Information##

####For Gulp:
	1. ensure npm is installed.
	2. npm install (sudo may be required)
	3. gulp

####Create a Locall Database file: Template as follows"
- create a local folder inside public
- create a file inside local folder: wp-config.php
- use the template below for local settings:

```<?php
	/** The name of the database for WordPress */
	define('DB_NAME', 'database_name_here');

	/** MySQL database username */
	define('DB_USER', 'username_here');

	/** MySQL database password */
	define('DB_PASSWORD', 'password_here');

	/** MySQL hostname */
	define('DB_HOST', 'localhost');

	/** Database Charset to use in creating database tables. */
	define('DB_CHARSET', 'utf8');

	/** The Database Collate type. Don't change this if in doubt. */
	define('DB_COLLATE', '');

	/**#@+
	 * Authentication Unique Keys and Salts.
	 *
	 * Change these to different unique phrases!
	 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
	 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
	 *
	 * @since 2.6.0
	 */
	define('AUTH_KEY',         'put your unique phrase here');
	define('SECURE_AUTH_KEY',  'put your unique phrase here');
	define('LOGGED_IN_KEY',    'put your unique phrase here');
	define('NONCE_KEY',        'put your unique phrase here');
	define('AUTH_SALT',        'put your unique phrase here');
	define('SECURE_AUTH_SALT', 'put your unique phrase here');
	define('LOGGED_IN_SALT',   'put your unique phrase here');
	define('NONCE_SALT',       'put your unique phrase here');

	/**
	 * For developers: WordPress debugging mode.
	 *
	 * Change this to true to enable the display of notices during development.
	 * It is strongly recommended that plugin and theme developers use WP_DEBUG
	 * in their development environments.
	 */
	define('WP_DEBUG', true);
	define( 'BELIEF_THEME_SLUG', 'framework_test'); //optional to have slug defined
```