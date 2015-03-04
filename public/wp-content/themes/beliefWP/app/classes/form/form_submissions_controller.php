<?php


/**
 *
 *	DEFINED POST TYPE AND OTHERKEYS ASSUMED FOR SUBMISSION
 *
 *
 * 
 */
define('USER_ID_POST_KEY','user_id');
define('PROJECT_ID_POST_KEY','project_id');
define('PROJECT_DATA_POST_KEY','project_data');
define('DEFAULT_THEME_OPTIONS','belief_theme_inputs_options');

/**
 *
 *	MOVE TO OTHER CONSTANTS FOR ASSIGNING!
 *
 * 
 */
define('FORM_SUBMISSION_CUSTOM_POST_TYPE','belief_submissions');
define('DEFAULT_THEME_SUBMISSION_EMAIL','belief_submission_from_email');
define('DEFAULT_THEME_SUBMISSION_UID','belief_submission_uid');
define('DEFAULT_THEME_SUBMISSION_PID','belief_submission_pid');
define('DEFAULT_THEME_SUBMISSION_S3_LINK','belief_submission_s3_link');
define('DEFAULT_THEME_SUBMISSION_DATA','belief_submission_data');



/**
 *   Bootstrapping WP
 */
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

/**
 *
 *	Submission Controller to commit submission with email and wordpress storage
 *
 * 
 */
class Form_Submissions_Controller {
	private $projectData;
	private $userID;
	private $projectID;
	private $s3URL;

	/**
	 * Creates the submission process given initial data
	 * @param Array $argv Associated array containing info about the project/user
	 */
	public function __construct( $argv) {
		if (isset($argv[USER_ID_POST_KEY]) &&
				isset($argv[PROJECT_ID_POST_KEY]) &&
				isset($argv[PROJECT_DATA_POST_KEY])) {
			$this->userID = $argv[USER_ID_POST_KEY];
			$this->projectID = $argv[PROJECT_ID_POST_KEY];
			$this->projectData = $argv[PROJECT_DATA_POST_KEY];

			$projectName = $this->setVariables($argv);
			$this->finalizeSubmission($projectName);
			$this->removeSessionCookieData();
			$this->render200();

		} else {
			$this->render404();
		}
	}


	/**
	 * Sets up the variables for proper usage
	 * @param Array $argv ARray containing data for this submission
	 * @return  String Name of this project to file
	 */
	private function setVariables($argv) {
		$this->projectData = stripslashes($this->projectData);
		$this->projectData = json_decode($this->projectData, true);

		$s3URL = '/uid/'. $userID . '/pid/' . $projectID . '/';

		$projectName = ($this->projectData['project_name'] !== "") ? $this->projectData['project_name'] : $this->projectID;

		return $projectName;
	}

	/**
	 * 	Finalize this submission
	 * @param  String $projectName name for this to be filed under
	 * @return nil            
	 */
	private function finalizeSubmission($projectName) {
		
		//args for storing the data
		$data = array (
			'post_title' => $projectName,
			'post_status' => "draft",
			'post_type' => FORM_SUBMISSION_CUSTOM_POST_TYPE
		);

		// insert post
		$published_id = wp_insert_post($data);


		add_post_meta($published_id, DEFAULT_THEME_SUBMISSION_UID, $this->userID, true);
		add_post_meta($published_id, DEFAULT_THEME_SUBMISSION_PID, $this->projectID, true);
		add_post_meta($published_id, DEFAULT_THEME_SUBMISSION_S3_LINK, $this->s3URL, true);
		add_post_meta($published_id, DEFAULT_THEME_SUBMISSION_DATA, addslashes(json_encode($this->projectData)) , true );


		$options = get_option( DEFAULT_THEME_OPTIONS );

		if ( isset( $options[DEFAULT_THEME_SUBMISSION_EMAIL] ) &&
				$options[DEFAULT_THEME_SUBMISSION_EMAIL] !== "") {
			$this->sendMailNotice( $options[DEFAULT_THEME_SUBMISSION_EMAIL] );
		};
	}

	/**
	 * Sends a notification to the email given
	 * @param  String $toEmail The destination email to notify submission
	 * @return nil          
	 */
	private function sendMailNotice($toEmail) {
			$htmlBody = '<html>';
			$htmlBody .= '
		<head><style>
			#poststuff .submission-table {
				width: 100%;
			}
			h3 {
				text-transform: capitalize;
				font-size: 18px;
				padding: 10px 0 5px;
				margin: 10px 0;
				border-bottom: 1px solid $light-gray;
			} 
		</style></head><body>';

			$htmlBody .= '<div style="width:100%; padding: 0 20px;">';
			$htmlBody .= '<h1>New Form Submission:'.$projectName.'</h1>';
			$htmlBody .= '<h3>User ID:</h3>';
			$htmlBody .= '<div style="word-break: break-all; word-break: break-word;">' . $this->userID .'</div>';
			$htmlBody .= '<h3>Project ID:</h3>';
			$htmlBody .= '<div style="word-break: break-all; word-break: break-word;">' . $this->projectID .'</div>';
			$htmlBody .= '<h3>S3 Reference:</h3>';
			$htmlBody .= '<div style="word-break: break-all; word-break: break-word;">' . $this->s3URL .'</div>';

			$htmlBody .= '<br /><br />';
			$htmlBody .= '<table class="submission-table">';
			foreach($projectData as $key => $value) {
				if ($value != "" && $value !== '- Select -') {
					$htmlBody .= '<tr><td>';
					$htmlBody .= '<h3>'.str_replace("_"," ",$key).'</h3>';
					$htmlBody .= '<div>'.$value.'</div>';
					$htmlBody .= '</td></tr>';
				}
			}
			$htmlBody .= '</table>';

			$htmlBody .= '</div></body></html>';

			$subject = 'New User Submission: '.$projectName;
			$headers = "Content-Type: text/html; charset=UTF-8
			";
			$headers .= "MIME-Version: 1.0
			";
			$headers .= 'From: Kerf Submissions Email <'.$email.'>
			';

			function wpse27856_set_content_type(){
			    return "text/html";
			}
			add_filter( 'wp_mail_content_type','wpse27856_set_content_type' );

			wp_mail($toEmail,$subject,$htmlBody,$headers);
	}

	/**
	 * Removes all session cookies from the server
	 * @return nil 
	 */
	private function removeSessionCookieData() {
		// Initialize the session.
		// If you are using session_name("something"), don't forget it now!
		session_start();

		// Unset all of the session variables.
		$_SESSION = array();

		// If it's desired to kill the session, also delete the session cookie.
		// Note: This will destroy the session, and not just the session data!
		if (isset($_COOKIE[session_name()])) {
		    setcookie(session_name(), '', time()-42000, '/');
		}

		// Finally, destroy the session.
		session_unset();
		session_destroy();
		session_write_close();
		setcookie(session_name(),'',0,'/');
		session_regenerate_id(true);
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

new Form_Submissions_Controller( $_POST );