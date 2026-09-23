<?php


// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

require DSLC_MODULES_AREA_SYSTEM_ABS . '/inc/modules-area-options.php';
require DSLC_MODULES_AREA_SYSTEM_ABS . '/inc/modules-area-options-output.php';
