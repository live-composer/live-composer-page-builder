<?php

/**
 * Table of contents
 *
 * - dslc_ajax_add_modules_section ( Echo new modules section HTML )
 * - dslc_ajax_add_module ( Load the module's front end output)
 * - dslc_ajax_display_module_options ( Display options for a specific module )
 * - dslc_ajax_save_composer ( Save the composer code )
 * - dslc_ajax_save_draft_composer ( Save changes as draft )
 * - dslc_ajax_load_template ( Loads front end output of a specific template )
 * - dslc_ajax_import_template ( Loads front end output of an exported template )
 * - dslc_ajax_save_template ( Save template for future use )
 * - dslc_ajax_delete_template ( Deletes a saved template )
 * - REMOVED dslc_ajax_get_new_module_id ( Returns a new unique ID, similar to post ID )
 * - dslc_ajax_import_modules_section ( Loads front-end output for exported section )
 * - dslc_ajax_dm_module_defaults_code ( Returns the code to alter the defaults for the module options )
 * - dslc_ajax_save_preset ( Save module styling preset )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


/**
 * Add/display a new module section
 *
 * @since 1.0
 */
function dslc_ajax_add_modules_section( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// Allows devs to add classes.
		$filter_classes = array();
		$filter_classes = apply_filters( 'dslc_row_class', $filter_classes );
		$extra_classes = '';
		if ( count( $filter_classes ) > 0 ) {
			foreach ( $filter_classes as $filter_class ) {
				$extra_classes .= $filter_class . ' ';
			}
		}

		// The output.
		$empty_atts = array();

		$section_content = dslc_modules_area_front( $empty_atts, '' );
		$output = dslc_modules_section_front( $empty_atts, $section_content );

		// Set the output.
		$response['output'] = $output;

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Good night.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-add-modules-section', 'dslc_ajax_add_modules_section' );

/**
 * Add a new module OR re-render module output via ajax
 *
 * @since 1.0
 */
function dslc_ajax_add_module( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The ID of the module to add. ex: DSLC_Button
		$module_id = esc_attr( $_POST['dslc_module_id'] );

		if ( ! class_exists( $module_id ) ) {

			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			die();
		}

		$post_id = intval( $_POST['dslc_post_id'] );

		if ( isset( $_POST['dslc_preload_preset'] ) && 'enabled' === $_POST['dslc_preload_preset'] ) {

			$preload_preset = 'enabled';
		} else {

			$preload_preset = 'disabled';
		}

		/**
		 * The instance ID for this specific module
		 */

		// If it is not a new module ( already has ID )?
		if ( isset( $_POST['dslc_module_instance_id'] ) ) {

			$module_instance_id = esc_attr( $_POST['dslc_module_instance_id'] );

		} else {
			// If it is a new module ( no ID )?
			$module_instance_id = dslc_get_new_module_id();
		}

		// Instanciate the module class.
		$module_instance = new $module_id();

		// Generate settings.
		// Array $all_opts - has a structure of the module setting (not actual data).
		$all_opts = $module_instance->options();

		/**
		 * Array $module_settings - has all the module settings (actual data).
		 * Ex.: [css_bg_color] => rgb(184, 61, 61).
		 *
		 * Function dslc_module_settings creates the full module settings array
		 * based on default settings + current settings.
		 *
		 * Function dslc_module_settings get the custom settings for the current module
		 * form $_POST[ $option['id'] ].
		 */
		$module_settings = dslc_module_settings( $all_opts, $module_id );

		// Append ID to settings.
		$module_settings['module_instance_id'] = $module_instance_id;

		// Append post ID to settings.
		$module_settings['post_id'] = $post_id;

		// Load preset if there was no preset before.
		if ( 'enabled' === $preload_preset ) {

			$module_settings = apply_filters( 'dslc_filter_settings', $module_settings );
		}

		// Transform image ID to URL.
		global $dslc_var_image_option_bckp;
		$dslc_var_image_option_bckp = array();

		foreach ( $all_opts as $all_opt ) {

			if ( 'image' === $all_opt['type'] ) {

				if ( isset( $module_settings[ $all_opt['id'] ] ) && ! empty( $module_settings[ $all_opt['id'] ] ) && is_numeric( $module_settings[ $all_opt['id'] ] ) ) {

					$dslc_var_image_option_bckp[ $all_opt['id'] ] = $module_settings[ $all_opt['id'] ];
					$image_info = wp_get_attachment_image_src( $module_settings[ $all_opt['id'] ], 'full' );
					$module_settings[ $all_opt['id'] ] = $image_info[0];
				}
			}
		}

		// Module size.
		if ( isset( $_POST['dslc_m_size'] ) ) {

			$module_settings['dslc_m_size'] = $_POST['dslc_m_size'];
		} else {

			$module_settings['dslc_m_size'] = '12';
		}

		// Code before module output.
		ob_start();
			$module_instance->module_before( $module_settings );
			$output_start = ob_get_contents();
		ob_end_clean();

		// Module output.
		ob_start();
			$module_instance->output( $module_settings );
			$output_body = ob_get_contents();
		ob_end_clean();

		// Code after module output.
		ob_start();
			$module_instance->module_after( $module_settings );
			$output_end = ob_get_contents();
		ob_end_clean();

		$output_body = dslc_decode_shortcodes( $output_body );

		$response['output'] = $output_start . $output_body . $output_end;
		$response['output'] = do_shortcode( $response['output'] );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Good night.
		exit;
	}// End if().

} add_action( 'wp_ajax_dslc-ajax-add-module', 'dslc_ajax_add_module' );


