<?php

/**
 * Table of Contents
 *
 * dslc_presets_load ( Replace current settings with preset settings )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


/**
 * Replace current settings with preset settings
 *
 * @since 1.0
 */

function dslc_presets_load( $settings ) {

	// If preset applied
	if ( isset( $settings['css_load_preset'] ) && $settings['css_load_preset'] !== '' ) {

		// Presets data
		$preset_id = $settings['css_load_preset'];

		// Allowed characters.
		$pattern_preset = '/^[0-9,a-zA-Z, ,_,-]{1,80}$/s';

		if ( ! preg_match( $pattern_preset, $preset_id ) ) {
			return $settings;
		}

		$presets = maybe_unserialize( get_option( 'dslc_presets' ) );
		$preset_data = false;

		// If there are presets.
		if ( is_array( $presets ) ) {

			// Go through all presets.
			foreach ( $presets as $preset ) {

				// Find the correct preset.
				if ( $preset['id'] == $preset_id ) {
					$preset_data = $preset;
				}
			}
		}

		// If preset exists.
		if ( $preset_data ) {

			// Get preset settings.
			$preset_settings = dslc_json_decode( $preset_data['code'], $ignore_migration = true );
			// $preset_settings = maybe_unserialize( base64_decode( $preset_data['code'] ) );
			$preset_settings_stripped = $preset_settings;

			// Go through all the settings.
			foreach ( $settings as $key => $value ) {

				// If the setting is in the presets, use it.
				if ( isset( $preset_settings[ $key ] ) ) {
					$settings[ $key ] = $preset_settings[ $key ];
					unset( $preset_settings_stripped[ $key ] );
				}
			}

			// Fill in the blanks.
			foreach ( $preset_settings_stripped as $key => $value ) {
				$settings[ $key ] = $value;
			}
		}
	}// End if().

	// Pass the settings back.
	return $settings;

} add_filter( 'dslc_filter_settings', 'dslc_presets_load' );

/**
 * Save Preset
 *
 * @since 1.0
 */
function dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) {

	$preset_id = strtolower( str_replace( ' ', '-', $preset_name ) );

	// Clean up ( step 1 - get data ).
	$preset_code_raw = dslc_json_decode( $preset_code_raw, $ignore_migration = true );
	$preset_code = array();

	// The ID of the module to add.
	$module_id = esc_attr( $module_id );

	if ( ! class_exists( $module_id ) ) {

		header( 'HTTP/1.1 400 Bad Request', true, 400 );
		die();
	}

	$module = new $module_id();
	$module_options = $module->options();

	// Clean up ( step 2 - generate correct preset code ).
	foreach ( $module_options as $module_option ) {

		// Allowed to have a preset.
		if ( ! isset( $module_option['include_in_preset'] ) || true === $module_option['include_in_preset'] ) {

			// Modules section not set or module section not functionality.
			if ( ( isset( $module_option['section'] ) && 'functionality' !== $module_option['section'] ) && ( ! isset( $module_option['visibility'] ) || 'hidden' !== $module_option['visibility'] ) ) {

				if ( isset( $preset_code_raw[ $module_option['id'] ] ) ) {

					if ( ! $module_option['ignored_by_preset'] ) {
						$preset_code[ $module_option['id'] ] = $preset_code_raw[ $module_option['id'] ];
					}
				}
			}
		}
	}

	// Clean up ( step 3 - final ).
	$preset_code = base64_encode( maybe_serialize( $preset_code ) );

	// Get current presets.
	$presets = get_option( 'dslc_presets' );

	// No presets = make empty array OR presets found = unserialize.
	if ( false === $presets ) {
		$presets = array();
	} else {
		$presets = maybe_unserialize( $presets );
	}

	// Append new preset to presets array.
	$presets[ $preset_id ] = array(
		'title' => $preset_name,
		'id' => $preset_id,
		'code' => $preset_code,
		'module' => $module_id,
	);

	// Allowed characters.
	$pattern_presset = '/^[0-9,\p{L},a-zA-Z, ,_,-]{1,80}$/s';

	// Quick presets validation.
	foreach ( $presets as $id => $preset ) {

		if ( empty( $preset['id'] ) ) {
			unset( $presets[ $id ] );
		} elseif ( ! preg_match( $pattern_presset, $id ) ) {
			unset( $presets[ $id ] );
		} elseif ( ! preg_match( $pattern_presset, $preset['id'] ) ) {
			unset( $presets[ $id ] );
		}
	}

	// Save new presets array to db and set the status.
	if ( update_option( 'dslc_presets', maybe_serialize( $presets ) ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Register Options
 *
 * @since 1.0
 */

function dslc_plugin_opts_presets() {

	global $dslc_plugin_options;

	$dslc_plugin_options['dslc_plugin_options_presets'] = array(
		'title' => __( 'Styling Presets', 'live-composer-page-builder' ),
		'options' => array(

			'lc_styling_presets' => array(
				'name' => 'dslc_plugin_options_presets[lc_styling_presets]',
				'label' => __( 'Styling Presets', 'live-composer-page-builder' ),
				'std' => 'both',
				'type' => 'styling_presets',
				'descr' => __( 'Here you can delete styling presets.', 'live-composer-page-builder' ),
			),
		),
	);

} //add_action( 'dslc_hook_register_options', 'dslc_plugin_opts_presets', 45 );
