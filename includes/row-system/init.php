<?php


// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

require DSLC_ROW_SYSTEM_ABS . '/inc/options.php';
require DSLC_ROW_SYSTEM_ABS . '/inc/options-output.php';