/**
 * Display module options
 *
 * @since 1.0
 */
function dslc_ajax_display_module_options( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// This will hold the output.
		$response['output'] = '';
		$response['output_tabs'] = '';

		// The ID of the module to add.
		$module_id = esc_attr( $_POST['dslc_module_id'] );

		if ( ! class_exists( $module_id ) ) {

			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			die();
		}

		// Instanciate the module class.
		$module_instance = new $module_id();

		// Get the module options.
		$module_controls = $module_instance->options();

		// New object for options panel.
		$module_options_panel = new LC_Module_Options_Panel();

		ob_start();

		// Go through each option,
		// generate the control HTML and append to output.
		foreach ( $module_controls as $module_control ) {
			$module_option_control = new LC_Control( $module_options_panel );
			$module_option_control->set_control_options( $module_control );
			$module_option_control->output_option_control();
		}

		$output_fields = ob_get_contents();
		ob_end_clean();

		// Output Start.
		$output_start = '<div class="dslca-module-edit-options-wrapper dslc-clearfix">';

		// Output End.
		$output_end = '</div>';

		// Combine output.
		$response['output_tabs'] .= $module_options_panel->get_tabs_render();
		$response['output'] .= $output_start;
		$response['output'] .= $output_fields;
		$response['output'] .= $output_end;

		// Decode shortcodes for proper presentation.
		$response['output'] = dslc_decode_shortcodes( $response['output'] );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Auf wiedersehen.
		exit;
	}// End if().

} add_action( 'wp_ajax_dslc-ajax-display-module-options', 'dslc_ajax_display_module_options' );


/**
 * Save composer code
 *
 * @since 1.0
 */
function dslc_ajax_save_composer( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		$composer_code = '';

		// The composer code.
		if ( isset( $_POST['dslc_code'] ) ) {
			$composer_code = $_POST['dslc_code'];
		}

		// The ID of the post/page.
		$post_id = $_POST['dslc_post_id'];

		/**
		 * WordPress return false your try to update identical code.
		 * This problem cause frustration for the users, so we delete
		 * 'dslc_code' meta completely before saving it again
		 * to solve this problem.
		 */
		delete_post_meta( $post_id, 'dslc_code' );

		/**
		 * Function: json_decode
		 * Convert JSON data into an array
		 * to store in the custom field of the post as serialized data.
		 *
		 * Function: stripslashes
		 * jQuery Ajax esape all quotes automatically,
		 * so we need stripslashes in the code below.
		 */
		// $serialized_composer_code = json_decode( stripslashes( $composer_code ), true );
		$serialized_composer_code = stripslashes( $composer_code );

		/**
		 * Function: wp_slash
		 * By default WordPress deeply strips all the slashes when saves metadata.
		 * wp_slash compensate this effect by adding extra level of slahsed.
		 * See http://wordpress.stackexchange.com/a/129155.
		 */

		// Add/update the post/page with the composer code.
		if ( update_post_meta( $post_id, 'dslc_code', wp_slash( $serialized_composer_code ) ) ) {
			$response['status'] = 'success';
		} else {
			$response['status'] = 'failed';
		}

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Refresh cache.
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Delete draft code.
		delete_post_meta( $post_id, 'dslc_code_draft' );

		// The content for search.
		if ( isset( $_POST['dslc_content_for_search'] ) ) {
			$content_for_search = $_POST['dslc_content_for_search'];

			// Add/update the post/page with the content for search
			// wp_kses_post – Sanitize content for allowed HTML tags for post content.
			update_post_meta( $post_id, 'dslc_content_for_search', wp_kses_post( $content_for_search ) );
		}

		// Au revoir.
		exit;
	}// End if().
} add_action( 'wp_ajax_dslc-ajax-save-composer', 'dslc_ajax_save_composer' );

