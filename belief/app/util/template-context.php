<?php
/*
 * Use to initialize context and reduce duplication
 * in our template files.
 */

if ( !class_exists('Timber') ) {
	echo 'Timber not activated. Activate the plugin in <a href="/wp-admin/plugins.php#timber">/wp-admin/plugins.php</a>';
}