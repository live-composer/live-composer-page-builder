<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Retrieve value of all options
 */
function dslc_get_options( $section_id = false ) {

	global $dslc_plugin_options;

	/* Options from specific section */
	if ( $section_id ) {

		$options = get_option( $section_id );
		return $options;

	/* Options from all sections */
	} else {

		return 'Section ID not supplied';
	}
}

/**
 * Retrieve value of a single option
 */
function dslc_get_option( $option_id, $section_id ) {

	global $dslc_plugin_options;

	$value = null;
	$options = get_option( 'dslc_plugin_options' );

	// New way to get options since 1.0.8 (no section required).
	if ( isset( $options[ $option_id ] ) ) {

		$value = $options[ $option_id ];
	} elseif ( isset( $dslc_plugin_options[ $section_id ]['options'][ $option_id ] ) ) {
		$value = $dslc_plugin_options[ $section_id ]['options'][ $option_id ]['std'];
	} else {
		$value = '';
	}

	// Old way to get options (section + option id).
	if ( null === $value ) {

		$options = get_option( $section_id );

		if ( isset( $options[ $option_id ] ) ) {
			$value = $options[ $option_id ];
		} elseif ( isset( $dslc_plugin_options[ $section_id ]['options'][ $option_id ] ) ) {
			$value = $dslc_plugin_options[ $section_id ]['options'][ $option_id ]['std'];
		} else {
			$value = '';
		}
	}

	return $value;
}
