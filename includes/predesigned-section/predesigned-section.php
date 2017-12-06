<?php
/**
 * Plugin Name: Predesigned Sections for Live Composer
 * Description: A module for Live Composer plugin
 * Version: 1.0
 */

// Reject direct plugin load
if ( !function_exists( 'add_action' ) )
	exit();

define( 'LCPS_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'LCPS_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

define( 'LCPS_PLUGIN_XML_FILE', LCPS_PLUGIN_DIR . 'predesigned-sections/predesigned-sections.xml' );
define( 'LCPS_PLUGIN_XML_IMG_URL', LCPS_PLUGIN_URL . 'predesigned-sections/img/' );
define( 'LCPS_PLUGIN_XML_IMG_PATH', LCPS_PLUGIN_DIR . 'predesigned-sections/img/' );

define( 'LCPS_CUSTOM_THEME_XML_FILE', get_template_directory() . '/predesigned-sections/predesigned-sections.xml' );
define( 'LCPS_CUSTOM_THEME_XML_IMG_URL', get_bloginfo('template_directory') . '/predesigned-sections/img/' );
define( 'LCPS_CUSTOM_THEME_XML_IMG_PATH', get_template_directory() . '/predesigned-sections/img/' );

// Include main class
include_once LCPS_PLUGIN_DIR . 'class-lc-base.php';
include_once LCPS_PLUGIN_DIR . 'class-lc-predesigned-sections.php';

// Plugin offline work
LC_Predesigned_Sections::offline_work();

// This plugin activation
// (register_activation_hook() must be called from the main plugin file)
register_activation_hook(
	__FILE__,
	array( 'LC_Predesigned_Sections', 'activation' )
);

// This plugin deactivation
// (register_deactivation_hook() must be called from the main plugin file)
register_deactivation_hook(
	__FILE__,
	array( 'LC_Predesigned_Sections', 'deactivation' )
);

// This plugin uninstall
register_uninstall_hook(
	__FILE__,
	array( 'LC_Predesigned_Sections', 'uninstall' )
);

// AJAX: remove ps
if ( isset( $_POST['delete_ps'] ) ) {
	add_action( 'plugins_loaded', array('LC_Predesigned_Sections', 'remove_predesigned_section_post'));
}

// Activate plugin
new LC_Predesigned_Sections();
