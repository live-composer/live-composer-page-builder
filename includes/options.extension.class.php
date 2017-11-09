<?php
/**
 * Extending admin interface with custom options
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

// Bad code style!
$dslc_extension; // Used in template

/**
 * DSLC_Extend_Options class
 */
class DSLC_Options_Extender {

	private $extension_options = array();
	protected $views = array();

	/**
	 * Returns option array
	 *
	 * @param  string $opt_id
	 * @param  string $ext_id
	 * @return array
	 */
	function get_option_array( $opt_id, $ext_id ) {

		if ( ! isset( $this->extension_options[ $ext_id ] ) ) { return array();
		}

		foreach ( $this->extension_options[ $ext_id ]['sections'] as $section ) {

			foreach ( $section['options'] as $option ) {

				if ( $option['id'] == $opt_id ) { return $option;
				}
			}
		}

		return array();
	}

	/**
	 * Add settings new panel to existing panels stack
	 *
	 * @param array $options_array
	 */
	function add_settings_panel( $options_array ) {

		if ( ! isset( $this->extension_options[ $options_array['extension_id'] ] ) ) {

			$this->extension_options[ $options_array['extension_id'] ] = $options_array;
		} else {

			throw new Exception( 'Settings panel with given extension_id already exists. Try another extension_id.' );
		}
	}

	/**
	 * Creates sub-menu pages in admin interface
	 */
	function construct_panels() {

		// Fill settings stack with panels
		do_action( 'dslc_extend_admin_panel_options' );

		foreach ( $this->extension_options as $extender ) {

			$extender['extension_id'] = strtolower( $extender['extension_id'] );

			$this->add_submenu_page( $extender );
			$this->register_setting( $extender );

			// Sections & fields
			if ( ! is_array( $extender['sections'] ) ) {
				return;
			}

			foreach ( $extender['sections'] as $section ) {

				$section['extension_id'] = $extender['extension_id'];

				$this->add_setting_section( $section );
			}
		}
	}

	/**
	 * Registers desired extension settings
	 *
	 * @param  array $extension
	 */
	private function register_setting( $extension ) {

		register_setting(
			'dslc_custom_options_' . $extension['extension_id'], // Option Group.
			'dslc_custom_options_' . $extension['extension_id'], // Option Name.
			'dslc_plugin_options_input_sanitize'// Sanitize.
		);
	}

	/**
	 * Adds one submenu page
	 *
	 * @param array $extension Options.
	 */
	private function add_submenu_page( $extension ) {

		$submenu_page = add_submenu_page(
			'dslc_plugin_options',
			__( $extension['title'], 'live-composer-page-builder' ),
			__( $extension['title'], 'live-composer-page-builder' ),
			'manage_options',
			'dslc_options_' . $extension['extension_id'],
			array( &$this, 'render_options_page' )
		);

		$this->views[ $submenu_page ] = $extension;
	}

	/**
	 * Render options page
	 */
	function render_options_page() {

		$extension = $this->views[ current_filter() ];

		// Include template.
		include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/options-extension-template.php';
	}

	/**
	 * Process one custom section
	 *
	 * @param array $section
	 */
	private function add_setting_section( $section ) {

		add_settings_section(
			'dslc_' . $section['extension_id'] . '_' . $section['id'], // id
			$section['title'], // title
			'dslc_plugin_options_display_options', // callback
			'dslc_' . $section['extension_id'] . '_' . $section['id'] // where to show
		);

		if ( ! is_array( $section['options'] ) ) { return;
		}

		foreach ( $section['options'] as $option ) {

			$option['section'] = 'dslc_' . $section['extension_id'] . '_' . $section['id'];
			$option['extension_id'] = $section['extension_id'];

			$this->add_option_field( $option );
		}
	}

	/**
	 * Adds one option field into system
	 *
	 * @param array $field
	 */
	private function add_option_field( $option ) {

		$option['name'] = 'dslc_custom_options_' . $option['extension_id'] . '[' . $option['id'] . ']';
		$option_ID = $option['id'];

		$value = '';
		$options = get_option( 'dslc_custom_options_' . $option['extension_id'] );

		if ( isset( $options[ $option['id'] ] ) ) {
			$value = $options[ $option['id'] ];
		} elseif ( isset( $option['std'] ) ) {
			$value = $option['std'];
		}

		$option['value'] = $value;

		add_settings_field(

			$option['id'], // id
			$option['label'], // title
			'dslc_option_display_funcitons_router', // callback
			$option['section'], // page
			$option['section'], // section
			$option // args
		);
	}
}

// Create class object.
$dslc_options_extender = new DSLC_Options_Extender;

function dslc_get_c_option( $opt_id, $ext_id ) {

	$value = get_option( 'dslc_custom_options_' . $ext_id );

	if ( isset( $value[ $opt_id ] ) ) {

		return $value[ $opt_id ];

	} else {

		global $dslc_options_extender;
		$option = $dslc_options_extender->get_option_array( $opt_id, $ext_id );

		if ( isset( $option['std'] ) ) {
			return $option['std'];
		} else {
			return '';
		}
	}
}
