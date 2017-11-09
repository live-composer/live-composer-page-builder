<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Upgrade class
 */
final class DSLC_Upgrade {

	public static function init() {

		$curr_version = DS_LIVE_COMPOSER_VER;
		$versions_log = get_option( 'dslc_version', array() );

		// Make sure $versions_log is array.
		if ( $versions_log && ! is_array( $versions_log ) ) {

			$versions_log = array();
			$versions_log[] = get_option( 'dslc_version', array() );
		}

		/** Migration usage example

		if ( ! in_array( '1.3', $versions_log ) ) {

			self::update_1_3();
		}
		*/

		// Update versions update history with new version.
		if ( ! in_array( $curr_version, $versions_log ) ) {

			$versions_log[] = $curr_version;

			usort( $versions_log, 'version_compare' );

			// Updated to current version.
			update_option( 'dslc_version', $versions_log );
		}
	}

	/**
	 * 1.3 version migration example

	public static function update_1_3() {

		// Some code on version 1.3.
		// Update_option( 'dslc_version','1.3' );
	}*/
}
