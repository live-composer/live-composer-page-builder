<?php
/**
 * Class-container for custom options in settings panel
 */
class LC_Custom_Settings_Fields {

	/**
	 * Init actions.
	 * Filters methods with preg pattern, so future util
	 * functions won't mess up things.
	 */
	static public function init() {

		$methods_list = get_class_methods( __CLASS__ );

		foreach ( $methods_list as $method ) {

			if ( preg_match( '/lc_c_field_(.*)/', $method, $matches ) > 0 ) {

				add_action( 'dslc_custom_option_type_' . $matches[1][0], [ __CLASS__, $method ] );
			}
		}
	}

	/**
	 * Live Composer Custom Field group margin
	 */
	static public function lc_c_field_group_margin() {

		echo 'sdfsdfsdf';
	}
}

LC_Custom_Settings_Fields::init();
