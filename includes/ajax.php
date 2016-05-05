<?php

/**
 * Table of contents
 * - dslc_ajax_save_composer ( Save the composer code )
 * - dslc_ajax_save_draft_composer ( Save changes as draft )
 * - dslc_ajax_load_template ( Loads front end output of a specific template )
 * - dslc_ajax_import_template ( Loads front ened output of an exported template )
 * - dslc_ajax_save_template ( Save template for future use )
 * - dslc_ajax_delete_template ( Deletes a saved template )
 * - dslc_ajax_get_new_module_id ( Returns a new unique ID, similar to post ID )
 * - dslc_ajax_import_modules_section ( Loads front-end output for exported section )
 * - dslc_ajax_dm_module_defaults_code ( Returns the code to alter the defaults for the module options )
 * - dslc_ajax_save_preset ( Save module styling preset )
 */

/**
 * Save composer code
 *
 * @since 1.0
 */

function dslc_ajax_save_composer( $atts )
{
	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call
		$response = array();
		// The composer code
		$composer_code = $_POST['dslc_code'];

		// The content for search
		$content_for_search = $_POST['dslc_content_for_search'];

		// The ID of the post/page
		$post_id = $_POST['dslc_post_id'];

		delete_post_meta( $post_id, 'dslc_code' );
		delete_post_meta( $post_id, 'dslc_cache' );

		global $LC_Registry;

		$LC_Registry->set( 'removeAdminElementsFromEditor', true );

		// Add/update the post/page with the composer code
		if ( add_post_meta( $post_id, 'dslc_code', $composer_code ) ) {

 			$dslc_cache = dslc_preformat_cache( do_shortcode( stripslashes( $composer_code ) ) );

			add_post_meta( $post_id, 'dslc_cache', base64_encode( $dslc_cache ) );
			$response['status'] = 'success';
		}else{

			$response['composer_update_post_meta'] = 'false';
			$response['status'] = 'failed';
		}

		// Add/update the post/page with the content for search
		// wp_kses_post – Sanitize content for allowed HTML tags for post content.
		if ( update_post_meta( $post_id, 'dslc_content_for_search', wp_kses_post($content_for_search) ) )

			$response['status'] = 'success';
		}

		// Delete draft code
		delete_post_meta( $post_id, 'dslc_code_draft' );

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Refresh cache
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Au revoir
		exit;

}
add_action( 'wp_ajax_dslc-ajax-save-composer', 'dslc_ajax_save_composer' );

/**
 * Preformat text in cache
 */
function dslc_preformat_cache( $text )
{
	$concatGlue = "|" . mt_rand(0, 999999) . "|";

	// Preformat pieces
	preg_match_all( "'{dslc_format}(.*?){\/dslc_format}'si", $text, $preformatPieces );

	$formattedText = '';
	$cnt = 0;
	foreach( $preformatPieces[1] as $piece)
	{
		$formattedText .= '<div class="dslc-format-delimiter"></div>' . $piece;
		$cnt++;
	}

	$formattedText = wptexturize( $formattedText );
	$formattedText = convert_smilies( $formattedText );
	$formattedText = wpautop( $formattedText );
	$formattedText = shortcode_unautop( $formattedText );

	$ungluedPieces = explode( '<div class="dslc-format-delimiter"></div>', $formattedText );
	array_shift( $ungluedPieces );

	$text = str_replace( $preformatPieces[1], $ungluedPieces, $text );
	$text = preg_replace( ["/{dslc_format}/", "/{\/dslc_format}/", "/formattedtext=\"\"/", "/class=\"\"/"], '', $text );

	return $text;
}

/**
 * Save composer code
 *
 * @since 1.0
 */

