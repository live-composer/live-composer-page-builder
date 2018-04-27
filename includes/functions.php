<?php
/**
 *	All the core functions
 *
 * @package LiveComposer
 *
 * Table of Contents
 *
 * - dslc_load_translation ( Load the text domain )
 * - dslc_register_modules ( Register default module and calls action used to register custom modules )
 * - dslc_register_module ( Register a module )
 * - dslc_unregister_module ( Unregister a module )
 * - dslc_module_settings ( Get settings of a specific module )
 * - dslc_get_new_module_id ( Get new unique ID )
 * - dslc_register_template ( Register a template )
 * - dslc_unregister_template ( Unregister a template )
 * - dslc_body_class ( Add custom classes to the body tag )
 * - dslc_set_defaults ( Replaces the default option values )
 * - dslc_is_module_active ( Check if a specific module is active - can be disabled in LC settings )
 * - dslc_save_preset ( Save a preset )
 * - dslc_is_editor_active ( Check if the editor is currently active )
 * - dslc_get_code ( Gets LC code of a specific post/page )
 * - dslc_get_templates ( Returns an array of active templates )
 * - dslc_set_default_templates ( Set default templates )
 * - dslc_set_user_templates ( Set user templates )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Load text domain
 *
 * @since 1.0.3
 */
function dslc_load_translation() {

	load_plugin_textdomain( 'live-composer-page-builder', false, DS_LIVE_COMPOSER_DIR_NAME . '/lang/' );

} add_action( 'plugins_loaded', 'dslc_load_translation' );

/**
 * Registers default and custom modules
 *
 * @since 1.0
 */
function dslc_register_modules() {

	// Register default modules.
	dslc_register_module( 'DSLC_Html' );
	dslc_register_module( 'DSLC_Shortcode' );
	dslc_register_module( 'DSLC_Text_Simple' );
	dslc_register_module( 'DSLC_Image' );
	dslc_register_module( 'DSLC_Button' );
	dslc_register_module( 'DSLC_Icon' );
	dslc_register_module( 'DSLC_Info_Box' );
	dslc_register_module( 'DSLC_Social' );
	dslc_register_module( 'DSLC_Separator' );
	dslc_register_module( 'DSLC_Tabs' );
	dslc_register_module( 'DSLC_Accordion' );
	dslc_register_module( 'DSLC_Progress_Bars' );
	dslc_register_module( 'DSLC_Notification' );

	dslc_register_module( 'DSLC_Blog' );
	dslc_register_module( 'DSLC_Posts' );
	dslc_register_module( 'DSLC_Projects' );
	dslc_register_module( 'DSLC_WooCommerce_Products' );
	dslc_register_module( 'DSLC_Testimonials' );
	dslc_register_module( 'DSLC_Partners' );
	dslc_register_module( 'DSLC_Galleries' );
	dslc_register_module( 'DSLC_Downloads' );
	dslc_register_module( 'DSLC_Staff' );

	dslc_register_module( 'DSLC_Widgets' );
	dslc_register_module( 'DSLC_Navigation' );
	dslc_register_module( 'DSLC_Logo' );

	if ( class_exists( 'RevSliderBase' ) ) {
		dslc_register_module( 'DSLC_Sliders' );
	}

	dslc_register_module( 'DSLC_TP_Thumbnail' );
	dslc_register_module( 'DSLC_TP_Title' );
	dslc_register_module( 'DSLC_TP_Content' );
	dslc_register_module( 'DSLC_TP_Excerpt' );
	dslc_register_module( 'DSLC_TP_Meta' );
	dslc_register_module( 'DSLC_TP_Downloads_Button' );
	dslc_register_module( 'DSLC_TP_Gallery_Slider' );
	dslc_register_module( 'DSLC_TP_Project_Slider' );
	dslc_register_module( 'DSLC_TP_Comments' );
	dslc_register_module( 'DSLC_TP_Comments_Form' );
	dslc_register_module( 'DSLC_TP_Staff_Social' );

	// Hook to register custom modules.
	do_action( 'dslc_hook_register_modules' );
	do_action( 'dslc_hook_unregister_modules' );

	// Array that holds all active modules.
	global $dslc_var_modules;

	// Developers can filter list of available modules.
	$dslc_var_modules = apply_filters( 'dslc_filter_modules', $dslc_var_modules );

} add_action( 'init', 'dslc_register_modules', 1  );


/**
 * Remove non-active modules form the list of all modules.
 *
 * @param  array $dslc_var_modules Original list of active modules.
 * @return array                   Modified list of active modules.
 * @since 1.1.3
 */
function dslc_filter_disabled_modules( $dslc_var_modules ) {

	foreach ( $dslc_var_modules as $key => $dslc_module ) {

		// The ID of the module.
		$module_id = $dslc_module['id'];

		// Check if active?
		if ( ! dslc_is_module_active( $module_id ) ) {
			unset( $dslc_var_modules[ $key ] );
		}
	}

	return $dslc_var_modules;

} add_filter( 'dslc_filter_modules', 'dslc_filter_disabled_modules', 10 );


/**
 * Register module
 *
 * @since 1.0
 */
function dslc_register_module( $module_id ) {

	// Array that holds all active modules.
	global $dslc_var_modules;

	// Instanciate the module class.
	$module_instance = new $module_id();

	// Icon.
	if ( ! isset( $module_instance->module_icon ) ) {
		$module_instance->module_icon = '';
	}

	// Category/Origin.
	if ( ! isset( $module_instance->module_category ) ) {
		$module_instance->module_category = 'other';
	}

	// If the array ID not taken?
	if ( ! isset( $dslc_var_modules[ $module_id ] ) ) {

		// Append new module to the global array.
		$dslc_var_modules[ $module_id ] = array(
			'id' => $module_id,
			'title' => $module_instance->module_title,
			'icon' => $module_instance->module_icon,
			'origin' => $module_instance->module_category,
		);

		if ( isset( $module_instance->exclude_from_main_listing ) ) {
			$dslc_var_modules[ $module_id ]['exclude'] = $module_instance->exclude_from_main_listing;
		}
	}
}

/**
 * Unregister module
 *
 * @since 1.0
 */
function dslc_unregister_module( $module_id ) {

	// Array that holds all active modules.
	global $dslc_var_modules;

	// Remove module from array.
	unset( $dslc_var_modules[ $module_id ] );

}

/**
 * Module Settings
 *
 * Generates settings based on default values and user values
 *
 * @since 1.0
 */
function dslc_module_settings( $options, $module_id ) {

	// Array to hold the settings.
	$settings = array();

	/**
	 * If it's all new module then just fill it's settings with default values.
	 * Else go through each option and fill it with custom values sent.
	 * 🔖 RAW CODE CLEANUP
	 */
	if ( isset( $_POST['dslc_new_module'] ) ) {

		// Go through all options and fill array with default/standard values.
		foreach ( $options as $option ) {
			if ( isset( $option['std'] ) ) {
				$settings[ $option['id'] ] = $option['std'];
			}
		}
	} else {

		// Go through all options and fill array with custom values, otherwise leave empty.
		foreach ( $options as $option ) {
			if ( isset( $_POST[ $option['id'] ] ) && '' !== $_POST[ $option['id'] ] ) {
				$settings[ $option['id'] ] = $_POST[ $option['id'] ];
			} else {
				$settings[ $option['id'] ] = '';
			}
		}
	}

	return $settings;
}

/**
 * Returns an unique module ID
 *
 * @since 1.0
 */
function dslc_get_new_module_id() {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		// Generates unique id like 'kojb85j8oc'.
		return substr( str_shuffle( MD5( microtime() ) ), 0, 11 );
	}
}

/**
 * Hooks to register/unregister templates
 *
 * @since 1.0
 */
function dslc_register_templates() {

	do_action( 'dslc_hook_register_templates' );
	do_action( 'dslc_hook_unregister_templates' );

} add_action( 'init', 'dslc_register_templates', 1 );

/**
 * Register a template
 *
 * @since 1.0
 */
function dslc_register_template( $template ) {

	// Global variable that holds templates information.
	global $dslc_var_templates;

	// If an array supplied proceed?
	if ( is_array( $template ) ) {

		// If the array ID not taken?
		if ( ! isset( $dslc_var_templates[ $template['id'] ] ) ) {

			// Add the template to the templates array.
			$dslc_var_templates[ $template['id'] ] = $template;

		}
	}
}

/**
 * Unregister a template
 *
 * @since 1.0
 */
function dslc_unregister_template( $template_id ) {

	// Global variable that holds templates information.
	global $dslc_var_templates;

	// If the template exists?
	if ( isset( $dslc_var_templates[ $template_id ] ) ) {

		// Remove the template from the templates array.
		unset( $dslc_var_templates[ $template_id ] );
	}
}

/**
 * Add custom classes to the body tag
 *
 * @since 1.0
 */