/**
 * Save composer code
 *
 * @since 1.0
 */
function dslc_ajax_save_draft_composer( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The composer code.
		$composer_code = $_POST['dslc_code'];

		// The ID of the post/page.
		$post_id = $_POST['dslc_post_id'];

		// Add/update the post/page with the composer code.
		if ( update_post_meta( $post_id, 'dslc_code_draft', $composer_code ) ) {
					$response['status'] = 'success';
		} else {
					$response['status'] = 'failed';
		}

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Refresh cache.
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Au revoir.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-save-draft-composer', 'dslc_ajax_save_draft_composer' );

/**
 * Load a template
 *
 * @since 1.0
 */
function dslc_ajax_load_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array that holds active templates.
		$templates = dslc_get_templates();

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The ID of the template to load.
		$template_id = $_POST['dslc_template_id'];

		// The code of the template to load.
		$template_code = stripslashes( $templates[ $template_id ]['code'] );

		$response['output'] = dslc_render_content( $template_code, true );
		$response['output'] = do_shortcode( $response['output'] );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Cheers.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-load-template', 'dslc_ajax_load_template' );



/**
 * Import a template
 *
 * @since 1.0
 */
function dslc_ajax_import_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The code of the template.
		$template_code = stripslashes( $_POST['dslc_template_code'] );

		$response['output'] = dslc_render_content( $template_code, true );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-import-template', 'dslc_ajax_import_template' );


/**
 * Save a custom template
 *
 * @since 1.0
 */
function dslc_ajax_save_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// Response to the AJAX call.
		$response = array();

		// To let the AJAX know how it went (all good for now).
		$response['status'] = 'success';

		// Get new template data.
		$template_title = stripslashes( $_POST['dslc_template_title'] );
		$template_id = strtolower( str_replace( ' ', '-', $template_title ) );
		$template_code = stripslashes( $_POST['dslc_template_code'] );

		// Get current templates.
		$templates = get_option( 'dslc_templates' );

		// No templates = make empty array OR templates found = unserialize.
		if ( false === $templates ) {
					$templates = array();
		} else {
					$templates = maybe_unserialize( $templates );
		}

		// Append new template to templates array.
		$templates[ $template_id ] = array(
			'title' => $template_title,
			'id' => $template_id,
			'code' => $template_code,
			'section' => 'user',
		);

		// Save new templates array to db.
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response.
		$response['output'] = $templates;

		// Encode response.
		$response_json = wp_json_encode( $response );

		// AJAX phone home.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Asta la vista.
		exit;
	}// End if().
} add_action( 'wp_ajax_dslc-ajax-save-template', 'dslc_ajax_save_template' );

/**
 * Delete a custom template
 *
 * @since 1.0
 */
function dslc_ajax_delete_template( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		$response = array();
		$response['status'] = 'success';

		// ID of the template to delete.
		$template_id = $_POST['dslc_template_id'];

		// Get all templates.
		$templates = maybe_unserialize( get_option( 'dslc_templates' ) );

		// Remove the template.
		unset( $templates[ $template_id ] );

		// Save new templates array to db.
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response.
		$response['output'] = $templates;

		// Encode response.
		$response_json = wp_json_encode( $response );

		// AJAX phone home.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Asta la vista.
		exit;

	}

} add_action( 'wp_ajax_dslc-ajax-delete-template', 'dslc_ajax_delete_template' );

/**
 * Import a modules section
 *
 * @since 1.0
 */
