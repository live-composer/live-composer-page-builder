<?php

/**
 * Table of Contents
 *
 * - dslc_load_translation ( Load the text domain )
 * - dslc_register_modules ( Register default module and calls action used to register custom modules )
 * - dslc_register_module ( Register a module )
 * - dslc_unregister_module ( Unregister a module )
 * - dslc_module_settings ( Get settings of a specific module )
 * - dslc_generate_custom_css ( Generate module CSS )
 * - dslc_get_new_module_id ( Get new unique ID )
 * - dslc_register_template ( Register a template )
 * - dslc_unregister_template ( Unregister a template )
 * - dslc_body_class ( Add custom classes to the body tag )
 * - dslc_set_defaults ( Replaces the default option values )
 * - dslc_is_module_active ( Check if a specific module is active - can be disabled in LC settings )
 * - dslc_save_preset ( Save a preset )
 * - dslc_is_editor_active ( Check if the editor is currently active )
 * - dslc_get_code ( Gets LC code of a specific post/page )
 */

/**
 * Load text domain
 *
 * @since 1.0
 */

function dslc_load_translation() {

	//load_plugin_textdomain( 'live-composer-page-builder', false, DS_LIVE_COMPOSER_DIR_NAME . '/lang/' );

} add_action( 'init', 'dslc_load_translation' );

/**
 * Registers default and custom modules
 *
 * @since 1.0
 */

function dslc_register_modules() {

	// Register default modules
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
	dslc_register_module( 'DSLC_Accordion' );
	dslc_register_module( 'DSLC_Separator' );
	dslc_register_module( 'DSLC_Text_Simple' );
	dslc_register_module( 'DSLC_Html' );
	dslc_register_module( 'DSLC_Posts' );
	dslc_register_module( 'DSLC_Blog' );
	dslc_register_module( 'DSLC_Projects' );
	dslc_register_module( 'DSLC_Galleries' );
	dslc_register_module( 'DSLC_Downloads' );
	dslc_register_module( 'DSLC_Testimonials' );
	dslc_register_module( 'DSLC_Staff' );
	dslc_register_module( 'DSLC_Partners' );
	dslc_register_module( 'DSLC_WooCommerce_Products' );
	dslc_register_module( 'DSLC_Social' );
	dslc_register_module( 'DSLC_Notification' );
	dslc_register_module( 'DSLC_Button' );
	dslc_register_module( 'DSLC_Image' );
	dslc_register_module( 'DSLC_Tabs' );
	dslc_register_module( 'DSLC_Progress_Bars' );
	dslc_register_module( 'DSLC_Sliders' );
	dslc_register_module( 'DSLC_Info_Box' );	
	dslc_register_module( 'DSLC_Widgets' );
	dslc_register_module( 'DSLC_Icon' );
	dslc_register_module( 'DSLC_Navigation' );

	// Hook to register custom modules
	do_action( 'dslc_hook_register_modules' );
	do_action( 'dslc_hook_unregister_modules' );

} add_action( 'init', 'dslc_register_modules', 1 );


/**
 * Register module
 *
 * @since 1.0
 */

function dslc_register_module( $module_id ) {

	// Array that holds all active modules
	global $dslc_var_modules;

	// Instanciate the module class
	$module_instance = new $module_id();

	// Icon
	if ( ! isset( $module_instance->module_icon) )
		$module_instance->module_icon = '';

	// Category/Origin
	if ( ! isset( $module_instance->module_category) )
		$module_instance->module_category = 'other';

	// If the array ID not taken
	if ( ! isset( $dslc_var_modules[$module_id] ) ) {

		// Append new module to the global array
		$dslc_var_modules[ $module_id ] = array(
			'id' => $module_id,
			'title' => $module_instance->module_title,
			'icon' => $module_instance->module_icon,
			'origin' => $module_instance->module_category
		);

	}

}

/**
 * Unregister module
 *
 * @since 1.0
 */

function dslc_unregister_module( $module_id ) {

	// Array that holds all active modules
	global $dslc_var_modules;

	// Remove module from array
	unset( $dslc_var_modules[ $module_id ] );

}

/**
 * Module Settings
 *
 * Generates settings based on default values and user values
 *
 * @since 1.0
 */

function dslc_module_settings( $options, $custom = false ) {

	// Array to hold the settings
	$settings = array();		

	// Go through all options
	foreach( $options as $option ) {

		// If value set use it
		if ( isset( $_POST[ $option['id'] ] ) ) {
			$settings[ $option['id'] ] = $_POST[ $option['id'] ]; 
		// If value not set use default
		} else {
			$settings[ $option['id'] ] = $option['std'];
		}

	}

	return $settings;

}

