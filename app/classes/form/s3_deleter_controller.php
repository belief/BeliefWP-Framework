<?php

//bootstrap WP
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

//boostrap AWS & S3
require 'composer/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


/**
 * Uploader Class to process files to delete From S3 
 * Assumes the following Constants:
 *     AWS_ACCESS_KEY_ID
 *     AWS_SECRET_ACCESS_KEY
 *     AWS_SUBMISSION_BUCKET
 *     DELETE_FILE_KEY				//string to define the $argv key for the strin value of sourcepath
 *     
 * 
 */
define('DELETE_FILE_KEY', 'delete_file');

class S3_Deleter_Controller {

	/**
	 * Constructs the server file removal controller
	 * @param Array $argv associated array storing the file submissions ($_POST suggested)
	 */
	private function __construct($argv) {
		if ( isset($argv[DELETE_FILE_KEY]) ) {
			$rawURL = $argv[DELETE_FILE_KEY];
			$keyname =  preg_replace('/.*(?=\/uid)/','',$rawURL);
			$keyname = str_replace(" ","_",$keyname);

			$this->deleteServerFile($keyname);
		} else {
			$this->render404();
		}
	}


	/**
	 * Removes the file at the location from the server
	 * @param  String $keyname location of the file in the bucket
	 * @return nil          
	 */
	private function deleteServerFile($keyname) {
		$args = array(
		    'key'    => AWS_ACCESS_KEY_ID,
		    'secret' => AWS_SECRET_ACCESS_KEY
		);

		$s3v1 = AmazonS3::factory($args);
		$s3v2 = S3Client::factory($args);

		$msg = "";
		$return = array();
		try {

			$result = $s3v2->deleteObject(array(
			    'Bucket' => AWS_SUBMISSION_BUCKET,
			    'Key'    => $keyname
			));

		    $return = array(
				'status'	=> 200,
				'msg'		=> 'Successfully deleted: ' . $keyname,
			);
			
			$this->render200();
		} catch (S3Exception $e) {
		    $msg = $e->getMessage() . "\n";

		    $return = array(
				'status'	=> 400,
				'msg'		=> $msg,
			);

		    $this->render404();
		}

		wp_send_json($return);
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
	
new S3_Deleter_Controller($_POST);
?>