<?php
/**
 * Predesigned Sections for Live Composer
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

define( 'LCPS_DIR', plugin_dir_path( __FILE__ ) );
define( 'LCPS_URL', plugin_dir_url( __FILE__ ) );

define( 'LCPS_XML_FILE', LCPS_DIR . 'desings/sections/' );
define( 'LCPS_XML_IMG_URL', LCPS_URL . 'desings/images/' );
define( 'LCPS_XML_IMG_PATH', LCPS_DIR . 'desings/images/' );

// Include main class.
require_once( LCPS_DIR . 'class-lc-predesigned-sections.php' );

// AJAX: remove ps.
// @todo: needs work.
if ( isset( $_POST['delete_ps'] ) ) {
	add_action( 'plugins_loaded', array( 'LC_Predesigned_Sections', 'remove_predesigned_section_post' ) );
}

// Activate plugin.
new LC_Predesigned_Sections();