function dslc_body_class( $classes ) {

	global $dslc_post_types;

	$proceed = false;
	$has_lc_content = false;
	$has_lc_header_footer = false;

	if ( is_archive() && ! is_author() && ! is_search() ) {
		$template_id = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );
		if ( $template_id ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_author() ) {
		$template_id = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		if ( $template_id ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_search() ) {
		$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
		if ( $template_id ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_singular() ) {
		$proceed = true;
	}

	if ( false === $proceed ) {
		return $classes;
	}

	// If page in LC mode, force the class?
	if ( isset( $_GET['dslc'] ) ) {
		$has_lc_content = true;
	}

	// Still nothing, let's check if there's real LC content on the page.
	if ( ! $has_lc_content ) {

		// Get the dslc_code custom field.
		$dslc_code = get_post_meta( get_the_ID(), 'dslc_code', true );

		// If there is LC content, allow the class?
		if ( $dslc_code ) {
			$has_lc_content = true;
		}
	}

	// Still nothing, let's check if it's a post and has an LC template.
	if ( ! $has_lc_content && is_singular( $dslc_post_types ) ) {

		// Get the ID of the template.
		$template_id = dslc_st_get_template_id( get_the_ID() );

		// If template exists, allow the class.
		if ( $template_id ) {
			$has_lc_content = true;
		}
	}

	// Let's check if it has LC powered header/footer.
	$header_footer = dslc_hf_get_ID( get_the_ID() );
	if ( $header_footer['header'] || $header_footer['footer'] ) {
		$has_lc_header_footer = true;
	}

	// If has LC content append class.
	if ( $has_lc_content || $has_lc_header_footer ) {
		$classes[] = 'dslc-page';
	}

	if ( $has_lc_content ) {
		$classes[] = 'dslc-page-has-content';
	}

	if ( $has_lc_header_footer ) {
		$classes[] = 'dslc-page-has-hf';
	}

	global $dslc_active;

	if ( $dslc_active && dslc_current_user_can( 'save' ) ) {
		$classes[] = 'dslca-enabled';
		$classes[] = 'dslca-drag-not-in-progress';
	}

	// If responsive disabled append class.
	if ( defined( 'DS_LIVE_COMPOSER_RESPONSIVE' ) && ! DS_LIVE_COMPOSER_RESPONSIVE ) {
		$classes[] = 'dslc-res-disabled';
	}

	// Return the modified array.
	return $classes;

} add_filter( 'body_class', 'dslc_body_class' );

/**
 * Replaces the default option values
 *
 * @since 1.0
 */
function dslc_set_defaults( $new_defaults, $options ) {

	// If no new defaults, pass it back and stop.
	if ( ! $new_defaults ) {
		return $options;
	}

	// Generate an array of options IDs to alter.
	$def_ids = array();
	foreach ( $new_defaults as $key => $val ) {
		$def_ids[] = $key;
	}

	// Go through all the options.
	foreach ( $options as $opt_key => $option ) {

		if ( in_array( $option['id'], $def_ids ) ) {
			$options[ $opt_key ]['std'] = $new_defaults[ $option['id'] ];
		}
	}

	// Pass back the options array.
	return $options;

}

/**
 * Check if module is active
 */
function dslc_is_module_active( $module_id, $check_registered = false ) {

	global $dslc_var_modules;

	if ( 'disabled' === dslc_get_option( $module_id, 'dslc_plugin_options_features' ) ) {
		return false;
	} elseif ( true === $check_registered && ! isset( $dslc_var_modules[ $module_id ] ) ) {
		return false;
	} else {
		return true;
	}

}

/**
 * Check if editor is currently active
 *
 * @since 1.0
 */
function dslc_is_editor_active( $capability = 'save' ) {

	// Check for saving capability.
	if ( 'save' === $capability ) {
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY_SAVE;
		// Check for access capability ( can use editor but can't publish changes ).
	} elseif ( 'access' === $capability ) {
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY;
	}

	// Check if editor is activated and current user can use the editor.
	if ( DS_LIVE_COMPOSER_ACTIVE && current_user_can( $capability_check ) ) {
		return true;
	} else {
		return false;
	}
}

/**
 * Check the current user permissions
 *
 * @param  string $capability Keyword for the capability to check against ('save' or 'access').
 * @return boolean            Allowed or not.
 */
function dslc_current_user_can( $capability = 'save' ) {

	// Check for access capability ( can use editor but can't publish changes ).
	if ( 'access' === $capability ) {
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY;
	} else { // Check for saving capability (capability = save).
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY_SAVE;
	}

	// Check if editor is activated and current user can use the editor.
	if ( is_user_logged_in() && current_user_can( $capability_check ) ) {
		return true;
	} else {
		return false;
	}
}


/**
 * Gets LC code of a specific post/page
 *
 * @since 1.0.2
 *
 * @param int  $postID 	ID of the post/page. Default false.
 * @param bool $draft 	If true will check for draft first. Default true.
 * @return string 		The LC code for the post/page. Empty string if no LC code.
 */
function dslc_get_code( $postID = false, $draft = true ) {

	// This will be returned at the end.
	$code = '';

	// If post ID not supplied ask WordPress.
	if ( ! $postID ) {
		$postID = get_the_ID();
	}

	// If still no ID return false.
	if ( ! $postID ) {
		return false;
	}

	// If draft allowed ( func parameter ) and editor currently active and there is a draft version
	if ( $draft && dslc_is_editor_active() && get_post_meta( $postID, 'dslc_code_draft', true ) ) {

		// Load draft LC code.
		$code = get_post_meta( $postID, 'dslc_code_draft', true );

	} else {

		// Load regular ( current ) LC code.
		$code = get_post_meta( $postID, 'dslc_code', true );

	}

	// Pass it back.
	return $code;

}

/**
 * Returns array of active templates
 *
 * @since 1.0
 *
 * @return array Multidimensional array of LC templates. Bool false if none
 *               One array per each template. Key of array is template ID
 *               Each template has array parameters title|id|code|section
 */
function dslc_get_templates() {

	// Global var holding templates information.
	global $dslc_var_templates;

	// Filter to hook into.
	$dslc_var_templates = apply_filters( 'dslc_get_templates', $dslc_var_templates );

	// Return templates ( false if none ).
	if ( empty( $dslc_var_templates ) ) {
		return false;
	} else {
		return $dslc_var_templates;
	}

}

/**
 * Set default templates
 *
 * @since 1.0.3
 */
function dslc_set_default_templates( $templates ) {

	$templates['dslc-blog-ex-1'] = array(
		'title' => __( 'Blog Variation 1', 'live-composer-page-builder' ),
		'id' => 'dslc-blog-ex-1',
		'code' => '[dslc_modules_section type="wrapped" columns_spacing="spacing" border_color="" border_width="0" border_style="" border="" bg_color="" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="" bg_video_overlay_opacity="" bg_image_repeat="repeat" bg_image_attachment="scroll" bg_image_position="left top" bg_image_size="auto" padding="61" padding_h="0" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module]YToxODp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjY6ImFtb3VudCI7czoxOiI2IjtzOjE1OiJwYWdpbmF0aW9uX3R5cGUiO3M6ODoibnVtYmVyZWQiO3M6NzoiY29sdW1ucyI7czoxOiI2IjtzOjI1OiJjc3NfbWFpbl9wYWRkaW5nX3ZlcnRpY2FsIjtzOjI6IjMwIjtzOjI3OiJjc3NfbWFpbl9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiNTAiO3M6MTU6InRpdGxlX2ZvbnRfc2l6ZSI7czoyOiIyNSI7czoyMToiY3NzX3RpdGxlX2ZvbnRfd2VpZ2h0IjtzOjM6IjMwMCI7czoyMToiY3NzX3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjc6IlJhbGV3YXkiO3M6MTc6InRpdGxlX2xpbmVfaGVpZ2h0IjtzOjI6IjM4IjtzOjE3OiJjc3NfZXhjZXJwdF9jb2xvciI7czo3OiIjOTk5OTk5IjtzOjIxOiJjc3NfZXhjZXJwdF9mb250X3NpemUiO3M6MjoiMTYiO3M6MjM6ImNzc19leGNlcnB0X2ZvbnRfd2VpZ2h0IjtzOjM6IjQwMCI7czoyMzoiY3NzX2V4Y2VycHRfZm9udF9mYW1pbHkiO3M6NDoiTXVsaSI7czoyMzoiY3NzX2V4Y2VycHRfbGluZV9oZWlnaHQiO3M6MjoiMzAiO3M6MTQ6ImV4Y2VycHRfbGVuZ3RoIjtzOjI6IjQwIjtzOjE4OiJtb2R1bGVfaW5zdGFuY2VfaWQiO2k6MzM7czo5OiJtb2R1bGVfaWQiO3M6OToiRFNMQ19CbG9nIjt9[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Blog Section',
	);

	$templates['dslc-blog-ex-2'] = array(
		'title' => __( 'Blog Variation 2', 'live-composer-page-builder' ),
		'id' => 'dslc-blog-ex-2',
		'code' => '[dslc_modules_section type="wrapped" columns_spacing="spacing" border_color="" border_width="0" border_style="" border="" bg_color="#f7f7f7" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="" bg_video_overlay_opacity="" bg_image_repeat="no-repeat" bg_image_attachment="parallax" bg_image_position="center bottom" bg_image_size="auto" padding="49" padding_h="0" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module]YTo1NDp7czo2OiJhbW91bnQiO3M6MToiNiI7czoxNToicGFnaW5hdGlvbl90eXBlIjtzOjg6Im51bWJlcmVkIjtzOjc6ImNvbHVtbnMiO3M6MToiNCI7czo4OiJlbGVtZW50cyI7czoyMToibWFpbl9oZWFkaW5nIGZpbHRlcnMgIjtzOjEzOiJwb3N0X2VsZW1lbnRzIjtzOjMxOiJ0aHVtYm5haWwgdGl0bGUgZXhjZXJwdCBidXR0b24gIjtzOjE0OiJjc3Nfc2VwX2hlaWdodCI7czoyOiIzMCI7czoxMzoiY3NzX3NlcF9zdHlsZSI7czo1OiJzb2xpZCI7czoyNzoiY3NzX3RodW1iX2JvcmRlcl9yYWRpdXNfdG9wIjtzOjE6IjAiO3M6MTc6ImNzc19tYWluX2JnX2NvbG9yIjtzOjc6IiNlMzYzNGQiO3M6MjE6ImNzc19tYWluX2JvcmRlcl9jb2xvciI7czowOiIiO3M6MjE6ImNzc19tYWluX2JvcmRlcl93aWR0aCI7czoxOiIwIjtzOjIwOiJjc3NfbWFpbl9ib3JkZXJfdHJibCI7czoyMjoidG9wIHJpZ2h0IGJvdHRvbSBsZWZ0ICI7czoyOToiY3NzX21haW5fYm9yZGVyX3JhZGl1c19ib3R0b20iO3M6MToiMCI7czoyNToiY3NzX21haW5fcGFkZGluZ192ZXJ0aWNhbCI7czoyOiIzNCI7czoyNzoiY3NzX21haW5fcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjM3IjtzOjE5OiJjc3NfbWFpbl90ZXh0X2FsaWduIjtzOjQ6ImxlZnQiO3M6MTE6InRpdGxlX2NvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MTU6InRpdGxlX2ZvbnRfc2l6ZSI7czoyOiIyNSI7czoyMToiY3NzX3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjc6IlJhbGV3YXkiO3M6MTc6InRpdGxlX2xpbmVfaGVpZ2h0IjtzOjI6IjM1IjtzOjEyOiJ0aXRsZV9tYXJnaW4iO3M6MjoiMTciO3M6MTc6ImNzc19leGNlcnB0X2NvbG9yIjtzOjc6IiNmMGQ2ZDYiO3M6MjE6ImNzc19leGNlcnB0X2ZvbnRfc2l6ZSI7czoyOiIxNSI7czoyMzoiY3NzX2V4Y2VycHRfZm9udF9mYW1pbHkiO3M6NDoiTGF0byI7czoyMzoiY3NzX2V4Y2VycHRfbGluZV9oZWlnaHQiO3M6MjoiMjciO3M6MTQ6ImV4Y2VycHRfbWFyZ2luIjtzOjI6IjI4IjtzOjE0OiJleGNlcnB0X2xlbmd0aCI7czoyOiI0MCI7czoxOToiY3NzX2J1dHRvbl9iZ19jb2xvciI7czo3OiIjYzI0ODM4IjtzOjI1OiJjc3NfYnV0dG9uX2JnX2NvbG9yX2hvdmVyIjtzOjc6IiNmZmZmZmYiO3M6MjM6ImNzc19idXR0b25fYm9yZGVyX2NvbG9yIjtzOjc6IiMxNDBmMGYiO3M6Mjk6ImNzc19idXR0b25fYm9yZGVyX2NvbG9yX2hvdmVyIjtzOjc6IiM5ZTZkNmQiO3M6MjQ6ImNzc19idXR0b25fYm9yZGVyX3JhZGl1cyI7czoxOiIwIjtzOjIyOiJjc3NfYnV0dG9uX2NvbG9yX2hvdmVyIjtzOjc6IiM4ZjhmOGYiO3M6MjA6ImNzc19idXR0b25fZm9udF9zaXplIjtzOjI6IjEyIjtzOjI3OiJjc3NfYnV0dG9uX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMTciO3M6Mjk6ImNzc19idXR0b25fcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjE5IjtzOjE0OiJidXR0b25faWNvbl9pZCI7czo5OiJzaGFyZS1hbHQiO3M6MjE6ImNzc19idXR0b25faWNvbl9jb2xvciI7czo3OiIjZjA3YTY4IjtzOjI3OiJjc3NfYnV0dG9uX2ljb25fY29sb3JfaG92ZXIiO3M6NzoiI2QxZDFkMSI7czoxODoibWFpbl9oZWFkaW5nX3RpdGxlIjtzOjE3OiJMQVRFU1QgQkxPRyBQT1NUUyI7czoyODoiY3NzX21haW5faGVhZGluZ19saW5lX2hlaWdodCI7czoyOiIzNSI7czoyNzoiY3NzX21haW5faGVhZGluZ19saW5rX2NvbG9yIjtzOjc6IiNlMzYzNGQiO3M6MzM6ImNzc19tYWluX2hlYWRpbmdfbGlua19jb2xvcl9ob3ZlciI7czo3OiIjYzc1MDNlIjtzOjMzOiJjc3NfbWFpbl9oZWFkaW5nX2xpbmtfcGFkZGluZ192ZXIiO3M6MToiOSI7czoyNToiY3NzX2hlYWRpbmdfbWFyZ2luX2JvdHRvbSI7czoyOiIyNSI7czoyNjoiY3NzX2ZpbHRlcl9iZ19jb2xvcl9hY3RpdmUiO3M6NzoiI2UzNjM0ZCI7czozMDoiY3NzX2ZpbHRlcl9ib3JkZXJfY29sb3JfYWN0aXZlIjtzOjc6IiNlMzYzNGQiO3M6MTk6ImNzc19maWx0ZXJfcG9zaXRpb24iO3M6NToicmlnaHQiO3M6MTg6ImNzc19maWx0ZXJfc3BhY2luZyI7czoxOiI5IjtzOjI4OiJjc3NfcGFnX2l0ZW1fYmdfY29sb3JfYWN0aXZlIjtzOjc6IiNlMzYzNGQiO3M6MzI6ImNzc19wYWdfaXRlbV9ib3JkZXJfY29sb3JfYWN0aXZlIjtzOjc6IiNlMzYzNGQiO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aTo0MTtzOjc6InBvc3RfaWQiO3M6MzoiMzM2IjtzOjk6Im1vZHVsZV9pZCI7czo5OiJEU0xDX0Jsb2ciO30=[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Blog Section',
	);

	$templates['dslc-blog-ex-3'] = array(
		'title' => __( 'Blog Variation 3', 'live-composer-page-builder' ),
		'id' => 'dslc-blog-ex-3',
		'code' => '[dslc_modules_section type="wrapped" columns_spacing="spacing" border_color="" border_width="0" border_style="solid" border="bottom " bg_color="#f7f9fa" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" bg_image_repeat="repeat" bg_image_attachment="scroll" bg_image_position="left top" bg_image_size="auto" padding="63" padding_h="0" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="no" first="yes" size="8"] [dslc_module]YTo1Mjp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjExOiJvcmllbnRhdGlvbiI7czoxMDoiaG9yaXpvbnRhbCI7czo2OiJhbW91bnQiO3M6MToiMyI7czoxNToicGFnaW5hdGlvbl90eXBlIjtzOjg6Im51bWJlcmVkIjtzOjc6ImNvbHVtbnMiO3M6MjoiMTIiO3M6NToib3JkZXIiO3M6MzoiQVNDIjtzOjI5OiJjc3Nfd3JhcHBlcl9ib3JkZXJfcmFkaXVzX3RvcCI7czoxOiIzIjtzOjMyOiJjc3Nfd3JhcHBlcl9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiIzIjtzOjIwOiJjc3Nfc2VwX2JvcmRlcl9jb2xvciI7czo3OiIjZTZlNmU2IjtzOjE0OiJjc3Nfc2VwX2hlaWdodCI7czoyOiI0NCI7czoxMzoiY3NzX3NlcF9zdHlsZSI7czo1OiJzb2xpZCI7czoxODoiY3NzX3RodW1iX2JnX2NvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MzA6ImNzc190aHVtYl9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiI0IjtzOjE4OiJ0aHVtYl9tYXJnaW5fcmlnaHQiO3M6MToiMCI7czoxMToidGh1bWJfd2lkdGgiO3M6MjoiMjkiO3M6MTc6ImNzc19tYWluX2JnX2NvbG9yIjtzOjA6IiI7czoyMToiY3NzX21haW5fYm9yZGVyX3dpZHRoIjtzOjE6IjAiO3M6MjA6ImNzc19tYWluX2JvcmRlcl90cmJsIjtzOjIyOiJ0b3AgcmlnaHQgYm90dG9tIGxlZnQgIjtzOjI1OiJjc3NfbWFpbl9wYWRkaW5nX3ZlcnRpY2FsIjtzOjE6IjAiO3M6Mjc6ImNzc19tYWluX3BhZGRpbmdfaG9yaXpvbnRhbCI7czoyOiI1MyI7czoxOToiY3NzX21haW5fdGV4dF9hbGlnbiI7czo0OiJsZWZ0IjtzOjExOiJ0aXRsZV9jb2xvciI7czo3OiIjNjE2MTYxIjtzOjE1OiJ0aXRsZV9mb250X3NpemUiO3M6MjoiMjgiO3M6MjE6ImNzc190aXRsZV9mb250X2ZhbWlseSI7czo3OiJSYWxld2F5IjtzOjE3OiJ0aXRsZV9saW5lX2hlaWdodCI7czoyOiI0MCI7czoxODoiY3NzX21ldGFfZm9udF9zaXplIjtzOjI6IjEzIjtzOjIwOiJjc3NfbWV0YV9mb250X2ZhbWlseSI7czo3OiJCcmF3bGVyIjtzOjIwOiJjc3NfbWV0YV9mb250X3dlaWdodCI7czozOiI1MDAiO3M6MjU6ImNzc19tZXRhX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMTciO3M6MTk6ImNzc19tZXRhX2xpbmtfY29sb3IiO3M6NzoiI2U2NmU2NSI7czoyNToiY3NzX21ldGFfbGlua19jb2xvcl9ob3ZlciI7czo3OiIjYzc1YjU0IjtzOjE3OiJjc3NfZXhjZXJwdF9jb2xvciI7czo3OiIjODc4Nzg3IjtzOjIxOiJjc3NfZXhjZXJwdF9mb250X3NpemUiO3M6MjoiMTYiO3M6MjM6ImNzc19leGNlcnB0X2ZvbnRfZmFtaWx5IjtzOjc6IkJyYXdsZXIiO3M6MjM6ImNzc19leGNlcnB0X2xpbmVfaGVpZ2h0IjtzOjI6IjI5IjtzOjE0OiJleGNlcnB0X21hcmdpbiI7czoyOiIyOSI7czoxNDoiZXhjZXJwdF9sZW5ndGgiO3M6MjoiNDAiO3M6MTE6ImJ1dHRvbl90ZXh0IjtzOjE2OiJDb250aW51ZSBSZWFkaW5nIjtzOjE5OiJjc3NfYnV0dG9uX2JnX2NvbG9yIjtzOjc6IiNlNjZlNjUiO3M6MjU6ImNzc19idXR0b25fYmdfY29sb3JfaG92ZXIiO3M6NzoiI2MyNTA0OCI7czoyMDoiY3NzX2J1dHRvbl9mb250X3NpemUiO3M6MjoiMTIiO3M6MjI6ImNzc19idXR0b25fZm9udF93ZWlnaHQiO3M6MzoiNzAwIjtzOjIyOiJjc3NfYnV0dG9uX2ZvbnRfZmFtaWx5IjtzOjEyOiJNZXJyaXdlYXRoZXIiO3M6Mjc6ImNzc19idXR0b25fcGFkZGluZ192ZXJ0aWNhbCI7czoyOiIxMyI7czoyOToiY3NzX2J1dHRvbl9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiMTQiO3M6MTQ6ImJ1dHRvbl9pY29uX2lkIjtzOjExOiJhcnJvdy1yaWdodCI7czoyMToiY3NzX2J1dHRvbl9pY29uX2NvbG9yIjtzOjc6IiNmN2FiYTYiO3M6Mjg6ImNzc19wYWdfaXRlbV9iZ19jb2xvcl9hY3RpdmUiO3M6NzoiI2U2NmU2NSI7czoyNToiY3NzX3BhZ19pdGVtX2JvcmRlcl9jb2xvciI7czo3OiIjZDlkOWQ5IjtzOjMyOiJjc3NfcGFnX2l0ZW1fYm9yZGVyX2NvbG9yX2FjdGl2ZSI7czo3OiIjZTY2ZTY1IjtzOjE4OiJtb2R1bGVfaW5zdGFuY2VfaWQiO2k6NDI7czo5OiJtb2R1bGVfaWQiO3M6OToiRFNMQ19CbG9nIjt9[/dslc_module] [/dslc_modules_area] [dslc_modules_area last="yes" first="no" size="4"] [dslc_module]YToyMDp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjc6InNpZGViYXIiO3M6MTY6ImRzbGNfc2lkZWJhcl9vbmUiO3M6NzoiY29sdW1ucyI7czoyOiIxMiI7czozMDoiY3NzX3dpZGdldHNfcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjIyIjtzOjE5OiJjc3Nfd2lkZ2V0X2JnX2NvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MjM6ImNzc193aWRnZXRfYm9yZGVyX2NvbG9yIjtzOjc6IiNkZWRlZGUiO3M6MjM6ImNzc193aWRnZXRfYm9yZGVyX3dpZHRoIjtzOjE6IjEiO3M6Mjg6ImNzc193aWRnZXRfYm9yZGVyX3JhZGl1c190b3AiO3M6MToiNCI7czozMToiY3NzX3dpZGdldF9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiI0IjtzOjI3OiJjc3Nfd2lkZ2V0X3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMzAiO3M6Mjk6ImNzc193aWRnZXRfcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjI3IjtzOjE1OiJ0aXRsZV9mb250X3NpemUiO3M6MjoiMTQiO3M6MjE6ImNzc190aXRsZV9mb250X2ZhbWlseSI7czowOiIiO3M6MTY6ImNzc190aXRsZV9tYXJnaW4iO3M6MjoiMTMiO3M6MTc6ImNzc190aXRsZV9wYWRkaW5nIjtzOjI6IjIwIjtzOjIwOiJjc3NfbWFpbl9saW5lX2hlaWdodCI7czoyOiIyNCI7czoxNDoiY3NzX2xpbmtfY29sb3IiO3M6NzoiI2U2NmU2NSI7czoyMDoiY3NzX2xpbmtfY29sb3JfaG92ZXIiO3M6NzoiI2M3NTg1MCI7czoxODoibW9kdWxlX2luc3RhbmNlX2lkIjtpOjQzO3M6OToibW9kdWxlX2lkIjtzOjEyOiJEU0xDX1dpZGdldHMiO30=[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Blog Section',
	);

	$templates['dslc-projects-ex-1'] = array(
		'title' => __( 'Projects Variation 1', 'live-composer-page-builder' ),
		'id' => 'dslc-projects-ex-1',
		'code' => '[dslc_modules_section type="full" columns_spacing="spacing" border_color="" border_width="0" border_style="" border="" bg_color="#f7f6f4" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="" bg_video_overlay_opacity="" bg_image_repeat="no-repeat" bg_image_attachment="parallax" bg_image_position="center bottom" bg_image_size="auto" padding="58" padding_h="5" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module]YTo1MDp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjY6ImFtb3VudCI7czoxOiI2IjtzOjc6ImNvbHVtbnMiO3M6MToiMiI7czo4OiJlbGVtZW50cyI7czo4OiJmaWx0ZXJzICI7czoxMzoicG9zdF9lbGVtZW50cyI7czo0MjoidGh1bWJuYWlsIHRpdGxlIGNhdGVnb3JpZXMgZXhjZXJwdCBidXR0b24gIjtzOjMxOiJjc3NfdGh1bWJuYWlsX2JvcmRlcl9yYWRpdXNfdG9wIjtzOjE6IjAiO3M6MTg6InRodW1iX3Jlc2l6ZV93aWR0aCI7czozOiIyNjEiO3M6MjE6ImNzc19tYWluX2JvcmRlcl9jb2xvciI7czo3OiIjZjBlZWViIjtzOjIwOiJjc3NfbWFpbl9ib3JkZXJfdHJibCI7czo3OiJib3R0b20gIjtzOjI5OiJjc3NfbWFpbl9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiIwIjtzOjI1OiJjc3NfbWFpbl9wYWRkaW5nX3ZlcnRpY2FsIjtzOjI6IjM2IjtzOjI3OiJjc3NfbWFpbl9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiMjkiO3M6MTU6ImNzc190aXRsZV9jb2xvciI7czo3OiIjNGY0ZjRmIjtzOjE5OiJjc3NfdGl0bGVfZm9udF9zaXplIjtzOjI6IjE3IjtzOjIxOiJjc3NfdGl0bGVfZm9udF93ZWlnaHQiO3M6MzoiNTAwIjtzOjIxOiJjc3NfdGl0bGVfZm9udF9mYW1pbHkiO3M6MTY6IlBvcnQgTGxpZ2F0IFNsYWIiO3M6MjM6ImNzc190aXRsZV9tYXJnaW5fYm90dG9tIjtzOjI6IjE1IjtzOjE4OiJjc3NfY2F0c19mb250X3NpemUiO3M6MjoiMTIiO3M6MjA6ImNzc19jYXRzX2ZvbnRfZmFtaWx5IjtzOjEyOiJQb250YW5vIFNhbnMiO3M6MjI6ImNzc19jYXRzX21hcmdpbi1ib3R0b20iO3M6MjoiMTgiO3M6MjQ6ImNzc19leGNlcnB0X2JvcmRlcl9jb2xvciI7czo3OiIjZTBlMGUwIjtzOjI0OiJjc3NfZXhjZXJwdF9ib3JkZXJfc3R5bGUiO3M6NjoiZG90dGVkIjtzOjE3OiJjc3NfZXhjZXJwdF9jb2xvciI7czo3OiIjYThhOGE4IjtzOjIxOiJjc3NfZXhjZXJwdF9mb250X3NpemUiO3M6MjoiMTUiO3M6MjM6ImNzc19leGNlcnB0X2ZvbnRfZmFtaWx5IjtzOjU6IkRvc2lzIjtzOjIzOiJjc3NfZXhjZXJwdF9saW5lX2hlaWdodCI7czoyOiIyNCI7czoxOToiY3NzX2J1dHRvbl9iZ19jb2xvciI7czo3OiIjZTM1ZDU4IjtzOjI1OiJjc3NfYnV0dG9uX2JnX2NvbG9yX2hvdmVyIjtzOjc6IiNjOTRkNDkiO3M6MjQ6ImNzc19idXR0b25fYm9yZGVyX3JhZGl1cyI7czoxOiIyIjtzOjIwOiJjc3NfYnV0dG9uX2ZvbnRfc2l6ZSI7czoyOiIxMyI7czoyMjoiY3NzX2J1dHRvbl9mb250X3dlaWdodCI7czozOiI2MDAiO3M6MjI6ImNzc19idXR0b25fZm9udF9mYW1pbHkiO3M6NzoiUFQgU2FucyI7czoxNDoiYnV0dG9uX2ljb25faWQiO3M6MTg6ImFycm93LWNpcmNsZS1yaWdodCI7czoyMToiY3NzX2J1dHRvbl9pY29uX2NvbG9yIjtzOjc6IiNlYjk3OTQiO3M6MTg6Im1haW5faGVhZGluZ190aXRsZSI7czoxNToiTEFURVNUIFBST0pFQ1RTIjtzOjI3OiJjc3NfbWFpbl9oZWFkaW5nX2xpbmtfY29sb3IiO3M6NzoiI2UzNWQ1OCI7czozMzoiY3NzX21haW5faGVhZGluZ19saW5rX2NvbG9yX2hvdmVyIjtzOjc6IiNjNDRjNDgiO3M6MzM6ImNzc19tYWluX2hlYWRpbmdfbGlua19wYWRkaW5nX3ZlciI7czoxOiI5IjtzOjI1OiJjc3NfaGVhZGluZ19tYXJnaW5fYm90dG9tIjtzOjI6IjM5IjtzOjI2OiJjc3NfZmlsdGVyX2JnX2NvbG9yX2FjdGl2ZSI7czo3OiIjZTM1ZDU4IjtzOjIzOiJjc3NfZmlsdGVyX2JvcmRlcl9jb2xvciI7czo3OiIjZWJlOWUyIjtzOjMwOiJjc3NfZmlsdGVyX2JvcmRlcl9jb2xvcl9hY3RpdmUiO3M6NzoiI2UzNWQ1OCI7czoyMjoiY3NzX2ZpbHRlcl9ib3JkZXJfdHJibCI7czo3OiJib3R0b20gIjtzOjI0OiJjc3NfZmlsdGVyX2JvcmRlcl9yYWRpdXMiO3M6MToiMCI7czoxOToiY3NzX2Fycm93c19iZ19jb2xvciI7czo3OiIjZTM1ZDU4IjtzOjI1OiJjc3NfYXJyb3dzX2JnX2NvbG9yX2hvdmVyIjtzOjc6IiNjYzUyNGUiO3M6MjQ6ImNzc19jaXJjbGVzX2NvbG9yX2FjdGl2ZSI7czo3OiIjZTM1ZDU4IjtzOjIyOiJjc3NfY2lyY2xlc19tYXJnaW5fdG9wIjtzOjI6IjIzIjtzOjE4OiJtb2R1bGVfaW5zdGFuY2VfaWQiO2k6NDY7czo5OiJtb2R1bGVfaWQiO3M6MTM6IkRTTENfUHJvamVjdHMiO30=[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Project Listing',
	);

	$templates['dslc-projects-ex-2'] = array(
		'title' => __( 'Projects Variation 2', 'live-composer-page-builder' ),
		'id' => 'dslc-projects-ex-2',
		'code' => '[dslc_modules_section type="full" columns_spacing="spacing" border_color="" border_width="0" border_style="solid" border="top bottom" bg_color="#f4f9fc" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" bg_image_repeat="no-repeat" bg_image_attachment="scroll" bg_image_position="center center" bg_image_size="auto" padding="61" padding_h="3" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="no" first="yes" size="3"] [dslc_module]YToxOTp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjc6InNpZGViYXIiO3M6MTY6ImRzbGNfc2lkZWJhcl9vbmUiO3M6NzoiY29sdW1ucyI7czoyOiIxMiI7czozMDoiY3NzX3dpZGdldHNfcGFkZGluZ19ob3Jpem9udGFsIjtzOjE6IjMiO3M6MTk6ImNzc193aWRnZXRfYmdfY29sb3IiO3M6NzoiI2ZmZmZmZiI7czoyMzoiY3NzX3dpZGdldF9ib3JkZXJfY29sb3IiO3M6NzoiI2Q5ZDlkOSI7czoyMzoiY3NzX3dpZGdldF9ib3JkZXJfd2lkdGgiO3M6MToiMSI7czoyODoiY3NzX3dpZGdldF9ib3JkZXJfcmFkaXVzX3RvcCI7czoxOiIzIjtzOjMxOiJjc3Nfd2lkZ2V0X2JvcmRlcl9yYWRpdXNfYm90dG9tIjtzOjE6IjMiO3M6Mjc6ImNzc193aWRnZXRfcGFkZGluZ192ZXJ0aWNhbCI7czoyOiIzMyI7czoyOToiY3NzX3dpZGdldF9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiMzQiO3M6MjQ6ImNzc193aWRnZXRfbWFyZ2luX2JvdHRvbSI7czoyOiIzMiI7czoyMToiY3NzX3RpdGxlX2xpbmVfaGVpZ2h0IjtzOjI6IjE2IjtzOjE2OiJjc3NfdGl0bGVfbWFyZ2luIjtzOjI6IjE0IjtzOjE3OiJjc3NfdGl0bGVfcGFkZGluZyI7czoyOiIxOCI7czoxNDoiY3NzX2xpbmtfY29sb3IiO3M6NzoiIzE2YThmNyI7czoyMDoiY3NzX2xpbmtfY29sb3JfaG92ZXIiO3M6NzoiIzE2ODljNyI7czoxODoibW9kdWxlX2luc3RhbmNlX2lkIjtpOjQ3O3M6OToibW9kdWxlX2lkIjtzOjEyOiJEU0xDX1dpZGdldHMiO30=[/dslc_module] [/dslc_modules_area] [dslc_modules_area last="yes" first="no" size="9"] [dslc_module]YTo0ODp7czo0OiJzaXplIjtzOjI6IjEyIjtzOjY6ImFtb3VudCI7czoxOiI2IjtzOjE1OiJwYWdpbmF0aW9uX3R5cGUiO3M6ODoibnVtYmVyZWQiO3M6NzoiY29sdW1ucyI7czoxOiI0IjtzOjU6Im9yZGVyIjtzOjM6IkFTQyI7czoxMzoicG9zdF9lbGVtZW50cyI7czoyNDoidGh1bWJuYWlsIHRpdGxlIGV4Y2VycHQgIjtzOjE0OiJjc3Nfc2VwX2hlaWdodCI7czoyOiIxMyI7czoxMzoiY3NzX3NlcF9zdHlsZSI7czo0OiJub25lIjtzOjIyOiJjc3NfdGh1bWJuYWlsX2JnX2NvbG9yIjtzOjc6IiMwMGJkOGUiO3M6MzE6ImNzc190aHVtYm5haWxfYm9yZGVyX3JhZGl1c190b3AiO3M6MToiMCI7czoxODoidGh1bWJfcmVzaXplX3dpZHRoIjtzOjM6IjQwMCI7czoxNzoiY3NzX21haW5fYmdfY29sb3IiO3M6NzoiIzE2YThmNyI7czoyMToiY3NzX21haW5fYm9yZGVyX2NvbG9yIjtzOjc6IiMwMGEyZmYiO3M6MjE6ImNzc19tYWluX2JvcmRlcl93aWR0aCI7czoxOiIwIjtzOjI5OiJjc3NfbWFpbl9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiIwIjtzOjI1OiJjc3NfbWFpbl9wYWRkaW5nX3ZlcnRpY2FsIjtzOjI6IjI0IjtzOjI3OiJjc3NfbWFpbl9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiMzQiO3M6MTk6ImNzc19tYWluX3RleHRfYWxpZ24iO3M6NDoibGVmdCI7czoxNToiY3NzX3RpdGxlX2NvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MTk6ImNzc190aXRsZV9mb250X3NpemUiO3M6MjoiMTgiO3M6MjE6ImNzc190aXRsZV9mb250X3dlaWdodCI7czozOiIzMDAiO3M6MjE6ImNzc190aXRsZV9saW5lX2hlaWdodCI7czoyOiIzNSI7czoyMzoiY3NzX3RpdGxlX21hcmdpbl9ib3R0b20iO3M6MToiOSI7czoxNDoiY3NzX2NhdHNfY29sb3IiO3M6NzoiI2QyZTlmNSI7czoxODoiY3NzX2NhdHNfZm9udF9zaXplIjtzOjI6IjExIjtzOjIyOiJjc3NfY2F0c19tYXJnaW4tYm90dG9tIjtzOjI6IjE5IjtzOjI0OiJjc3NfZXhjZXJwdF9ib3JkZXJfY29sb3IiO3M6NzoiIzQ0YjNlYiI7czoxNzoiY3NzX2V4Y2VycHRfY29sb3IiO3M6NzoiI2UzZjZmZiI7czoyMzoiY3NzX2V4Y2VycHRfZm9udF93ZWlnaHQiO3M6MzoiNjAwIjtzOjIzOiJjc3NfZXhjZXJwdF9mb250X2ZhbWlseSI7czoxMjoiUG9udGFubyBTYW5zIjtzOjIzOiJjc3NfZXhjZXJwdF9saW5lX2hlaWdodCI7czoyOiIyNCI7czoxNDoiZXhjZXJwdF9tYXJnaW4iO3M6MToiMiI7czoxNDoiZXhjZXJwdF9sZW5ndGgiO3M6MjoiMTEiO3M6MTk6ImNzc19leGNlcnB0X3BhZGRpbmciO3M6MjoiMTMiO3M6MTk6ImNzc19idXR0b25fYmdfY29sb3IiO3M6NzoiIzdhN2E3YSI7czoxODoibWFpbl9oZWFkaW5nX3RpdGxlIjtzOjE1OiJMYXRlc3QgUHJvamVjdHMiO3M6MjY6ImNzc19tYWluX2hlYWRpbmdfZm9udF9zaXplIjtzOjI6IjE2IjtzOjI4OiJjc3NfbWFpbl9oZWFkaW5nX2ZvbnRfd2VpZ2h0IjtzOjM6IjYwMCI7czoyODoiY3NzX21haW5faGVhZGluZ19mb250X2ZhbWlseSI7czo0OiJMYXRvIjtzOjI3OiJjc3NfbWFpbl9oZWFkaW5nX2xpbmtfY29sb3IiO3M6NzoiIzE2YThmNyI7czozMzoiY3NzX21haW5faGVhZGluZ19saW5rX2NvbG9yX2hvdmVyIjtzOjc6IiMxMjg2YzQiO3M6MzM6ImNzc19tYWluX2hlYWRpbmdfbGlua19mb250X3dlaWdodCI7czozOiI3MDAiO3M6Mjg6ImNzc19wYWdfaXRlbV9iZ19jb2xvcl9hY3RpdmUiO3M6NzoiIzE2YThmNyI7czoyNToiY3NzX3BhZ19pdGVtX2JvcmRlcl9jb2xvciI7czo3OiIjZDZkNmQ2IjtzOjMyOiJjc3NfcGFnX2l0ZW1fYm9yZGVyX2NvbG9yX2FjdGl2ZSI7czo3OiIjMTZhOGY3IjtzOjE4OiJjc3NfcGFnX2l0ZW1fY29sb3IiO3M6NzoiIzhmOGY4ZiI7czoxODoibW9kdWxlX2luc3RhbmNlX2lkIjtpOjQ4O3M6OToibW9kdWxlX2lkIjtzOjEzOiJEU0xDX1Byb2plY3RzIjt9[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Project Listing',
	);

	$templates['dslc-partners-ex-1'] = array(
		'title' => __( 'Partners Variation 1', 'live-composer-page-builder' ),
		'id' => 'dslc-partners-ex-1',
		'code' => '[dslc_modules_section show_on="desktop tablet phone" type="wrapped" columns_spacing="spacing" bg_color="" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="left top" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#111e2e" bg_video_overlay_opacity="0.56" border_color="" border_width="0" border_style="solid" border="top bottom" margin_h="0" margin_b="0" padding="114" padding_h="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module last="yes"]YToyNDp7czoxNToicGFnaW5hdGlvbl90eXBlIjtzOjg6Im51bWJlcmVkIjtzOjMxOiJjc3NfdGh1bWJuYWlsX2JvcmRlcl9yYWRpdXNfdG9wIjtzOjE6IjMiO3M6Mjc6ImNzc190aHVtYm5haWxfbWFyZ2luX2JvdHRvbSI7czoxOiIwIjtzOjE4OiJ0aHVtYl9yZXNpemVfd2lkdGgiO3M6MzoiMjc0IjtzOjE3OiJjc3NfbWFpbl9iZ19jb2xvciI7czo3OiIjMWRjMjY3IjtzOjI5OiJjc3NfbWFpbl9ib3JkZXJfcmFkaXVzX2JvdHRvbSI7czoxOiIzIjtzOjI1OiJjc3NfbWFpbl9wYWRkaW5nX3ZlcnRpY2FsIjtzOjI6IjI1IjtzOjI3OiJjc3NfbWFpbl9wYWRkaW5nX2hvcml6b250YWwiO3M6MjoiMzAiO3M6MTk6ImNzc19tYWluX3RleHRfYWxpZ24iO3M6NjoiY2VudGVyIjtzOjE1OiJjc3NfdGl0bGVfY29sb3IiO3M6NzoiI2ZmZmZmZiI7czoxOToiY3NzX3RpdGxlX2ZvbnRfc2l6ZSI7czoyOiIxNiI7czoxNzoiY3NzX2V4Y2VycHRfY29sb3IiO3M6NzoiI2JhZjVkNCI7czoyMzoiY3NzX2V4Y2VycHRfbGluZV9oZWlnaHQiO3M6MjoiMjEiO3M6Mjg6ImNzc19wYWdfaXRlbV9iZ19jb2xvcl9hY3RpdmUiO3M6NzoiIzFkYzI2NyI7czozMjoiY3NzX3BhZ19pdGVtX2JvcmRlcl9jb2xvcl9hY3RpdmUiO3M6NzoiIzFkYzI2NyI7czoxNDoicmVzX3NtX2NvbHVtbnMiO3M6NDoiYXV0byI7czoxMjoicmVzX3NtX3RodW1iIjtzOjU6ImJsb2NrIjtzOjE0OiJyZXNfdHBfY29sdW1ucyI7czo0OiJhdXRvIjtzOjEzOiJyZXNfcF9jb2x1bW5zIjtzOjQ6ImF1dG8iO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI1NTtzOjc6InBvc3RfaWQiO3M6MzoiNDU1IjtzOjk6Im1vZHVsZV9pZCI7czoxMzoiRFNMQ19QYXJ0bmVycyI7czoxNjoiZHNsY19tX3NpemVfbGFzdCI7czoyOiJubyI7czoxMToiZHNsY19tX3NpemUiO3M6MjoiMTIiO30=[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Custom Posts Listing',
	);

	$templates['dslc-products-ex-1'] = array(
		'title' => __( 'Products Variation 1', 'live-composer-page-builder' ),
		'id' => 'dslc-products-ex-1',
		'code' => '[dslc_modules_section show_on="desktop tablet phone" type="wrapped" columns_spacing="spacing" bg_color="" bg_image_thumb="disabled" bg_image="" bg_image_repeat="no-repeat" bg_image_position="center center" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#5d5361" bg_video_overlay_opacity="0.81" border_color="" border_width="0" border_style="solid" border="bottom " margin_h="0" margin_b="0" padding="95" padding_h="9" custom_class="" custom_id="" ] [dslc_modules_area last="no" first="yes" size="9"] [dslc_module last="yes"]YTo0Njp7czo2OiJhbW91bnQiO3M6MToiNiI7czo3OiJjb2x1bW5zIjtzOjE6IjQiO3M6MTM6InBvc3RfZWxlbWVudHMiO3M6NDI6InRodW1ibmFpbCB0aXRsZSBzZXBhcmF0b3IgZXhjZXJwdCBwcmljZV8yICI7czoyMDoiY3NzX3NlcF9ib3JkZXJfY29sb3IiO3M6NzoiI2E0OTZhYiI7czoxNDoiY3NzX3NlcF9oZWlnaHQiO3M6MjoiMTAiO3M6MTM6ImNzc19zZXBfc3R5bGUiO3M6NDoibm9uZSI7czoyMjoiY3NzX3RodW1iX2JvcmRlcl9jb2xvciI7czo3OiIjMmUyODJlIjtzOjMxOiJjc3NfdGh1bWJuYWlsX2JvcmRlcl9yYWRpdXNfdG9wIjtzOjE6IjAiO3M6MTk6InRodW1iX3Jlc2l6ZV9oZWlnaHQiO3M6MzoiMjUwIjtzOjE4OiJ0aHVtYl9yZXNpemVfd2lkdGgiO3M6MzoiMjgwIjtzOjE4OiJjc3NfcHJpY2VfYmdfY29sb3IiO3M6NzoiIzdhNmU4MCI7czoyMjoiY3NzX3ByaWNlX2JvcmRlcl9jb2xvciI7czo3OiIjYTg2NTY1IjtzOjIzOiJjc3NfcHJpY2VfYm9yZGVyX3JhZGl1cyI7czoxOiIwIjtzOjE5OiJjc3NfcHJpY2VfZm9udF9zaXplIjtzOjI6IjI4IjtzOjE2OiJjc3NfcHJpY2VfbWFyZ2luIjtzOjE6IjkiO3M6MjA6ImNzc19wcmljZV9iZ19vcGFjaXR5IjtzOjE6IjEiO3M6MTc6ImNzc19wcmljZV9wYWRkaW5nIjtzOjI6IjIwIjtzOjE3OiJjc3NfbWFpbl9iZ19jb2xvciI7czo3OiIjMmUyODJlIjtzOjIxOiJjc3NfbWFpbl9ib3JkZXJfd2lkdGgiO3M6MToiMCI7czoyOToiY3NzX21haW5fYm9yZGVyX3JhZGl1c19ib3R0b20iO3M6MToiMCI7czoyNToiY3NzX21haW5fcGFkZGluZ192ZXJ0aWNhbCI7czoyOiIzMCI7czoyNzoiY3NzX21haW5fcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjI5IjtzOjE1OiJjc3NfdGl0bGVfYWxpZ24iO3M6NDoibGVmdCI7czoxNToiY3NzX3RpdGxlX2NvbG9yIjtzOjc6IiNkOWJiODAiO3M6MTk6ImNzc190aXRsZV9mb250X3NpemUiO3M6MjoiMTQiO3M6MjE6ImNzc190aXRsZV9mb250X2ZhbWlseSI7czo5OiJPcGVuIFNhbnMiO3M6MjM6ImNzc190aXRsZV9tYXJnaW5fYm90dG9tIjtzOjI6IjIwIjtzOjI0OiJjc3NfZXhjZXJwdF9ib3JkZXJfd2lkdGgiO3M6MToiMCI7czoxNzoiY3NzX2V4Y2VycHRfY29sb3IiO3M6NzoiIzljOTM5YyI7czoxNDoiZXhjZXJwdF9tYXJnaW4iO3M6MToiMCI7czoxNDoiZXhjZXJwdF9sZW5ndGgiO3M6MToiNyI7czoxOToiY3NzX2V4Y2VycHRfcGFkZGluZyI7czoxOiIwIjtzOjIyOiJjc3NfZXhjZXJwdF90ZXh0X2FsaWduIjtzOjQ6ImxlZnQiO3M6MTc6ImNzc19wcmljZV8yX2NvbG9yIjtzOjc6IiM5YzkzOWMiO3M6MzA6ImNzc19wcmljZV8yX25vbl9kaXNjb3VudF9jb2xvciI7czo3OiIjNTk1MTU5IjtzOjEzOiJjc3Nfc2VwX2NvbG9yIjtzOjc6IiM0NzQxNDciO3M6MjE6ImNzc19zZXBfbWFyZ2luX2JvdHRvbSI7czoyOiIxOCI7czoxNDoicmVzX3NtX2NvbHVtbnMiO3M6NDoiYXV0byI7czoxMjoicmVzX3NtX3RodW1iIjtzOjU6ImJsb2NrIjtzOjE0OiJyZXNfdHBfY29sdW1ucyI7czo0OiJhdXRvIjtzOjEzOiJyZXNfcF9jb2x1bW5zIjtzOjQ6ImF1dG8iO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI1NjtzOjc6InBvc3RfaWQiO3M6MzoiNDQ5IjtzOjk6Im1vZHVsZV9pZCI7czoyNToiRFNMQ19Xb29Db21tZXJjZV9Qcm9kdWN0cyI7czoxNjoiZHNsY19tX3NpemVfbGFzdCI7czoyOiJubyI7czoxMToiZHNsY19tX3NpemUiO3M6MjoiMTIiO30=[/dslc_module] [/dslc_modules_area] [dslc_modules_area last="yes" first="no" size="3"] [dslc_module last="yes"]YToxODp7czo3OiJzaWRlYmFyIjtzOjE2OiJkc2xjX3NpZGViYXJfb25lIjtzOjc6ImNvbHVtbnMiO3M6MjoiMTIiO3M6MjA6ImNzc193aWRnZXRzX2JnX2NvbG9yIjtzOjc6IiMyZTI4MmUiO3M6Mjg6ImNzc193aWRnZXRzX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMzQiO3M6MzA6ImNzc193aWRnZXRzX3BhZGRpbmdfaG9yaXpvbnRhbCI7czoyOiIzMSI7czoyNDoiY3NzX3dpZGdldF9tYXJnaW5fYm90dG9tIjtzOjI6IjM4IjtzOjIyOiJjc3NfdGl0bGVfYm9yZGVyX2NvbG9yIjtzOjc6IiM0NzQxNDciO3M6MTU6ImNzc190aXRsZV9jb2xvciI7czo3OiIjZGJkYmRiIjtzOjE2OiJjc3NfdGl0bGVfbWFyZ2luIjtzOjI6IjE1IjtzOjE3OiJjc3NfdGl0bGVfcGFkZGluZyI7czoyOiIyMSI7czoxNDoiY3NzX21haW5fY29sb3IiO3M6NzoiIzljOTM5YyI7czoxNDoiY3NzX2xpbmtfY29sb3IiO3M6NzoiI2Q5YmI4MCI7czoyMDoiY3NzX2xpbmtfY29sb3JfaG92ZXIiO3M6NzoiI2ViYjU1MiI7czoxODoibW9kdWxlX2luc3RhbmNlX2lkIjtpOjIwMjU3O3M6NzoicG9zdF9pZCI7czozOiI0NDkiO3M6OToibW9kdWxlX2lkIjtzOjEyOiJEU0xDX1dpZGdldHMiO3M6MTY6ImRzbGNfbV9zaXplX2xhc3QiO3M6Mjoibm8iO3M6MTE6ImRzbGNfbV9zaXplIjtzOjI6IjEyIjt9[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Custom Posts Listing',
	);

	$templates['dslc-products-ex-2'] = array(
		'title' => __( 'Products Variation 2', 'live-composer-page-builder' ),
		'id' => 'dslc-products-ex-2',
		'code' => '[dslc_modules_section show_on="desktop tablet phone" type="wrapped" columns_spacing="spacing" bg_color="#78373c" bg_image_thumb="disabled" bg_image="" bg_image_repeat="no-repeat" bg_image_position="center center" bg_image_attachment="scroll" bg_image_size="auto" bg_video="" bg_video_overlay_color="#4d4d4d" bg_video_overlay_opacity="0.77" border_color="" border_width="0" border_style="solid" border="bottom " margin_h="0" margin_b="0" padding="69" padding_h="9" custom_class="" custom_id="" ] [dslc_modules_area last="no" first="yes" size="5"] [dslc_module last="yes"]YTo1NTp7czo2OiJhbW91bnQiO3M6MToiMSI7czo3OiJjb2x1bW5zIjtzOjI6IjEyIjtzOjEwOiJjYXRlZ29yaWVzIjtzOjg6Imhvb2RpZXMgIjtzOjEzOiJwb3N0X2VsZW1lbnRzIjtzOjUyOiJ0aHVtYm5haWwgdGl0bGUgc2VwYXJhdG9yIHByaWNlXzIgYWRkdG9jYXJ0IGRldGFpbHMgIjtzOjIwOiJjc3Nfc2VwX2JvcmRlcl9jb2xvciI7czo3OiIjYTQ5NmFiIjtzOjE0OiJjc3Nfc2VwX2hlaWdodCI7czoyOiIxMCI7czoxMzoiY3NzX3NlcF9zdHlsZSI7czo0OiJub25lIjtzOjIyOiJjc3NfdGh1bWJuYWlsX2JnX2NvbG9yIjtzOjc6IiMxYzFiMWEiO3M6MjI6ImNzc190aHVtYl9ib3JkZXJfY29sb3IiO3M6NzoiIzJlMjgyZSI7czozMToiY3NzX3RodW1ibmFpbF9ib3JkZXJfcmFkaXVzX3RvcCI7czoxOiIwIjtzOjMwOiJjc3NfdGh1bWJuYWlsX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMTUiO3M6MzI6ImNzc190aHVtYm5haWxfcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjE1IjtzOjE4OiJ0aHVtYl9yZXNpemVfd2lkdGgiO3M6MzoiNDQ3IjtzOjE4OiJjc3NfcHJpY2VfYmdfY29sb3IiO3M6NzoiIzk5MmYzOCI7czoyMjoiY3NzX3ByaWNlX2JvcmRlcl9jb2xvciI7czo3OiIjYTg2NTY1IjtzOjIzOiJjc3NfcHJpY2VfYm9yZGVyX3JhZGl1cyI7czoxOiI1IjtzOjE5OiJjc3NfcHJpY2VfZm9udF9zaXplIjtzOjI6IjQyIjtzOjIxOiJjc3NfcHJpY2VfZm9udF93ZWlnaHQiO3M6MzoiOTAwIjtzOjIxOiJjc3NfcHJpY2VfZm9udF9mYW1pbHkiO3M6MTI6IlBhdHJpY2sgSGFuZCI7czoxNjoiY3NzX3ByaWNlX21hcmdpbiI7czoxOiI5IjtzOjE3OiJjc3NfcHJpY2VfcGFkZGluZyI7czoyOiIyMyI7czoxNzoiY3NzX21haW5fYmdfY29sb3IiO3M6NzoiIzFjMWIxYSI7czoyMToiY3NzX21haW5fYm9yZGVyX3dpZHRoIjtzOjE6IjAiO3M6Mjk6ImNzc19tYWluX2JvcmRlcl9yYWRpdXNfYm90dG9tIjtzOjE6IjAiO3M6MTk6ImNzc19tYWluX21pbl9oZWlnaHQiO3M6MjoiODAiO3M6MjU6ImNzc19tYWluX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMTciO3M6Mjc6ImNzc19tYWluX3BhZGRpbmdfaG9yaXpvbnRhbCI7czoyOiIyOSI7czoxNToiY3NzX3RpdGxlX2NvbG9yIjtzOjc6IiNjN2M3YzciO3M6MTk6ImNzc190aXRsZV9mb250X3NpemUiO3M6MjoiMTYiO3M6MjE6ImNzc190aXRsZV9mb250X2ZhbWlseSI7czo5OiJPcGVuIFNhbnMiO3M6MjM6ImNzc190aXRsZV9tYXJnaW5fYm90dG9tIjtzOjI6IjIwIjtzOjI0OiJjc3NfZXhjZXJwdF9ib3JkZXJfY29sb3IiO3M6NzoiIzQ3NDE0NyI7czoxNzoiY3NzX2V4Y2VycHRfY29sb3IiO3M6NzoiIzljOTM5YyI7czoxNDoiZXhjZXJwdF9tYXJnaW4iO3M6MjoiMTkiO3M6MTQ6ImV4Y2VycHRfbGVuZ3RoIjtzOjI6IjE5IjtzOjE5OiJjc3NfZXhjZXJwdF9wYWRkaW5nIjtzOjI6IjEzIjtzOjE3OiJjc3NfcHJpY2VfMl9jb2xvciI7czo3OiIjOWM5MzljIjtzOjMwOiJjc3NfcHJpY2VfMl9ub25fZGlzY291bnRfY29sb3IiO3M6NzoiIzU5NTE1OSI7czoxNToiY3NzX3ByaWNlXzJfcG9zIjtzOjQ6ImxlZnQiO3M6MTM6ImNzc19zZXBfY29sb3IiO3M6NzoiIzQ3NDE0NyI7czoyMToiY3NzX3NlcF9tYXJnaW5fYm90dG9tIjtzOjI6IjE4IjtzOjE5OiJjc3NfYWRkdG9jYXJ0X2NvbG9yIjtzOjc6IiNlZDczNGUiO3M6MjM6ImNzc19hZGR0b2NhcnRfZm9udF9zaXplIjtzOjI6IjE0IjtzOjE3OiJjc3NfZGV0YWlsc19jb2xvciI7czo3OiIjZWQ3MzRlIjtzOjIxOiJjc3NfZGV0YWlsc19mb250X3NpemUiO3M6MjoiMTQiO3M6MjM6ImNzc19kZXRhaWxzX2ZvbnRfd2VpZ2h0IjtzOjM6IjcwMCI7czoxNDoicmVzX3NtX2NvbHVtbnMiO3M6NDoiYXV0byI7czoxMjoicmVzX3NtX3RodW1iIjtzOjU6ImJsb2NrIjtzOjE0OiJyZXNfdHBfY29sdW1ucyI7czo0OiJhdXRvIjtzOjEzOiJyZXNfcF9jb2x1bW5zIjtzOjQ6ImF1dG8iO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI1ODtzOjc6InBvc3RfaWQiO3M6MzoiNDUxIjtzOjk6Im1vZHVsZV9pZCI7czoyNToiRFNMQ19Xb29Db21tZXJjZV9Qcm9kdWN0cyI7czoxNjoiZHNsY19tX3NpemVfbGFzdCI7czoyOiJubyI7czoxMToiZHNsY19tX3NpemUiO3M6MjoiMTIiO30=[/dslc_module] [/dslc_modules_area] [dslc_modules_area last="no" first="no" size="1"] [/dslc_modules_area] [dslc_modules_area last="yes" first="no" size="6"] [dslc_module last="yes"]YTo3OntzOjY6ImhlaWdodCI7czoyOiI0MSI7czo1OiJzdHlsZSI7czo5OiJpbnZpc2libGUiO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI1OTtzOjc6InBvc3RfaWQiO3M6MzoiNDUxIjtzOjk6Im1vZHVsZV9pZCI7czoxNDoiRFNMQ19TZXBhcmF0b3IiO3M6MTY6ImRzbGNfbV9zaXplX2xhc3QiO3M6Mjoibm8iO3M6MTE6ImRzbGNfbV9zaXplIjtzOjI6IjEyIjt9[/dslc_module] [dslc_module last="yes"]YToxMTp7czo3OiJjb250ZW50IjtzOjI4OiJTZWN0aW9uIGZvciBwcm9kdWN0IHNob3djYXNlIjtzOjE3OiJjc3NfbWFyZ2luX2JvdHRvbSI7czoyOiIzNiI7czoxNDoiY3NzX21haW5fY29sb3IiO3M6NzoiI2ZmZmZmZiI7czoxODoiY3NzX21haW5fZm9udF9zaXplIjtzOjI6IjM5IjtzOjIwOiJjc3NfbWFpbl9mb250X3dlaWdodCI7czozOiIzMDAiO3M6MjA6ImNzc19tYWluX2ZvbnRfZmFtaWx5IjtzOjc6IlJhbGV3YXkiO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI2MDtzOjc6InBvc3RfaWQiO3M6MzoiNDUxIjtzOjk6Im1vZHVsZV9pZCI7czoxNjoiRFNMQ19UZXh0X1NpbXBsZSI7czoxNjoiZHNsY19tX3NpemVfbGFzdCI7czoyOiJubyI7czoxMToiZHNsY19tX3NpemUiO3M6MjoiMTIiO30=[/dslc_module] [dslc_module last="yes"]YToxMTp7czo3OiJjb250ZW50IjtzOjEwNzQ6IlV0IGVuaW0gYWQgbWluaW0gdmVuaWFtLCBxdWlzIG5vc3RydWQgZXhlcmNpdGF0aW9uIHVsbGFtY28gbGFib3JpcyBuaXNpIHV0IGFsaXF1aXAgZXggZWEgY29tbW9kbyBjb25zZXF1YXQuJm5ic3A7PGRpdj48YnI+PC9kaXY+PGRpdj48c3BhbiBzdHlsZT1cImZvbnQtZmFtaWx5OiBNdWxpOyBmb250LXNpemU6IDE2cHg7IGZvbnQtc3R5bGU6IG5vcm1hbDsgZm9udC12YXJpYW50OiBub3JtYWw7IGxpbmUtaGVpZ2h0OiAyN3B4O1wiPkR1aXMgYXV0ZSBpcnVyZSBkb2xvciBpbiByZXByZWhlbmRlcml0IGluIHZvbHVwdGF0ZSB2ZWxpdCBlc3NlIGNpbGx1bSBkb2xvcmUgZXUgZnVnaWF0IG51bGxhIHBhcmlhdHVyLiBFeGNlcHRldXIgc2ludCBvY2NhZWNhdCBjdXBpZGF0YXQgbm9uIHByb2lkZW50LCBzdW50IGluIGN1bHBhIHF1aSBvZmZpY2lhIGRlc2VydW50IG1vbGxpdCBhbmltIGlkIGVzdCBsYWJvcnVtLjwvc3Bhbj48YnI+PC9kaXY+PGRpdj48c3BhbiBzdHlsZT1cImZvbnQtZmFtaWx5OiBNdWxpOyBmb250LXNpemU6IDE2cHg7IGZvbnQtc3R5bGU6IG5vcm1hbDsgZm9udC12YXJpYW50OiBub3JtYWw7IGxpbmUtaGVpZ2h0OiAyN3B4O1wiPjxicj48L3NwYW4+PC9kaXY+PGRpdj48c3BhbiBzdHlsZT1cImZvbnQtZmFtaWx5OiBNdWxpOyBmb250LXNpemU6IDE2cHg7IGZvbnQtc3R5bGU6IG5vcm1hbDsgZm9udC12YXJpYW50OiBub3JtYWw7IGxpbmUtaGVpZ2h0OiAyN3B4O1wiPkF1dGUgaXJ1cmUgZG9sb3IgaW4gcmVwcmVoZW5kZXJpdCBpbiB2b2x1cHRhdGUgdmVsaXQgZXNzZSBjaWxsdW0gZG9sb3JlIGV1IGZ1Z2lhdCBudWxsYSBwYXJpYXR1ci4gRXhjZXB0ZXVyIHNpbnQgb2NjYWVjYXQgY3VwaWRhdGF0IG5vbiBwcm9pZGVudCwgc3VudCBpbiBjdWxwYSBxdWkgb2ZmaWNpYSBkZXNlcnVudCBtb2xsaXQgYW5pbSBpZCBlc3QgbGFib3J1bS48L3NwYW4+PHNwYW4gc3R5bGU9XCJmb250LWZhbWlseTogTXVsaTsgZm9udC1zaXplOiAxNnB4OyBmb250LXN0eWxlOiBub3JtYWw7IGZvbnQtdmFyaWFudDogbm9ybWFsOyBsaW5lLWhlaWdodDogMjdweDtcIj48YnI+PC9zcGFuPjwvZGl2PiI7czoxNzoiY3NzX21hcmdpbl9ib3R0b20iO3M6MjoiNDEiO3M6MTQ6ImNzc19tYWluX2NvbG9yIjtzOjc6IiNjN2M3YzciO3M6MTg6ImNzc19tYWluX2ZvbnRfc2l6ZSI7czoyOiIxNiI7czoyMDoiY3NzX21haW5fZm9udF9mYW1pbHkiO3M6NDoiTXVsaSI7czoyMDoiY3NzX21haW5fbGluZV9oZWlnaHQiO3M6MjoiMjciO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aToyMDI2MTtzOjc6InBvc3RfaWQiO3M6MzoiNDUxIjtzOjk6Im1vZHVsZV9pZCI7czoxNjoiRFNMQ19UZXh0X1NpbXBsZSI7czoxNjoiZHNsY19tX3NpemVfbGFzdCI7czoyOiJubyI7czoxMToiZHNsY19tX3NpemUiO3M6MjoiMTIiO30=[/dslc_module] [dslc_module last="yes"]YToxNDp7czoxMToiYnV0dG9uX3RleHQiO3M6MTI6Ik1PUkUgREVUQUlMUyI7czoxMjoiY3NzX2JnX2NvbG9yIjtzOjc6IiNlZDczNGUiO3M6MTg6ImNzc19iZ19jb2xvcl9ob3ZlciI7czo3OiIjZjI3NTUzIjtzOjIwOiJjc3NfcGFkZGluZ192ZXJ0aWNhbCI7czoyOiIxOCI7czoyMjoiY3NzX3BhZGRpbmdfaG9yaXpvbnRhbCI7czoyOiIzNSI7czoyMDoiY3NzX2J1dHRvbl9mb250X3NpemUiO3M6MjoiMTYiO3M6MTQ6ImJ1dHRvbl9pY29uX2lkIjtzOjk6ImZpbGUtdGV4dCI7czoxNDoiY3NzX2ljb25fY29sb3IiO3M6NzoiI2ZmYjM5ZSI7czoxNToiY3NzX2ljb25fbWFyZ2luIjtzOjI6IjEwIjtzOjE4OiJtb2R1bGVfaW5zdGFuY2VfaWQiO2k6MjAyNjI7czo3OiJwb3N0X2lkIjtzOjM6IjQ1MSI7czo5OiJtb2R1bGVfaWQiO3M6MTE6IkRTTENfQnV0dG9uIjtzOjE2OiJkc2xjX21fc2l6ZV9sYXN0IjtzOjI6Im5vIjtzOjExOiJkc2xjX21fc2l6ZSI7czoyOiIxMiI7fQ==[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Custom Posts Listing',
	);

	$templates['dslc-staff-ex-1'] = array(
		'title' => __( 'Staff Variation 1', 'live-composer-page-builder' ),
		'id' => 'dslc-staff-ex-1',
		'code' => '[dslc_modules_section show_on="desktop tablet phone" type="wrapped" columns_spacing="spacing" bg_color="#f4f6f7" bg_image_thumb="disabled" bg_image="" bg_image_repeat="repeat" bg_image_position="center center" bg_image_attachment="scroll" bg_image_size="cover" bg_video="" bg_video_overlay_color="#f4f6f7" bg_video_overlay_opacity="0.95" border_color="" border_width="0" border_style="solid" border="top bottom" margin_h="0" margin_b="0" padding="67" padding_h="4" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module last="yes"]YTozNzp7czoxMzoicG9zdF9lbGVtZW50cyI7czozMToidGh1bWJuYWlsIHNvY2lhbCB0aXRsZSBleGNlcnB0ICI7czoyMjoiY3NzX3RodW1ibmFpbF9iZ19jb2xvciI7czo3OiIjZmZmZmZmIjtzOjIyOiJjc3NfdGh1bWJfYm9yZGVyX2NvbG9yIjtzOjc6IiNlMGUwZTAiO3M6MjI6ImNzc190aHVtYl9ib3JkZXJfd2lkdGgiO3M6MToiMSI7czozMToiY3NzX3RodW1ibmFpbF9ib3JkZXJfcmFkaXVzX3RvcCI7czoxOiIzIjtzOjM0OiJjc3NfdGh1bWJuYWlsX2JvcmRlcl9yYWRpdXNfYm90dG9tIjtzOjE6IjMiO3M6Mjc6ImNzc190aHVtYm5haWxfbWFyZ2luX2JvdHRvbSI7czoyOiIxNyI7czozMDoiY3NzX3RodW1ibmFpbF9wYWRkaW5nX3ZlcnRpY2FsIjtzOjI6IjEwIjtzOjMyOiJjc3NfdGh1bWJuYWlsX3BhZGRpbmdfaG9yaXpvbnRhbCI7czoyOiIxMCI7czoxOToidGh1bWJfcmVzaXplX2hlaWdodCI7czozOiIzMDAiO3M6MTg6InRodW1iX3Jlc2l6ZV93aWR0aCI7czozOiIyNTQiO3M6MTk6ImNzc19zb2NpYWxfYmdfY29sb3IiO3M6NzoiIzNkYjBiZiI7czoyODoiY3NzX3NvY2lhbF9ib3JkZXJfcmFkaXVzX3RvcCI7czoxOiIzIjtzOjIxOiJjc3NfbWFpbl9ib3JkZXJfY29sb3IiO3M6NzoiI2UwZTBlMCI7czoyNToiY3NzX21haW5fcGFkZGluZ192ZXJ0aWNhbCI7czoyOiI0MyI7czoyNzoiY3NzX21haW5fcGFkZGluZ19ob3Jpem9udGFsIjtzOjI6IjQzIjtzOjE1OiJjc3NfdGl0bGVfY29sb3IiO3M6NzoiIzU0NTQ1NCI7czoxOToiY3NzX3RpdGxlX2ZvbnRfc2l6ZSI7czoyOiIxNiI7czoyMToiY3NzX3RpdGxlX2ZvbnRfZmFtaWx5IjtzOjE3OiJMaWJyZSBCYXNrZXJ2aWxsZSI7czoyNToiY3NzX3Bvc2l0aW9uX2JvcmRlcl9jb2xvciI7czo3OiIjZGVkZWRlIjtzOjE4OiJjc3NfcG9zaXRpb25fY29sb3IiO3M6NzoiIzNkYjBiZiI7czoyNDoiY3NzX3Bvc2l0aW9uX2ZvbnRfd2VpZ2h0IjtzOjM6IjYwMCI7czoyNDoiY3NzX3Bvc2l0aW9uX2ZvbnRfZmFtaWx5IjtzOjE3OiJDYXJyb2lzIEdvdGhpYyBTQyI7czoyOToiY3NzX3Bvc2l0aW9uX3BhZGRpbmdfdmVydGljYWwiO3M6MjoiMTYiO3M6MTc6ImNzc19leGNlcnB0X2NvbG9yIjtzOjc6IiM5YzljOWMiO3M6MjE6ImNzc19leGNlcnB0X2ZvbnRfc2l6ZSI7czoyOiIxNiI7czoyMzoiY3NzX2V4Y2VycHRfZm9udF9mYW1pbHkiO3M6NDoiTG9yYSI7czoyMzoiY3NzX2V4Y2VycHRfbGluZV9oZWlnaHQiO3M6MjoiMjciO3M6MTQ6InJlc19zbV9jb2x1bW5zIjtzOjQ6ImF1dG8iO3M6MTI6InJlc19zbV90aHVtYiI7czo1OiJibG9jayI7czoxNDoicmVzX3RwX2NvbHVtbnMiO3M6NDoiYXV0byI7czoxMzoicmVzX3BfY29sdW1ucyI7czo0OiJhdXRvIjtzOjE4OiJtb2R1bGVfaW5zdGFuY2VfaWQiO2k6MjAyNjM7czo3OiJwb3N0X2lkIjtzOjM6IjQ2MSI7czo5OiJtb2R1bGVfaWQiO3M6MTA6IkRTTENfU3RhZmYiO3M6MTY6ImRzbGNfbV9zaXplX2xhc3QiO3M6Mjoibm8iO3M6MTE6ImRzbGNfbV9zaXplIjtzOjI6IjEyIjt9[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Custom Posts Listing',
	);

	$templates['dslc-staff-ex-2'] = array(
		'title' => __( 'Staff Variation 2', 'live-composer-page-builder' ),
		'id' => 'dslc-staff-ex-2',
		'code' => '[dslc_modules_section type="full" columns_spacing="spacing" border_color="" border_width="0" border_style="solid" border="top bottom" bg_color="#5c7291" bg_image_thumb="disabled" bg_image="" bg_video="" bg_video_overlay_color="#000000" bg_video_overlay_opacity="0" bg_image_repeat="repeat" bg_image_attachment="scroll" bg_image_position="left top" bg_image_size="auto" padding="80" padding_h="7" margin_h="0" margin_b="0" custom_class="" custom_id="" ] [dslc_modules_area last="yes" first="no" size="12"] [dslc_module]YTo0Njp7czo4OiJlbGVtZW50cyI7czoyMToibWFpbl9oZWFkaW5nIGZpbHRlcnMgIjtzOjIwOiJjc3Nfc2VwX2JvcmRlcl9jb2xvciI7czo3OiIjN2Y5MWFiIjtzOjEzOiJjc3Nfc2VwX3N0eWxlIjtzOjU6InNvbGlkIjtzOjMxOiJjc3NfdGh1bWJuYWlsX2JvcmRlcl9yYWRpdXNfdG9wIjtzOjE6IjAiO3M6MTg6InRodW1iX3Jlc2l6ZV93aWR0aCI7czozOiI1MjIiO3M6MTk6ImNzc19zb2NpYWxfYmdfY29sb3IiO3M6NzoiIzNiNDg1YyI7czoxNjoiY3NzX3NvY2lhbF9jb2xvciI7czo3OiIjN2I4ZWFiIjtzOjE3OiJjc3NfbWFpbl9iZ19jb2xvciI7czo3OiIjMWMyMDIxIjtzOjIxOiJjc3NfbWFpbl9ib3JkZXJfd2lkdGgiO3M6MToiMCI7czoyOToiY3NzX21haW5fYm9yZGVyX3JhZGl1c19ib3R0b20iO3M6MToiMCI7czoxNToiY3NzX3RpdGxlX2NvbG9yIjtzOjc6IiNlM2UzZTMiO3M6MjU6ImNzc19wb3NpdGlvbl9ib3JkZXJfY29sb3IiO3M6NzoiIzMwMzAzMCI7czoxNzoiY3NzX2V4Y2VycHRfY29sb3IiO3M6NzoiI2JkYmRiZCI7czoyMToiY3NzX2V4Y2VycHRfZm9udF9zaXplIjtzOjI6IjEyIjtzOjIzOiJjc3NfZXhjZXJwdF9mb250X2ZhbWlseSI7czo0OiJNdWxpIjtzOjIzOiJjc3NfZXhjZXJwdF9saW5lX2hlaWdodCI7czoyOiIyNCI7czoxODoibWFpbl9oZWFkaW5nX3RpdGxlIjtzOjE2OiJPVVIgQVdFU09NRSBURUFNIjtzOjIyOiJjc3NfbWFpbl9oZWFkaW5nX2NvbG9yIjtzOjc6IiNmZmZmZmYiO3M6MjY6ImNzc19tYWluX2hlYWRpbmdfZm9udF9zaXplIjtzOjI6IjI1IjtzOjI4OiJjc3NfbWFpbl9oZWFkaW5nX2ZvbnRfd2VpZ2h0IjtzOjM6IjUwMCI7czoyODoiY3NzX21haW5faGVhZGluZ19mb250X2ZhbWlseSI7czo3OiJSYWxld2F5IjtzOjI3OiJjc3NfbWFpbl9oZWFkaW5nX2xpbmtfY29sb3IiO3M6NzoiI2I0YzdkNiI7czozMToiY3NzX21haW5faGVhZGluZ19saW5rX2ZvbnRfc2l6ZSI7czoyOiIxMyI7czozMzoiY3NzX21haW5faGVhZGluZ19saW5rX2ZvbnRfd2VpZ2h0IjtzOjM6IjgwMCI7czozMzoiY3NzX21haW5faGVhZGluZ19saW5rX2ZvbnRfZmFtaWx5IjtzOjQ6Ik11bGkiO3M6MTM6InZpZXdfYWxsX2xpbmsiO3M6MDoiIjtzOjI2OiJjc3NfbWFpbl9oZWFkaW5nX3NlcF9jb2xvciI7czo3OiIjYjhiOGI4IjtzOjI1OiJjc3NfaGVhZGluZ19tYXJnaW5fYm90dG9tIjtzOjI6IjMzIjtzOjE5OiJjc3NfZmlsdGVyX2JnX2NvbG9yIjtzOjc6IiM0ODU4NzAiO3M6MjY6ImNzc19maWx0ZXJfYmdfY29sb3JfYWN0aXZlIjtzOjA6IiI7czoyMzoiY3NzX2ZpbHRlcl9ib3JkZXJfY29sb3IiO3M6NzoiIzQ4NTg3MCI7czozMDoiY3NzX2ZpbHRlcl9ib3JkZXJfY29sb3JfYWN0aXZlIjtzOjc6IiM0ODU4NzAiO3M6MjM6ImNzc19maWx0ZXJfYm9yZGVyX3dpZHRoIjtzOjE6IjMiO3M6MjQ6ImNzc19maWx0ZXJfYm9yZGVyX3JhZGl1cyI7czoxOiI0IjtzOjE2OiJjc3NfZmlsdGVyX2NvbG9yIjtzOjc6IiM3YjhlYWIiO3M6MjM6ImNzc19maWx0ZXJfY29sb3JfYWN0aXZlIjtzOjc6IiM0ODU4NzAiO3M6MjA6ImNzc19maWx0ZXJfZm9udF9zaXplIjtzOjI6IjEyIjtzOjIyOiJjc3NfZmlsdGVyX2ZvbnRfd2VpZ2h0IjtzOjM6IjgwMCI7czoxOToiY3NzX2ZpbHRlcl9wb3NpdGlvbiI7czo1OiJyaWdodCI7czoxNDoicmVzX3NtX2NvbHVtbnMiO3M6NDoiYXV0byI7czoxMjoicmVzX3NtX3RodW1iIjtzOjU6ImJsb2NrIjtzOjE0OiJyZXNfdHBfY29sdW1ucyI7czo0OiJhdXRvIjtzOjEzOiJyZXNfcF9jb2x1bW5zIjtzOjQ6ImF1dG8iO3M6MTg6Im1vZHVsZV9pbnN0YW5jZV9pZCI7aTo1ODtzOjc6InBvc3RfaWQiO3M6MzoiNDYzIjtzOjk6Im1vZHVsZV9pZCI7czoxMDoiRFNMQ19TdGFmZiI7fQ==[/dslc_module] [/dslc_modules_area] [/dslc_modules_section] ',
		'section' => 'Custom Posts Listing',
	);

	return $templates;

} add_filter( 'dslc_get_templates', 'dslc_set_default_templates', 1 );

/**
 * Set user templates
 *
 * @since 1.0.3
 * @param array $templates Templates.
 */
function dslc_set_user_templates( $templates ) {

	// Get user templates.
	$user_templates = maybe_unserialize( get_option( 'dslc_templates' ) );

	// If there are any, merge them with the templates array.
	if ( ! empty( $user_templates ) && is_array( $user_templates ) ) {
		$templates = array_merge( $templates, $user_templates );
	}

	// Pass it back.
	return $templates;

} add_filter( 'dslc_get_templates', 'dslc_set_user_templates', 1 );

/**
 * Loads modules in WP-style
 *
 * @param  string $dir_path
 * @param  string $init_filename - by default init php file is named like dir,
 *                                 but it can be overrided
 */
function dslc_load_modules( $dir_path, $init_filename = '' ) {
	$directories = glob( $dir_path . '/*', GLOB_ONLYDIR );

	foreach ( $directories as $dir ) {
		$plugin_file_name = explode( '/', $dir );
		$init_filename = ( '' !== $init_filename ) ? $init_filename : array_pop( $plugin_file_name ) . '.php';
		$widgetpath = $dir . '/' . $init_filename;
		if ( file_exists( $widgetpath ) ) {
			require_once $widgetpath;
		}
	}
}

/**
 * Migrate code from dslc_code generation one to two.
 * First generation: shortcodes + base64.
 * Second generation: JSON only.
 *
 * @param  array $settings Array with all the module properties.
 * @return array            The same array but adjusted to make migration seamless.
 */
function dslc_code_migration( $settings ) {

	if ( ! isset( $settings['module_id'] ) || ! class_exists( $settings['module_id'] ) ) {
		return;
	}

	// The ID of the module.
	$module_id = $settings['module_id'];

	// Instanciate the module class
	$module_instance = new $module_id();
	$module_struct = $module_instance->options();

	// Go trough module standard settings and check every color setting.
	// 🔖 RAW CODE CLEANUP
	foreach ( $module_struct as $control ) {
		$id = $control['id'];
		$type = $control['type'];

		// $module_settings[ $option_id ] = $option_arr['std'];
		/*
		// When import shortcodes code, 'Display on' setting is empty
		// when all the checkboxes selected. This makes the module completely
		// hidden in new version of code rendering.
		if ( 'css_show_on' === $id ) {
			if ( empty( $settings[ $id ] ) ) {
				$settings[ $id ] = 'desktop tablet phone';
			}
		}

		if ( stristr( $id, 'border_trbl' ) ) {
			if ( ! isset( $settings[ $id ] ) || empty( $settings[ $id ] ) ) {
				$settings[ $id ] = 'top right bottom left';
			}
		}
		*/
		// Check the conrol options in the old code and adjust them if needed.
		if ( 'color' === $type ) {

			// If this setting is set but value is empty...
			if ( isset( $settings[ $id ] ) && empty( $settings[ $id ] ) ) {
				// If the color is empty make it transparent.
				// In old code empty = transparent.
				// In new code empty = default color.
				// In new code transparent = rgba(0,0,0,0).
				$settings[ $id ] = 'inherit'; // @todo: still need it?

				if ( stristr( $id, 'icon_color' ) ) {
					$settings[ $id ] = '';
				}
			}

			// All other cases.
			if ( ! isset( $settings[ $id ] ) && isset( $control['std'] ) ) {
				$settings[ $id ] = $control['std'];
			}
		} elseif ( 'css_border_radius' === $type ) {
			// Set border-radius = 0 if in old version it was disabled.
			// If this setting isn't set at all...
			if ( ! isset( $settings[ $id ] ) ) {
				$settings[ $id ] = '0';
			}

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '0';
			}
		} elseif ( 'button_icon_id' === $id ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			}
		} elseif ( stristr( $id, 'border_trbl' ) ) {
			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			} elseif ( ! isset( $settings[ $id ] ) ) {
				/* Fix bug with disappearing borders when migrating to new version */
				$settings[ $id ] = $control['std'];
			}
		} elseif ( 'elements' === $id ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			} elseif ( ! isset( $settings[ $id ] ) ) {
				$settings[ $id ] = $control['std'];
			}
		} elseif ( 'content' === $id ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			} elseif ( ! isset( $settings[ $id ] ) && isset( $control['std'] ) ) {
				$settings[ $id ] = $control['std']; // Fix missing default content.
			}
		} elseif ( 'button_text' === $id ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			} elseif ( ! isset( $settings[ $id ] ) && isset( $control['std'] ) ) {
				$settings[ $id ] = $control['std']; // Fix missing default button labels.
			}
		} elseif ( 'main_heading_link_title' === $id ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			}
		} elseif ( stristr( $id, 'font_family' ) ) {

			if ( isset( $settings[ $id ] ) && '' === $settings[ $id ] ) {
				$settings[ $id ] = '';
			} elseif ( ! isset( $settings[ $id ] ) && isset( $control['std'] ) ) {
				$settings[ $id ] = $control['std']; // Fix missing default font family.
			}
		} elseif ( ( ! isset( $settings[ $id ] ) || '' === $settings[ $id ] ) &&
					isset( $control['std'] ) ) {

			// All other cases.
			// Go through each missing setting and fill it with default data.
			$settings[ $id ] = $control['std'];
		}// End if().
	}// End foreach().
	// Migration done. Remove the key code_version = 1.
	if ( isset( $settings['code_version'] ) ) {
		unset( $settings['code_version'] );
	}

	return $settings;
}

