<?php
/**
 * Upgrade class
 */
final class DSLC_Upgrade{

	public static function init() {

		$curr_version = get_option( 'dslc_version' );

		if ( ! is_array( $curr_version ) ) {

			$curr_version = [];
		}

		if ( ! in_array( '1', $curr_version ) ) {

			self::update_1();
			$curr_version[] = 1;
		}

		if ( ! in_array( '1.3', $curr_version ) ) {

			self::update_1_3();
			$curr_version[] = '1.3';
		}

		if ( ! in_array( '1.8', $curr_version ) ) {

			self::update_1_8_0_4();
			$curr_version[] = '1.8.0.4';
		}

		if ( ! in_array( DS_LIVE_COMPOSER_VER, $curr_version ) ) {

			$curr_version[] = DS_LIVE_COMPOSER_VER;
		}

		$curr_version = sort( $curr_version );

		// Updated ro current version.
		update_option( 'dslc_version', $curr_version );
	}

	public static function update_1() {

		// Some code on version 1.
		update_option( 'dslc_version', 1 );
	}


	public static function update_1_3_4() {

		// Some code on version 1.3.4.
		update_option( 'dslc_version','1.3.4' );
	}

	public static function update_1_4() {

		// Some code on version 1.4.
		update_option( 'dslc_version', '1.4' );
	}

	public static function update_1_5() {

		// Some code on version 1.5.
		update_option( 'dslc_version', '1.5' );
	}

	public static function update_1_8_0_4() {

		// Some code on version 1.8.0.4.
		update_option( 'dslc_version', '1.8.0.4' );
	}
}
