<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

$dslc_plugin_options = array(); // Holds all plugin options

include DSLC_PO_FRAMEWORK_ABS . '/inc/options.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/functions.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/performance.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/access-control.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/display-options.php';
include DSLC_PO_FRAMEWORK_ABS . '/inc/init.php';