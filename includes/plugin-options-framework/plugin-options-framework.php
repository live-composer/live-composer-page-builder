<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

$dslc_plugin_options = array(); // Holds all plugin options

require DSLC_PO_FRAMEWORK_ABS . '/inc/options.php';
require DSLC_PO_FRAMEWORK_ABS . '/inc/functions.php';
require DSLC_PO_FRAMEWORK_ABS . '/inc/performance.php';
require DSLC_PO_FRAMEWORK_ABS . '/inc/access-control.php';
require DSLC_PO_FRAMEWORK_ABS . '/inc/display-options.php';
require DSLC_PO_FRAMEWORK_ABS . '/inc/init.php';