/**
 * Generates module CSS
 *
 * @since 1.0
 */

function dslc_generate_custom_css( $options_arr, $settings, $restart = false ) {

	$css_output = '';
	global $dslc_googlefonts_array;
	$googlefonts_output = '';
	$regular_fonts = array( "Georgia", "Times", "Arial", "Lucida Sans Unicode", "Tahoma", "Trebuchet MS", "Verdana", "Helvetica" );
	$organized_array = array();

	global $dslc_css_fonts;
	global $dslc_css_style;

	$important_append = '';
	$force_important = dslc_get_option( 'lc_force_important_css', 'dslc_plugin_options' );
	if ( $force_important == 'enabled' )
		$important_append = ' !important';

	if ( isset( $_GET['dslc'] ) && $_GET['dslc'] == 'active' ) {
		$important_append = '';
	}

	if ( $restart == true ) {

		$dslc_css_fonts = '';
		$dslc_css_style = '';

	}

	// Go through array of options
	foreach ( $options_arr as $option_arr ) {

		// Fix for "alter_defaults" and responsive tablet state
		if ( $option_arr['id'] == 'css_res_t' && $option_arr['std'] == 'enabled' && ! isset( $settings['css_res_t'] ) )
			$settings['css_res_t'] = 'enabled';

		// Fix for "alter_defaults" and responsive phone state
		if ( $option_arr['id'] == 'css_res_p' && $option_arr['std'] == 'enabled' && ! isset( $settings['css_res_p'] ) )
			$settings['css_res_p'] = 'enabled';

		// If option type is done with CSS and option is set
		if ( isset( $option_arr['affect_on_change_el'] ) && isset( $option_arr['affect_on_change_rule'] ) ) {

			// Default
			if ( ! isset( $settings[$option_arr['id']] ) )
				$settings[$option_arr['id']] = $option_arr['std'];

			// Extension (px, %, em...)
			$ext = ' ';
			if ( isset( $option_arr['ext'] ) )
				$ext = $option_arr['ext'];

			// Prepend
			$prepend = '';
			if ( isset( $option_arr['prepend'] ) )
				$prepend = $option_arr['prepend'];

			// Append
			$append = '';
			if ( isset( $option_arr['append'] ) )
				$append = $option_arr['append'];

			if ( $option_arr['type'] == 'image' ) {
				$prepend = 'url("';
				$append = '")';
			}

			// Get element and CSS rule
			$affect_rule_raw = $option_arr['affect_on_change_rule'];
			$affect_rules_arr = explode( ',', $affect_rule_raw );

			// Affect Element
			$affect_el = '';
			$affect_els_arr = explode( ',', $option_arr['affect_on_change_el'] );
			$count = 0;
			foreach ( $affect_els_arr as $affect_el_arr) {
				$count++;
				if ( $count > 1 ) {
					$affect_el .= ',';
				}

				if ( isset( $option_arr['section'] ) && $option_arr['section'] == 'responsive' ) {

					switch ( $option_arr['tab'] ) {
						case __( 'tablet', 'live-composer-page-builder' ):
							if ( isset( $settings['css_res_t'] ) && $settings['css_res_t'] == 'enabled' ) 
								$affect_el .= 'body.dslc-res-tablet #dslc-content #dslc-module-' . $settings['module_instance_id'] . ' ' . $affect_el_arr;		
							break;
						case __( 'phone', 'live-composer-page-builder' ):
							if ( isset( $settings['css_res_p'] ) && $settings['css_res_p'] == 'enabled' )
								$affect_el .= 'body.dslc-res-phone #dslc-content #dslc-module-' . $settings['module_instance_id'] . ' ' . $affect_el_arr;		
							break;
					}

				} else {
					$affect_el .= '#dslc-content #dslc-module-' . $settings['module_instance_id'] . ' ' . $affect_el_arr;
				}

			}

			// Checkbox ( CSS )
			if ( $option_arr['type'] == 'checkbox' && $option_arr['refresh_on_change'] == false ) {

				$checkbox_val = '';
				$checkbox_arr = explode( ' ', trim( $settings[$option_arr['id']] ) );
				
				if ( in_array( 'top', $checkbox_arr ) )
					$checkbox_val .= 'solid ';
				else
					$checkbox_val .= 'none ';

				if ( in_array( 'right', $checkbox_arr ) )
					$checkbox_val .= 'solid ';
				else
					$checkbox_val .= 'none ';

				if ( in_array( 'bottom', $checkbox_arr ) )
					$checkbox_val .= 'solid ';
				else
					$checkbox_val .= 'none ';

				if ( in_array( 'left', $checkbox_arr ) )
					$checkbox_val .= 'solid ';
				else
					$checkbox_val .= 'none ';

				$settings[$option_arr['id']] = $checkbox_val;
				
			}

			// Colors (transparent if empy )
			if ( $settings[$option_arr['id']] == '' && ( $option_arr['affect_on_change_rule'] == 'background' || $option_arr['affect_on_change_rule'] == 'background-color' ) ) {

				$settings[$option_arr['id']] = 'transparent';

			}

			foreach ( $affect_rules_arr as $affect_rule ) {
				$organized_array[$affect_el][$affect_rule] = $prepend . $settings[$option_arr['id']] . $ext . $append;
			}

		}

		// If option type is font
		if ( $option_arr['type'] == 'font' ) {

			if ( ! in_array( $settings[$option_arr['id']], $dslc_googlefonts_array ) && ! in_array( $settings[$option_arr['id']], $regular_fonts ) ) 
				$dslc_googlefonts_array[] = $settings[$option_arr['id']];

		}

	}

	if ( count( $organized_array ) > 0 ) {

		foreach ( $organized_array as $el => $rules ) {

			$css_output .= $el . ' { '; 

				foreach ( $rules as $rule => $value ) {

					if ( trim( $value ) != '' && trim( $value ) != 'url(" ")' ) {

						$css_output .= $rule . ' : ' . $value . $important_append . '; ';

					}

				}

			$css_output .= ' } ';

		}

	}

	$dslc_css_style .= $css_output;

}

