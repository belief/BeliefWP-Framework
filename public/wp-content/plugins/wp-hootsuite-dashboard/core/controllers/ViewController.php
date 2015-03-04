<?php

class WPHootSuiteDashboardViewController {

	protected static $instance;

	public function PLUGIN_NAMEViewController() {
		$this->__construct();
	}

	public function __construct() {
		;
	}

	/**
	 * Get PLUGIN_NAMEViewController instance
	 *
	 * @return WPHootSuiteDashboardViewController
	 */
	public static function get_instance() {
		null === self::$instance && self::$instance = new self;

		return self::$instance;
	}

	/**
	 * Includes the requested page from views directory. <strong>Note:</strong> Views should be prefixed with 'admin'
	 * if view to be requested is for plugin admin pages and 'front' for frontend pages.
	 *
	 * @param string $view   The 'view' file name to include.
	 * @param array  $vars   The array of variables to be used in the view.
	 * @param bool   $return True to output the included file directly to the browser. Otherwise, return the included
	 *                       file as string.
	 *
	 * @return string If <code>$return</code> is true, then return the included file as string.
	 */
	public function make_view($view, $vars = array(), $return = false) {
		if (!empty($vars)) {
			extract($vars, EXTR_SKIP);
		}
		$plugin_data = WPHootSuiteDashboard::get_instance()->get_plugin_data(WPHOOTSUITEDASHBOARD_PLUGIN_FILE);
		$path        = WPHOOTSUITEDASHBOARD_PLUGIN_DIR_PATH;
		$view_error  = "{$path}core/views/view-error.php";

		if ($return) {
			ob_start();
		}
		if ('admin' === mb_substr($view, 0, 5)) {
			$view = "{$path}core/views/admin/$view.php";
			if (file_exists($view)) {
				include_once($view);
			} else {
				include_once($view_error);
			}
		} else if ('front' === mb_substr($view, 0, 5)) {
			$view = "{$path}core/views/front/$view.php";
			if (file_exists($view)) {
				include_once($view);
			} else {
				include_once($view_error);
			}
		} else {
			include_once($view_error);
		}
		if ($return) {
			return ob_get_clean();
		}
	}
}