<?php

//bootstrap WP
require( $_SERVER['DOCUMENT_ROOT'] . '/wp-load.php' );

//boostrap AWS & S3
require 'composer/vendor/autoload.php';
use Aws\S3\S3Client;
use Aws\S3\Exception\S3Exception;


/**
 * Uploader Class to process files to send to S3 
 * Assumes the following Constants:
 *     AWS_ACCESS_KEY_ID
 *     AWS_SECRET_ACCESS_KEY
 *     AWS_SUBMISSION_BUCKET
 *
 *  Necessary to send $_POST variables uid and pid for correct storage of users
 * 
 */
class S3_Uploader_Controller {

    /**
     * Constructs the uploader controller
     * @param Array $argv associated array storing the file submissions ($_FILES suggested)
     */
    private function __construct($argv, $uid, $pid) {
        if (isset($argv['file_submission']['tmp_name']) ) {
            $filePath = $argv['file_submission']['tmp_name'];
            $name = $argv['file_submission']['name'];

            $keyname = "/uid/" . $uid . '/pid/' . $pid . '/' . $name;
            $keyname = str_replace(" ","_",$keyname);

            $this->uploadFile($keyname, $filePath, $name);
        } else {
            $this->render404();
        }
    }

    /**
     * Process the upload files given the temporary variables on server
     * @param  String $keyname  location in the s3 bucket
     * @param  String $filePath the temporary file location
     * @param  String $name     Name of the file
     * @return nil
     */
    private function uploadFile($keyname, $filePath, $name) {
        $args = array(
            'key'    => AWS_ACCESS_KEY_ID,
            'secret' => AWS_SECRET_ACCESS_KEY
        );

        $s3v1 = AmazonS3::factory($args);
        $s3v2 = S3Client::factory($args);
        
        $msg = "";
        $return = array();
        try {
            // Upload data.
            $result = $s3v2->putObject(array(
                'Bucket' => AWS_SUBMISSION_BUCKET,
                'Key'    => $keyname,
                'SourceFile'   => $filePath,
                'ACL'    => 'public-read'
            ));

            // Print the URL to the object.
            $msg = $result['ObjectURL'];

            $return = array(
                'status'    => 200,
                'msg'       => $msg,
                'name'      => $name
            );

            wp_send_json($return);

            $this->render200();
        } catch (S3Exception $e) {
            $msg = $e->getMessage() . "\n";

            $return = array(
                'status'    => 400,
                'msg'       => $msg,
            );

            wp_send_json($return);

            $this->render404();
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

new S3_Uploader_Controller( $_FILES, $_POST['uid'], $_POST['pid'] );