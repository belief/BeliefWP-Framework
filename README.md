##BELIEF THEME TEMPLATE

###General Info

This is the template Theme for Wordpress by Belief. This current theme is designed under Wordpress version 4.0.0 There are a few vendor projects included in this template with gulp and requirejs, and for the most part the dependancies are listed through gulp, etc.

###Before Install:
1. go to your wp-config file and add a define method:

	define( 'BELIEF_THEME_SLUG', '[[Theme Slug Name Here]]');

2. remove the define method in app/util/constants
3. filter through js modules and vendors depending on scope of project.

###For Gulp:
	1. ensure npm is installed.
	2. npm install (sudo may be required)
	3. gulp

###App Utilities:
	1. SCSS
	2. Require.js

###A few frameworks to be aware of:

- http://www.billerickson.net/wordpress-metaboxes/
- http://codex.wordpress.org/Template_Hierarchy