/**
 * Returns an unique module ID
 *
 * @since 1.0
 */

function dslc_get_new_module_id() {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// Get current count
		$module_id_count = get_option( 'dslc_module_id_count' );

		// Increment by one
		$module_instance_id = $module_id_count + 1;

		// Update the count
		update_option( 'dslc_module_id_count', $module_instance_id );

		// Return new ID
		return $module_instance_id;

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

	// Global variable that holds templates information
	global $dslc_var_templates;

	// If an array supplied proceed
	if ( is_array( $template ) ) {

		// If the array ID not taken
		if ( ! isset( $dslc_var_templates[$template['id']] ) ) {

			// Add the template to the templates array
			$dslc_var_templates[$template['id']] = $template;

		}

	}

}

/**
 * Unregister a template
 *
 * @since 1.0
 */

function dslc_unregister_template( $template_ID ) {

	// Global variable that holds templates information
	global $dslc_var_templates;

	// If the template exists 
	if ( isset( $dslc_var_templates[$template_ID] ) ) {

		// Remove the template from the templates array
		unset( $dslc_var_templates[$template_ID] );

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
		$template_ID = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );
		if ( $template_ID ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_author() ) {
		$template_ID = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		if ( $template_ID ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_search() ) {
		$template_ID = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
		if ( $template_ID ) {
			$proceed = true;
			$has_lc_content = true;
		}
	}

	if ( is_singular() )
		$proceed = true;

	if ( $proceed == false )
		return $classes;

	// If page in LC mode, force the class
	if ( isset( $_GET['dslc'] ) && $_GET['dslc'] == 'active' )
		$has_lc_content = true;

	
	// Still nothing, let's check if there's real LC content on the page
	if ( ! $has_lc_content ) {
		
		// Get the dslc_code custom field
		$dslc_code = get_post_meta( get_the_ID(), 'dslc_code', true );

		// If there is LC content, allow the class
		if ( $dslc_code )
			$has_lc_content = true;

	}

	// Still nothing, let's check if it's a post and has an LC template
	if ( ! $has_lc_content && is_singular( $dslc_post_types ) ) {

		// Get the ID of the template
		$template_ID = dslc_st_get_template_ID( get_the_ID() );

		// If tempalte exists, allow the class
		if ( $template_ID )
			$has_lc_content = true;

	}

	// Let's check if it has LC powered header/footer
	$header_footer = dslc_hf_get_ID( get_the_ID() );
	if ( $header_footer['header'] || $header_footer['footer'] ) {
		$has_lc_header_footer = true;
	}

	// If has LC content append class
	if ( $has_lc_content || $has_lc_header_footer )
		$classes[] = 'dslc-page';

	if ( $has_lc_content )
		$classes[] = 'dslc-page-has-content';

	if ( $has_lc_header_footer )
		$classes[] = 'dslc-page-has-hf';

	// If responsive disabled append class
	if ( defined( 'DS_LIVE_COMPOSER_RESPONSIVE' ) && ! DS_LIVE_COMPOSER_RESPONSIVE )
		$classes[] = 'dslc-res-disabled';

	// Return the modified array
	return $classes;

} add_filter( 'body_class', 'dslc_body_class' );

/**
 * Replaces the default option values
 *
 * @since 1.0
 */

function dslc_set_defaults( $new_defaults, $options ) {

	// If no new defaults, pass it back and stop
	if ( ! $new_defaults ) 
		return $options;

	// Generate an array of options IDs to alter
	$def_ids = array();
	foreach ( $new_defaults as $key => $val ) {
		$def_ids[] = $key;
	}

	// Go through all the options
	foreach ( $options as $opt_key => $option ) {

		if ( in_array( $option['id'], $def_ids ) ) {
			$options[$opt_key]['std'] = $new_defaults[$option['id']];
		}

	}
	
	// Pass back the options array
	return $options;

}

/**
 * Check if module is active
 */

function dslc_is_module_active( $module_ID, $check_registered = false ) {

	global $dslc_var_modules;
	
	if ( dslc_get_option( $module_ID, 'dslc_plugin_options_features' ) == 'disabled' )
		return false;
	elseif ( $check_registered == true && ! isset( $dslc_var_modules[$module_ID]  ) )
		return false;
	else
		return true;

}

/**
 * Save Preset
 *
 * @since 1.0
 */

function dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) {

	$preset_id = strtolower( str_replace( ' ', '-', $preset_name) );

	// Clean up ( step 1 - get data )
	$preset_code_raw = maybe_unserialize( base64_decode( $preset_code_raw ) );
	$preset_code = array();
	$module = new $module_id();
	$module_options = $module->options();

	// Clean up ( step 2 - generate correct preset code )
	foreach( $module_options as $module_option ) {

		// allowed to have a preset
		if ( ! isset( $module_option['include_in_preset'] ) || $module_option['include_in_preset'] == true ) { 

			// modules section not set or module section not functionality
			if ( ( isset( $module_option['section'] ) && $module_option['section'] !== 'functionality' ) && ( ! isset( $module_option['visibility'] ) || $module_option['visibility'] !== 'hidden' ) ) {
				
				if ( isset ( $preset_code_raw[$module_option['id']] ) ) {
					$preset_code[$module_option['id']] = $preset_code_raw[$module_option['id']];
				}
			}

		}
		
	}

	// Clean up ( step 3 - final )
	$preset_code = base64_encode( maybe_serialize( $preset_code ) );

	// Get current presets
	$presets = get_option( 'dslc_presets' );

	// No presets = make empty array OR presets found = unserialize
	if ( $presets === false )
		$presets = array();
	else
		$presets = maybe_unserialize( $presets );

	// Append new preset to presets array
	$presets[$preset_id] = array(
		'title' => $preset_name,
		'id' => $preset_id,
		'code' => $preset_code,
		'module' => $module_id
	);

	// Save new presets array to db and set the status
	if ( update_option( 'dslc_presets', maybe_serialize( $presets ) ) )
		return true;
	else
		return false;

}

