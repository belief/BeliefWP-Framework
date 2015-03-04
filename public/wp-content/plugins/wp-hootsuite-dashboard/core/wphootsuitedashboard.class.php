<?php
/**
 * Autoload classes
 */
spl_autoload_register('WPHootSuiteDashboard::autoload');
/**
 * Plugin Version Constant
 */
define('WPHOOTSUITEDASHBOARD_VERSION', WPHootSuiteDashboard::get_plugin_data(WPHOOTSUITEDASHBOARD_PLUGIN_FILE
)->Version);

class WPHootSuiteDashboard {

	protected static $instance;

	/**
	 * Get WPHootSuiteDashboard instance.
	 *
	 * @return WPHootSuiteDashboard instance
	 */
	public static function get_instance() {
		null === self::$instance && self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Callback static method for spl_autoload_register.
	 *
	 * @param $class Class name to load.
	 */
	public static function autoload($class) {
		if ('WPHootSuiteDashboard' !== mb_substr($class, 0, 20)) {
			return;
		}
		$path = WPHOOTSUITEDASHBOARD_PLUGIN_DIR_PATH;
		$file = str_replace('WPHootSuiteDashboard', '', $class);
		if (strpos($class, 'Admin') !== false) {
			require_once("{$path}core/controllers/admin/$file.php");
		} else if (strpos($class, 'Front') !== false) {
			require_once("{$path}core/controllers/front/$file.php");
		} else if (strpos($class, 'View') !== false) {
			require_once("{$path}core/controllers/$file.php");
		} else {
			require_once("{$path}core/lib/$file.php");
		}
	}

	/**
	 * Get plugin header data.
	 *
	 * @param string $file Absolute path to main plugin file which contains the header.
	 *
	 * @return object The plugin data fetched from the main file header.
	 */
	public static function get_plugin_data($file = __FILE__) {
		$default_headers = array('Name'        => 'Plugin Name',
		                         'PluginURI'   => 'Plugin URI',
		                         'Version'     => 'Version',
		                         'Description' => 'Description',
		                         'Author'      => 'Author',
		                         'AuthorURI'   => 'Author URI',
		                         'TextDomain'  => 'Text Domain',
		                         'DomainPath'  => 'Domain Path',
		                         'Network'     => 'Network',
			// Site Wide Only is deprecated in favor of Network.
		                         '_sitewide'   => 'Site Wide Only',
		);

		return (object)get_file_data($file, $default_headers, 'plugin');
	}

	public function WPHootSuiteDashboard() {
		$this->__construct();
	}

	public function __construct() {
		;
	}

	/**
	 * Initialize plugin
	 */
	public function init() {
        load_plugin_textdomain( WPHOOTSUITEDASHBOARD_DOMAIN, false, WPHOOTSUITEDASHBOARD_DOMAIN . '/lang/' );
		add_action('admin_menu', array(WPHootSuiteDashboardAdminController::get_instance(), 'admin_menu'));
		add_action('admin_init',
		           array(WPHootSuiteDashboardAdminController::get_instance(), 'wphootsuitedashboard_settings')
		);
	}
}

add_action('plugins_loaded', array(WPHootSuiteDashboard::get_instance(), 'init'));