function dslc_ajax_save_draft_composer( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// The array we'll pass back to the AJAX call
		$response = array();

		// The composer code
		$composer_code = $_POST['dslc_code'];

		// The ID of the post/page
		$post_id = $_POST['dslc_post_id'];

		// Add/update the post/page with the composer code
		if ( update_post_meta( $post_id, 'dslc_code_draft', $composer_code ) )
			$response['status'] = 'success';
		else
			$response['status'] = 'failed';
			$response['composer_draft_update_post_meta'] = 'false';

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Refresh cache
		if ( function_exists( 'wp_cache_post_change' ) ) {
			$GLOBALS['super_cache_enabled'] = 1;
			wp_cache_post_change( $post_id );
		}

		// Au revoir
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

		// The array that holds active templates
		$templates = dslc_get_templates();

		// The array we'll pass back to the AJAX call
		$response = array();

		// The ID of the template to load
		$template_id = $_POST['dslc_template_id'];

		// The code of the template to load
		$template_code = $templates[$template_id]['code'];

		// Apply for new ID
		$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code);
		$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code);

		// Get the front-end output
		$response['output'] = do_shortcode ( $template_code );

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Cheers
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


		// The array we'll pass back to the AJAX call
		$response = array();

		// The code of the template
		$template_code = $_POST['dslc_template_code'];

		delete_post_meta( $_POST['postId'], 'dslc_code' );
		add_post_meta( $_POST['postId'], 'dslc_code', $template_code);
		/*// Apply for new ID
		$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code);
		$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code);

		// Get the front-end output
		$response['output'] = do_shortcode ( $template_code );

		// Encode response
		$response_json = json_encode( $response );

		// Send the response*/
		header( "Content-Type: application/json" );
		echo json_encode(['result' => 'success']);

		// Bye bye
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

		// Response to the AJAX call
		$response = array();

		// To let the AJAX know how it went (all good for now)
		$response['status'] = 'success';

		// Get new template data
		$template_title = stripslashes( $_POST['dslc_template_title'] );
		$template_id = strtolower( str_replace( ' ', '-', $template_title) );
		$template_code = stripslashes( $_POST['dslc_template_code'] );

		// Get current templates
		$templates = get_option( 'dslc_templates' );

		// No templates = make empty array OR templates found = unserialize
		if ( $templates === false )
			$templates = array();
		else
			$templates = maybe_unserialize( $templates );

		// Append new template to templates array
		$templates[$template_id] = array(
			'title' => $template_title,
			'id' => $template_id,
			'code' => $template_code,
			'section' => 'user'
		);

		// Save new templates array to db
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response
		$response['output'] = $templates;

		// Encode response
		$response_json = json_encode( $response );

		// AJAX phone home
		header( "Content-Type: application/json" );
		echo $response_json;

		// Asta la vista
		exit;

	}

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

		// ID of the template to delete
		$template_id = $_POST['dslc_template_id'];

		// Get all templates
		$templates = maybe_unserialize( get_option( 'dslc_templates' ) );

		// Remove the template
		unset( $templates[$template_id] );

		// Save new templates array to db
		update_option( 'dslc_templates', maybe_serialize( $templates ) );

		// Generate response
		$response['output'] = $templates;

		// Encode response
		$response_json = json_encode( $response );

		// AJAX phone home
		header( "Content-Type: application/json" );
		echo $response_json;

		// Asta la vista
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

		// The array we'll pass back to the AJAX call
		$response = array();

		// The code of the modules section
		$modules_code = stripslashes( $_POST['dslc_modules_section_code'] );

		// Apply for new ID
		$modules_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $modules_code);
		$modules_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $modules_code);

		// Get the front-end output
		$response['output'] = do_shortcode ( $modules_code );

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye
		exit;

	}

} add_action( 'wp_ajax_dslc-ajax-import-modules-section', 'dslc_ajax_import_modules_section' );

/**
 * Return the code to alter defaults for a module
 *
 * @since 1.0
 */

function dslc_ajax_dm_module_defaults_code( $atts ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		$code = '';

		// The array we'll pass back to the AJAX call
		$response = array();

		// The options serialized array
		$modules_code = stripslashes( $_POST['dslc_modules_options'] );

		// Turn the string of settings into an array
		$settings_new = maybe_unserialize( base64_decode( $modules_code ) );

		if ( is_array( $settings_new ) ) {

			// The ID of the module
			$module_id = $settings_new['module_id'];

			// Instanciate the module class
			$module_instance = new $module_id();

			// Module output
			$settings = $module_instance->options();

			$code .= "if ( " . '$id' ." == '" . $module_id . "' ) {

				". '$new_defaults = array(' . "
			";


			// Fix settings when a new option added after a module is used
			foreach( $settings as $key => $setting ) {

				if ( isset( $settings_new[ $setting['id'] ] ) ) {

					if ( $settings_new[ $setting['id'] ] != $settings[$key]['std'] ) {
						$code .= "		'" . $setting['id'] . "' => '" . $settings_new[ $setting['id'] ] . "',";
					}

				}

			}

			$code .= '	);}';

		}

		// Get the front-end output
		$response['output'] = $code;

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye
		exit;
	}

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

		// The array we'll pass back to the AJAX call
		$response = array();

		// Get the preset data
		$preset_name = stripslashes( $_POST['dslc_preset_name'] );
		$preset_code_raw = stripslashes( $_POST['dslc_preset_code'] );
		$module_id = stripslashes( $_POST['dslc_module_id'] );

		// Save
		if ( dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) )
			$response['status'] = 'success';
		else
			$response['status'] = 'error';

		// Encode response
		$response_json = json_encode( $response );

		// Send the response
		header( "Content-Type: application/json" );
		echo $response_json;

		// Bye bye
		exit;

	}

} add_action( 'wp_ajax_dslc-ajax-save-preset', 'dslc_ajax_save_preset' );