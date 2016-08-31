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
	$LC = Live_Composer();
	var_dump($LC);
	vovaphperror( $LC->plugin_options, 'ive_Composer()->plugin_options');
	$LC->plugin_options->get_option( $option_id, $deprecated_section_id );

	return $value;
}
