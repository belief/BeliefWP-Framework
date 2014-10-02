<?php

/**
 *	Creates variables from form elements using POST
 *	stores all post variables into server sessions
 * 
 */
class Form_Session_Controller {
	private $rawdata;

	/**
	 * Creates the session controller
	 * @param Array $data Associated array of stored string ($_POST)
	 */
	public function __construct( $data ) {
		if ( isset($_POST) && !empty($_POST)) {
			$this->rawdata = $data;
			$this->processData();
			$this->render200();
		} else {
			$this->render404();
		}
	}

	/**
	 * Process the data and save it into $_SESSION vars
	 * @return nil
	 */
	private function processData() {
		session_start();

		$sessionData = $this->rawdata;
		foreach($sessionData as $key => $value) {
			$_SESSION[$key] = $value;
		}
	}

	/**
	 * Render 404 header
	 * @return nil 
	 */
	private function render404() {
		header('HTTP/1.1 401 Unauthorized', true, 401);
	}

	/**
	 * Render 200 header
	 * @return nil 
	 */
	private function render200() {
        header("HTTP/1.1 200 OK", true, 200);
	}
}

new Form_Session_Controller( $_POST );