function dslc_sanitize_option_val( $data_to_sanitize ) {

	$id = $data_to_sanitize['id'];
	$value = $data_to_sanitize['value'];

	if ( $id !== 'content' &&  stristr( $value, '{\\' ) ) {
		// Filter out values with json code left by broken presets functionality.
		// But don't touch 'content' values as it used in HTML module, that can
		// contain complex html/css/js code.
		return '';
	} else {
		return $value;
	}
}

/*
Work in progress.

function dslc_sanitize_option_val ( $data_to_sanitize ) {

	$id = $data_to_sanitize['id'];

	$value = $data_to_sanitize['value'];
	$value_std = '';
	$option_type = '';
	$option_sanitize = '';

	if ( stristr( $id, 'css_' ) ) {
		// Sanitize CSS properties.

		// Allowed values (desktop ..., -80%, 20px, rgba(34,234,23), #0000).
		$pattern = '/^[0-9,a-z, ,\.,\-,(),#,%]{1,30}$/is';

		// CSS Value can't be more that 30 characters long. Don't ask why :).
		if ( preg_match( $pattern, $value ) ) {
			return $value;
		} else {
			return '';
		}

	} else {
		// Sanitize all other properties.

		// Extract all the option settings from the module settings.
		if ( isset( $data_to_sanitize['definition'] ) ) {

			$option_settings = $data_to_sanitize['definition'];

			if ( isset( $option_settings['type'] ) ) {
				$option_type = $option_settings['type'];
			}

			if ( isset( $option_settings['std'] ) ) {
				$value_std = $option_settings['std'];
			}

			if ( isset( $option_settings['sanitize'] ) ) {
				$option_sanitize = $option_settings['sanitize'];
			}
		}

		// First of all check if current value is default.
		if ( $value === $value_std ) {
			return $value;
		}

		// If there is no special sanitization option for the current option.
		if ( ! $option_sanitize ) {

			if ( 'slider' === $option_type ) {

				// Allow numbers only.
				$pattern_slider = '/^[0-9]{1,9}$/s';

				if ( preg_match( $pattern_slider, $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'color' === $option_type ) {

				// Allowed characters.
				$pattern_color = '/^[0-9,a-zA-Z, ,\.,(),#]{1,30}$/s';

				if ( preg_match( $pattern_color, $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'font' === $option_type ) {

				// Allowed characters.
				$pattern_font = '/^[0-9,a-zA-Z, ,",\',_,-]{1,80}$/s';

				if ( preg_match( $pattern_font, $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'icon' === $option_type ) {

				// Allowed characters.
				$pattern_icon = '/^[0-9,a-zA-Z, ,_,-]{1,30}$/s';

				if (preg_match( $pattern_icon, $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'image' === $option_type ) {

				// Allow numbers only for image IDs.
				$pattern_image = '/^[0-9]{1,9}$/s';

				if ( stristr( $value, '/') ) {
					// Image is URL.
					return esc_url( $value );
				} elseif ( preg_match( $pattern_image, $value ) ) {
					// Image is ID.
					return $value;
				} else {
					// Non-valid.
					return '';
				}
			} elseif ( 'checkbox' === $option_type || 'select' === $option_type ) {
				return $value;
			} elseif ( 'text' === $option_type && stristr( $id, '_class' ) ) {

				// Allowed characters.
				$pattern_font = '/^[0-9,a-zA-Z, ,",\',_,-]{1,80}$/s';

				if ( preg_match( $pattern_font, $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'text' === $option_type && stristr( $id, '_url' ) ) {

				// Allowed characters.
				$pattern_relative_path = '/^[^\s/$.?#]*[^\s]*$/is';

				if ( stristr( $value , 'http') ) {
					return esc_url( $value );
				} elseif ( preg_match( $pattern_relative_path, $value ) && 1000 > strlen( $value ) ) {
					return $value;
				} else {
					return '';
				}
			} elseif ( 'text' ) {
				return ;
			} elseif ( stristr( $id, '_onclick' ) ) {
				return esc_js( $value );
			} else {
				// All other cases.
				return esc_attr($value );
			}
		}
	}

	// return $value;
}
*/
