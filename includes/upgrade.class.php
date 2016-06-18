<?php
/**
 * Upgrade class
 */
final class DSLC_Upgrade{

	public static init() {

		$curr_version = get_option( 'dslc_version' );

		if( ! $curr_version ) {

			$curr_version = 1;
		}

		$versions = array(

			'1',
			'1.3.4',
			'1.4',
			'1.5',
			'1.8.0.4',
		);

		foreach ( $versions  as $version) {

			if ( version_compare( $curr_version, $version, '<' ) ) {

				$method_name = 'update_' . str_replace('.', '_', $version );

				if ( method_exists( __CLASS__, $method_name ) ) {

					__CLASS__::$method_name();
				}
			}
		}

		// Updated ro current version.
		update_option( 'dslc_version', DS_LIVE_COMPOSER_VER );
	}

	public static update_1() {

		// Some code on version 1;
	}


	public static update_1_3_4() {

		// Some code on version 1.3.4;
	}

	public static update_1_4() {

		// Some code on version 1.4;
	}

	public static update_1_5() {

		// Some code on version 1.5;
	}

	public static update_1_8_0_4() {

		// Some code on version 1.8.0.4;
	}
}
