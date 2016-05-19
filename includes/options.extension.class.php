<?php
/**
 * Extending admin interface with custom options
 */

/**
 * DSLC_Extend_Options class
 */
class DSLC_Options_Extender {

	private $extensionOptions = [];

	/**
	 * Add settings new panel to existing panels stack
	 * @param array $optionsArray
	 */
	function addSettingsPanel( $optionsArray ) {

		if ( ! isset( $this->extensionOptions[$optionsArray['extensionId']] ) ) {

			$this->extensionOptions[$optionsArray['extensionId']] = $optionsArray;
		}else{

			throw new Exception( "Settings panel with given extensionId already exists. Try another extensionId." );
		}
	}

	/**
	 * Creates sub-menu pages in admin interface
	 */
	function constructPanels() {

		/// Fill settings stack with panels
		do_action( 'dslc_extend_admin_panel_options' );

		foreach( $this->extensionOptions as $extender ) {

			$extender['extensionId'] = strtolower( $extender['extensionId'] );

			$this->addSubmenuPage( $extender );
			$this->registerSetting( $extender );

			/// Sections & fields
			if ( ! is_array( $extender['sections'] ) ) return;

			foreach( $extender['sections'] as $section ) {

				$section['extensionId'] = $extender['extensionId'];

				$this->addSettingSection( $section );
			}
		}
	}

	/**
	 * Registers desired extension settings
	 * @param  array $extension
	 */
	private function registerSetting( $extension ) {

		register_setting(
			'dslc_custom_options_' . $extension['extensionId'],
			'dslc_custom_options_' . $extension['extensionId']
		);
	}

	/**
	 * Adds one submenu page
	 * @param array $extension
	 */
	private function addSubmenuPage( $extension ) {

		add_submenu_page(
			'dslc_plugin_options',
			__( $extension['title'], 'live-composer-page-builder' ),
			__( $extension['title'], 'live-composer-page-builder' ),
			'manage_options',
			'dslc_options_' . $extension['extensionId'],
			function() use ( $extension ) {	$this->renderOptionsPage( $extension );	}
		);
	}

	/**
	 * Render options page
	 * @param  array $extension
	 */
	private function renderOptionsPage( $extension ) {

		/// Include template
		include DS_LIVE_COMPOSER_ABS . '/includes/plugin-options-framework/options-extension-template.php';
	}

	/**
	 * Process one custom section
	 * @param array $section
	 */
	private function addSettingSection( $section ) {

		add_settings_section(
			'dslc_' . $section['extensionId'] . '_' . $section['id'], /// id
			$section['title'], /// title
			'dslc_plugin_options_display_options', /// callback
			'dslc_options_' . $section['extensionId'] /// where to show
		);

		if( ! is_array( $section['options'] ) ) continue;

		foreach ( $section['options'] as $option ) {

			$option['section'] = 'dslc_' . $section['extensionId'] . "_" . $section['id'];
			$option['extensionId'] = $section['extensionId'];

			$this->addOptionField( $option );
		}
	}

	/**
	 * Adds one option field into system
	 * @param array $field
	 */
	private function addOptionField( $option ) {

		$option['name'] = 'dslc_custom_options_' . $option['extensionId'] . '[' . $option['id'] . ']';
		$option_ID = $option['id'];

		$value = '';
		$options = get_option( 'dslc_custom_options_' . $option['extensionId'] );

		if ( isset( $options[$option['id']] ) ) {

			$value = $options[$option['id']];
		}

		$option['value'] = $value;

		add_settings_field(

			$option['id'], // id
			$option['label'], //title
			'dslc_option_display_funcitons_router', //callback
			'dslc_options_' . $option['extensionId'], //page
			$option['section'], //section
			$option //args
		);
	}

}

// Create class object
$DSLC_Options_Extender = new DSLC_Options_Extender;