function dslc_ajax_import_modules_section( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The code of the modules section.
		$code_to_import = stripslashes( $_POST['dslc_modules_section_code'] );

		$response['output'] = dslc_render_content( $code_to_import, true );
		$response['output'] = do_shortcode( $response['output'] );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Bye bye.
		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-import-modules-section', 'dslc_ajax_import_modules_section' );


/**
 * Return the code to alter defaults for a module.
 * Used by the theme/plugin developers to the module defaults.
 *
 * @since 1.0
 */
function dslc_ajax_dm_module_defaults_code( $atts ) {
	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		$code = '';

		// The array we'll pass back to the AJAX call.
		$response = array();

		// The options serialized array.
		$modules_code = stripslashes( $_POST['dslc_modules_options'] );

		// Turn the string of settings into an array.
		$settings_new = dslc_json_decode( $modules_code );

		if ( is_array( $settings_new ) ) {

			// The ID of the module.
			$module_id = $settings_new['module_id'];

			// Instanciate the module class.
			$module_instance = new $module_id();

			// Module output.
			$settings = $module_instance->options();

			$code .= 'if ( ' . '$id' . " == '" . $module_id . "' ) {
	" . '$new_defaults = array(' . '
';

			// Fix settings when a new option added after a module is used.
			foreach ( $settings as $key => $setting ) {

				if ( isset( $settings_new[ $setting['id'] ] ) ) {

					if ( $settings_new[ $setting['id'] ] !== $settings[ $key ]['std'] ) {
						$code .= "		'" . $setting['id'] . "' => '" . $settings_new[ $setting['id'] ] . "',
";
					}
				} else {
					if ( isset( $settings[ $key ]['std'] ) && '' !== $settings[ $key ]['std'] ) {
						$code .= "		'" . $setting['id'] . "' => '" . "',
";
					}
				}
			}

			$code .= '	);
}';

		}// End if().

		// Get the front-end output.
		$response['output'] = $code;

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Bye bye.
		exit;
	}// End if().
} add_action( 'wp_ajax_dslc-ajax-dm-module-defaults', 'dslc_ajax_dm_module_defaults_code' );

/**
 * Save module styling preset
 * dslc_save_preset is located in functions.php
 *
 * @since 1.0
 */
function dslc_ajax_save_preset() {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		// The array we'll pass back to the AJAX call.
		$response = array();

		// Get the preset data.
		$preset_name = stripslashes( $_POST['dslc_preset_name'] );
		$preset_code_raw = stripslashes( $_POST['dslc_preset_code'] );
		$module_id = stripslashes( $_POST['dslc_module_id'] );

		if ( ! class_exists( $module_id ) ) {

			header( 'HTTP/1.1 400 Bad Request', true, 400 );
			die();
		}

		// Save.
		if ( dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) ) {

			$response['status'] = 'success';
		} else {

			$response['status'] = 'error';
		}

		// Live Composer > Settings > Performance.
		$response['preset_setting'] = dslc_get_option( 'lc_preset', 'dslc_plugin_options_performance' );

		// Encode response.
		$response_json = wp_json_encode( $response );

		// Send the response.
		header( 'Content-Type: application/json' );
		echo $response_json;

		// Bye bye.
		exit;
	}// End if().
} add_action( 'wp_ajax_dslc-ajax-save-preset', 'dslc_ajax_save_preset' );

/**
 * Ajax set hidden ( panel )
 */
function dslc_ajax_hidden_panel() {

	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		update_option( 'dslc_editor_messages_hidden', true );

		exit;
	}
} add_action( 'wp_ajax_dslc-ajax-hidden-panel', 'dslc_ajax_hidden_panel' );

/**
 * Ajax Clear Cache (Plugin Settings Tab).
 */
function dslc_ajax_clear_cache() {

	// Check Nonce.
	if ( ! wp_verify_nonce( $_POST['security']['nonce'], 'dslc-optionspanel-ajax' ) ) {
		wp_die( 'You do not have rights!' );
	}

	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		delete_transient( 'lc_cache' );
		exit;
	}
} add_action( 'wp_ajax_dslc_ajax_clear_cache', 'dslc_ajax_clear_cache' );

/**
 * Enable/Disable Premium Extension.
 */

function dslc_ajax_toggle_extension( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ):

	// The array we'll pass back to the AJAX call.
	$response = false;
	$extension_id = false;

	// The composer code.
	if ( isset( $_POST['extension'] ) ) {
		$extension_id = sanitize_key( $_POST['extension'] );
	}

	if ( $extension_id ) {
		// Send an action with request to toggle extension status.
		do_action( 'dslc_toggle_extension', $extension_id );

		// Check if status changed?
		$extensions = array();
		$extensions = apply_filters( 'dslc_extensions_meta', $extensions );

		foreach ($extensions as $id => $extension) {
			if ( $id === $extension_id ) {
				if ( $extension['active'] ) {
					$response = 'active';
				} else {
					$response = 'inactive';
				}
			}
		}
	}

	// Return response.
	echo $response;

	// Au revoir.
	wp_die();
	// exit;

	endif; // End if is_user_logged_in()...
} add_action( 'wp_ajax_dslc-ajax-toggle-extension', 'dslc_ajax_toggle_extension' );
