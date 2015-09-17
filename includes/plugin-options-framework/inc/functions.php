<?php
	
	/**
	 * Retrieve value of all options
	 */

	function dslc_get_options( $section_ID = false ) {

		global $dslc_plugin_options;

		/* Options from specific section */
		if ( $section_ID ) {

			$options = get_option( $section_ID );
			return $options;

		/* Options from all sections */
		} else {

			return 'Section ID not supplied';

		}

	}

	/**
	 * Retrieve value of a single option
	 */

	function dslc_get_option( $option_ID, $section_ID ) {

		global $dslc_plugin_options;		

		$options = get_option( $section_ID );
	
		if ( isset( $options[ $option_ID ] ) )
			$value = $options[$option_ID];
		elseif ( isset ( $dslc_plugin_options[$section_ID]['options'][$option_ID] ) )
			$value = $dslc_plugin_options[$section_ID]['options'][$option_ID]['std'];
		else
			$value = '';		

		return $value;

	}