/**
 * Check if editor is currently active
 *
 * @since 1.0
 */

function dslc_is_editor_active( $capability = 'save') {

	// Check for saving capability 
	if ( $capability == 'save' ) {
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY_SAVE;
	// Check for access capability ( can use editor but can't publish changes )
	} elseif ( $capability == 'access' ) {
		$capability_check = DS_LIVE_COMPOSER_CAPABILITY;
	}

	// Check if editor is activated and current user can use the editor
	if ( DS_LIVE_COMPOSER_ACTIVE && current_user_can( $capability_check ) ) {
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
 * @param int     $postID ID of the post/page. Default false.
 * @param bool    $draft If true will check for draft first. Default true. 
 * @return string The LC code for the post/page. Empty string if no LC code.
 */
function dslc_get_code( $postID = false, $draft = true ) {

	// This will be returned at the end
	$code = '';

	// If post ID not supplied ask WordPress
	if ( ! $postID ) {
		$postID = get_the_ID();
	}

	// If still no ID return false
	if ( ! $postID ) {
		return false;
	}

	// If draft allowed ( func parameter ) and editor currently active and there is a draft version
	if ( $draft && dslc_is_editor_active() && get_post_meta( $postID, 'dslc_code_draft', true ) ) {

		// Load draft LC code
		$code = get_post_meta( $postID, 'dslc_code_draft', true );

	} else {

		// Load regular ( current ) LC code
		$code = get_post_meta( $postID, 'dslc_code', true );

	}

	// Pass it back
	return $code;

}