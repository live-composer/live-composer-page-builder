<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Retrieve value of all options
 * Function deprecated. We don't store settings by sections anymore.
 */
function dslc_get_options( $section_id = false ) {
	// Deprecated.
}

/**
 * Retrieve value of a single option
 * Function deprecated. Use the code inside of the function directly.
 */
function dslc_get_option( $option_id, $deprecated_section_id ) {
	$lc = Live_Composer();
	$value = $lc->plugin_options->get_option( $option_id, $deprecated_section_id );

	return $value;
}

/**
 * Check plugin settings (FEATURE CONTROL) and unregister disabled modules.
 *
 * @return void
 */
function dslc_feature_control_unregister() {

	global $dslc_var_modules;

	$lc = Live_Composer();
	$settings = $lc->plugin_options->get_all_options(); // Plugin Settings.

	foreach ( $dslc_var_modules as $module ) {

		if ( isset( $settings[ $module['id'] ] ) && 'disabled' === $settings[ $module['id'] ] ) {
			dslc_unregister_module( $module['id'] );
		}
	}
} add_action( 'dslc_hook_unregister_modules', 'dslc_feature_control_unregister', 999 );


/**
 * Display option pages
 *
 * @param string $tab Tab to display.
 */
function dslc_plugin_options_display( $tab = '' ) {
	// Moved to LC_Plugin_Options > plugin_options_page_content.
}

/**
 * Register options
 */
function dslc_plugin_options_init() {
	// Moved to LC_Plugin_Options > register_option_panels.
}

/**
 * Register all the option pages
 */
function dslc_plugin_options_setup() {
// Deprecated. Moved into LC_Plugin_Options > create_plugin_options_page
}

/**
 * Function router to not use anonymous functions
 *
 * @param  array $option Option data.
 * @return void
 */
function dslc_option_display_funcitons_router( $option ) {
	if ( 'text' === $option['type'] ) {
		dslc_plugin_option_display_text( $option );
	} elseif ( 'textarea' === $option['type'] ) {
		dslc_plugin_option_display_textarea( $option );
	} elseif ( 'select' === $option['type'] ) {
		dslc_plugin_option_display_select( $option );
	} elseif ( 'checkbox' === $option['type'] ) {
		dslc_plugin_option_display_checkbox( $option );
	} elseif ( 'list' === $option['type'] ) {
		dslc_plugin_option_display_list( $option );
	} elseif ( 'radio' === $option['type'] ) {
		dslc_plugin_option_display_radio( $option );
	} elseif ( 'styling_presets' === $option['type'] ) {
		dslc_plugin_option_display_styling_presets( $option );
	}
}

/**
 * Required Function
 *
 * This function is required for add_settings_section
 * even if we don't print any data inside of it.
 * In our case all the settings fields rendered
 * by callback from add_settings_field.
 *
 * @param section $section Docs section.
 */
function dslc_plugin_options_display_options( $section ) {

}

/**
 * Sanitize each setting field on submit
 *
 * @param array $input Contains all the settings as single array, with fields as array keys.
 */
function dslc_plugin_options_input_sanitize( $input ) {

	$new_input = array();

	foreach ( $input as $key => $option_value ) {

		if ( ! is_array( $option_value ) ) {

			$new_input[ $key ] = sanitize_text_field( $option_value );

		} else {

			foreach ( $option_value as $inner_key => $inner_option_value ) {

				$new_input[ $key ][ $inner_key ] = sanitize_text_field( $inner_option_value );

			}
		}
	}

	return $new_input;
}

/**
 * Active Campaign
 */
function dslc_ajax_check_activecampaign() {

	// Check Nonce.
	if ( ! wp_verify_nonce( $_POST['security']['nonce'], 'dslc-optionspanel-ajax' ) ) {
		wp_die( 'You do not have rights!' );
	}

	// Check access permissions.
	if ( ! current_user_can( 'install_plugins' ) ) {
		wp_die( 'You do not have rights!' );
	}

	$email = sanitize_email( $_POST['email'] );
	$name = sanitize_text_field( $_POST['name'] );

	$dslc_getting_started = array(
	'email' => $email,
	'name' => $name,
	'subscribed' => '1',
	);

	add_option( 'dslc_user', $dslc_getting_started );

	wp_die();

}
add_action( 'wp_ajax_dslc_activecampaign', 'dslc_ajax_check_activecampaign' );
