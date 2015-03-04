<?php

class WPHootSuiteDashboardDebugger {

	/**
	 * Creates an html page with printed variable dumped.
	 *
	 * @param mixed  $var       An array or object to be dumped.
	 * @param string $file_name The file name of the output file.
	 * @param string $path
	 */
	public static function print_html($var, $file_name, $path = "debug-files") {
		$var  = "<pre>" . print_r($var, true) . "</pre>";
		$dump = <<<EOD
<html>
    <head>
    <title>$file_name Dump</title>
    </head>
    <body>$var</body>
</html>
EOD;
		$path = ABSPATH . $path;
		if (!file_exists($path)) {
			@mkdir($path, 0755, true);
		}
		$file = $path . "/$file_name.html";
		$filehandle = fopen($file, 'w') or exit('Unable to write/open file.');
		@fwrite($filehandle, $dump);
		@fclose($filehandle);
	}

	/**
	 * Dump variable and print it enclosed in &lt;pre&gt; tags.
	 *
	 * @param mixed $var Variable to dump
	 */
	public static function print_rr($var) {
		echo self::get_print_rr($var);
	}

	/**
	 * Dump variable and return it enclosed in &lt;pre&gt; tags.
	 *
	 * @param mixed $var Variable to dump.
	 *
	 * @return string Dumped variable enclosed in &lt;pre&gt; tags.
	 */
	public static function get_print_rr($var) {
		return "<pre>" . print_r($var, true) . "</pre>";
	}
}