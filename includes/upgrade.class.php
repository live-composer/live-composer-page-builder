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

		$curr_version = get_option( 'dslc_version' );

		if ( ! is_array( $curr_version ) ) {

			$curr_version = [];
		}

		/** Migration usage example

		if ( ! in_array( '1', $curr_version ) ) {

			self::update_1();
			$curr_version[] = 1;
		}

		if ( ! in_array( '1.3', $curr_version ) ) {

			self::update_1_3();
			$curr_version[] = '1.3';
		}*/

		if ( ! in_array( DS_LIVE_COMPOSER_VER, $curr_version ) ) {

			$curr_version[] = DS_LIVE_COMPOSER_VER;
		}

		$curr_version = sort( $curr_version );

		// Updated ro current version.
		update_option( 'dslc_version', $curr_version );
	}

	/**
	 * 1 version migration example

	public static function update_1() {

		// Some code on version 1.
		// Update_option( 'dslc_version', 1 );
	}
	 * 1.3 version migration example

	public static function update_1_3() {

		// Some code on version 1.3.
		// Update_option( 'dslc_version','1.3' );
	}*/
}
