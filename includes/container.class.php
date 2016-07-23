<?php
/**
 * Container class represents elementary object that should be extended
 * to create Row, Module Area, Wrapper
 */

/**
 * Container abstract class
 */
abstract class DSLC_Container {

	var $id;
	var $options;
	var $content;

	/**
	 * Constructs Container object
	 *
	 * @param array  $options
	 * @param string $content
	 */
	public function __construct( $options, $content = '' ) {

		if ( isset( $options['id'] ) ) {

			self::$id = $options['id'];
		} else {

			self::$id = ( new DateTime )->time( 'U' );
		}

		self::$content = $content;
		self::$options = $options;
	}

	/**
	 * Function represents content renderer
	 *
	 * @return string
	 */
	public function render_container() {}

	/**
	 * Generates CSS styles for container
	 *
	 * @return string
	 */
	public function generate_styles() {}

	/**
	 * Returns options & contents in JSON format
	 *
	 * @return string{JSON}
	 */
	public function get_json() {

		$out = array();

		$out['options'] = self::$options;
		$out['content'] = self::$options;

		return json_encode( $out );
	}
}
