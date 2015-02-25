<?php
/*
Plugin Name: WP HootSuite Dashboard
Plugin URI: http://jaggededgemedia.com/plugins/wp-hootsuite-dashboard/
Description: Manage your social network accounts from the admin panel of your Wordpress site.
Version: 0.1.3
Author: Jagged Edge Media
Author URI: http://jaggededgemedia.com
License: GPL2 or later
*/
/*
This file is part of WP HootSuite Dashboard.

WP HootSuite Dashboard is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

WP HootSuite Dashboard is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Foobar.  If not, see <http://www.gnu.org/licenses/>.
*/
if ( basename( __FILE__ ) == basename( $_SERVER['SCRIPT_FILENAME'] ) ) {
    exit( 'This page cannot be called directly.' );
}
/**
 * Plugin file constants
 */
define( 'WPHOOTSUITEDASHBOARD_PLUGIN_SLUG', plugin_basename( __FILE__ ) );
define( 'WPHOOTSUITEDASHBOARD_PLUGIN_FILE', __FILE__ );
define( 'WPHOOTSUITEDASHBOARD_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
define( 'WPHOOTSUITEDASHBOARD_DOMAIN', dirname( WPHOOTSUITEDASHBOARD_PLUGIN_SLUG ) );
/**
 * Start WPHootSuiteDashboard
 */
require_once( 'core/wphootsuitedashboard.class.php' );
