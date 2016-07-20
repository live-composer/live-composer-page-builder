<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

include DSLC_ST_FRAMEWORK_ABS . '/inc/filters.php';
include DSLC_ST_FRAMEWORK_ABS . '/inc/functions.php';