<?php

/**
 * Callback class
 *
 * AJAX should be:
 *
 * {
 * 	action: 'dslc-callback-request',
 *	dslc: 'active'
 * 	method: string
 * 	params: obj
 * }
 */
class DSLC_Callback {

	/**
	 * Variable to store callback data
	 *
	 * @var array
	 */
	public static $clbk = array();

	/**
	 * Echoes JSON-formatted data
	 */
	static function ret_json() {

		if ( ! is_array( self::$clbk ) ) {

			self::$clbk['status'] = 'false';
		}

		header( 'Content-Type: application/json' );
		echo wp_json_encode( self::$clbk );
		die();
	}

	/*
	 * Returns valid attach url
	 *
	static function get_invalid_attach_urlclbk( $params ) {

		if ( intval( $params['attach']['id'] ) > 0 ) {

			$path = get_attached_file( $params['attach']['id'] );

			if ( ! file_exists( $path ) ) {

				return false;
			}

			$attach_url = wp_get_attachment_image_src( $params['attach']['id'], 'full' )[0];
			$dslc_aq_resize = DSLC_Aq_Resize::getInstance();

			self::$clbk['attach'] = [];
			self::$clbk['attach']['url'] = $dslc_aq_resize->process(
		        $attach_url,
				@$_POST['params']['attach']['width'],
				@$_POST['params']['attach']['height']
			);

			self::$clbk['attach']['id'] = $params['attach']['id'];
			self::$clbk['attach']['filename'] = basename( $attach_url );
		}
	}
	*/

	/**
	 * Save composer code
	 *
	 * @since 1.0
	 */
	static function save_composer() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		// Allowed to do this?
		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* The composer code */
			$composer_code = $_POST['dslc_code'];

			/* The content for search */
			$content_for_search = $_POST['dslc_content_for_search'];

			/* The ID of the post/page */
			$post_id = $_POST['dslc_post_id'];

			delete_post_meta( $post_id, 'dslc_code' );
			delete_post_meta( $post_id, 'dslc_cache' );

			global $LC_Registry;

			$LC_Registry->set( 'removeAdminElementsFromEditor', true );

			/* Add/update the post/page with the composer code */
			if ( add_post_meta( $post_id, 'dslc_code', $composer_code ) ) {

	 			$dslc_cache = dslc_preformat_cache( do_shortcode( stripslashes( $composer_code ) ) );

				add_post_meta( $post_id, 'dslc_cache', base64_encode( $dslc_cache ) );
				$response['status'] = 'success';
			} else {

				$response['composer_update_post_meta'] = 'false';
				$response['status'] = 'failed';
			}

			// Add/update the post/page with the content for search
			// wp_kses_post – Sanitize content for allowed HTML tags for post content.
			if ( update_post_meta( $post_id, 'dslc_content_for_search', wp_kses_post( $content_for_search ) ) ) {

				$response['status'] = 'success';
			}

			/* Delete draft code */
			delete_post_meta( $post_id, 'dslc_code_draft' );

			/* Refresh cache */
			if ( function_exists( 'wp_cache_post_change' ) ) {
				$GLOBALS['super_cache_enabled'] = 1;
				wp_cache_post_change( $post_id );
			}

			/* Send the response */
			wp_send_json( $response );
		}
	}

	/**
	 * Save composer code
	 *
	 * @since 1.0
	 */
	static function save_draft_composer() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		// Allowed to do this?
		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* The composer code */
			$composer_code = $_POST['dslc_code'];

			/* The ID of the post/page */
			$post_id = $_POST['dslc_post_id'];

			/* Add/update the post/page with the composer code */
			if ( update_post_meta( $post_id, 'dslc_code_draft', $composer_code ) ) {

				$response['status'] = 'success';
			} else {

				$response['status'] = 'failed';
				$response['composer_draft_update_post_meta'] = 'false';
			}

			/* Refresh cache */
			if ( function_exists( 'wp_cache_post_change' ) ) {
				$GLOBALS['super_cache_enabled'] = 1;
				wp_cache_post_change( $post_id );
			}

			/* Send the response */
			wp_send_json( $response );
		}
	}

	/**
	 * Generates shortcode preview
	 *
	 * @since 2.0
	 */
	static function get_shortcode_preview() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		if ( ! empty( $_POST['code'] ) ) {

			ob_start();
			do_action( 'wp_enqueue_scripts' );
			ob_end_clean();

			global $wp_scripts;
			global $wp_styles;

			if ( isset( $wp_scripts ) ) {

				$wp_scripts->queue = array();
			}

			if ( isset( $wp_styles ) ) {

				$wp_styles->queue = array();
			}

			remove_action( 'wp_print_styles', 'print_emoji_styles' );

			ob_start();
			$content = dslc_preformat_cache( do_shortcode( stripslashes( $_POST['code'] ) ) );
			self::$clbk['content'] = do_shortcode( $content );
			ob_get_clean();

			$scripts_styles	= '';

			// Start the output buffer.
			ob_start();

			// Print scripts and styles.
			if ( isset( $wp_scripts ) ) {

				$wp_scripts->done[] = 'jquery';
				wp_print_scripts( $wp_scripts->queue );
			}

			if ( isset( $wp_styles ) ) {

				wp_print_styles( $wp_styles->queue );
			}

			// Return the scripts and styles markup.
			self::$clbk['assets'] = ob_get_clean();
			/* Send the response */
			wp_send_json( self::$clbk );
		}
	}

	/**
	 * Load a template
	 *
	 * @since 1.0
	 */
	static function load_template() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			/* The array that holds active templates */
			$templates = dslc_get_templates();

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* The ID of the template to load */
			$template_id = $_POST['dslc_template_id'];

			/* The code of the template to load */
			$template_code = $templates[ $template_id ]['code'];

			/* Apply for new ID */
			$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code );
			$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code );

			/* Get the front-end output */
			$response['output'] = do_shortcode( $template_code );

			/* Send the response */
			wp_send_json( $response );
		}
	}

	/**
	 * Import a template
	 *
	 * @since 1.0
	 */
	static function import_template() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* The code of the template */
			$template_code = $_POST['dslc_template_code'];

			delete_post_meta( $_POST['postId'], 'dslc_code' );
			add_post_meta( $_POST['postId'], 'dslc_code', $template_code );
			/* Apply for new ID */
			$template_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $template_code );
			$template_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $template_code );

			/* Get the front-end output */
			$response['output'] = do_shortcode( $template_code );

			/* Encode response */
			wp_send_json( $response );
		}
	}

	/**
	 * Save a custom template
	 *
	 * @since 1.0
	 */
	static function save_template() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

			/* Response to the AJAX call */
			$response = array();

			/* To let the AJAX know how it went (all good for now) */
			$response['status'] = 'success';

			/* Get new template data */
			$template_title = stripslashes( $_POST['dslc_template_title'] );
			$template_id = strtolower( str_replace( ' ', '-', $template_title ) );
			$template_code = stripslashes( $_POST['dslc_template_code'] );

			/* Get current templates */
			$templates = get_option( 'dslc_templates' );

			/* No templates = make empty array OR templates found = unserialize */
			if ( false === $templates ) {

				$templates = array();
			} else {

				$templates = maybe_unserialize( $templates );
			}

			/* Append new template to templates array */
			$templates[ $template_id ] = array(
				'title' => $template_title,
				'id' => $template_id,
				'code' => $template_code,
				'section' => 'user',
			);

			/* Save new templates array to db */
			update_option( 'dslc_templates', maybe_serialize( $templates ) );

			/* Generate response */
			$response['output'] = $templates;

			wp_send_json( $response );
		}
	}



	/**
	 * Delete a custom template
	 *
	 * @since 1.0
	 */
	static function delete_template() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		// Allowed to do this?
		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

			$response = array();
			$response['status'] = 'success';

			/* ID of the template to delete */
			$template_id = $_POST['dslc_template_id'];

			/* Get all templates */
			$templates = maybe_unserialize( get_option( 'dslc_templates' ) );

			/* Remove the template */
			unset( $templates[ $template_id ] );

			/* Save new templates array to db */
			update_option( 'dslc_templates', maybe_serialize( $templates ) );

			/* Generate response */
			$response['output'] = $templates;

			wp_send_json( $response );
		}
	}


	/**
	 * Import a modules section
	 *
	 * @since 1.0
	 */
	static function import_modules_section() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* The code of the modules section */
			$modules_code = stripslashes( $_POST['dslc_modules_section_code'] );

			/* Apply for new ID */
			$modules_code = str_replace( '[dslc_module ', '[dslc_module give_new_id="true" ', $modules_code );
			$modules_code = str_replace( '[dslc_module]', '[dslc_module give_new_id="true"]', $modules_code );

			/* Get the front-end output */
			$response['output'] = do_shortcode( $modules_code );

			wp_send_json( $response );
		}
	}

	/**
	 * Save module styling preset
	 * dslc_save_preset is located in functions.php
	 *
	 * @since 1.0
	 */
	static function save_preset() {

		check_ajax_referer( 'wp_dslc_ajax_nonce', '_wp_nonce' );

		// Allowed to do this?
		if ( current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			/* The array we'll pass back to the AJAX call */
			$response = array();

			/* Get the preset data */
			$preset_name = stripslashes( $_POST['dslc_preset_name'] );
			$preset_code_raw = stripslashes( $_POST['dslc_preset_code'] );
			$module_id = stripslashes( $_POST['dslc_module_id'] );

			/* Save */
			if ( dslc_save_preset( $preset_name, $preset_code_raw, $module_id ) ) {

				$response['status'] = 'success';
			} else {

				$response['status'] = 'error';
			}

			wp_send_json( $response );
		}
	}

	/**
	 * Register actions
	 *
	 * @since 2.0
	 */
	static function init() {

		add_action( 'wp_ajax_dslc-ajax-save-preset', [ __CLASS__, 'save_preset' ] );
		add_action( 'wp_ajax_dslc-ajax-import-modules-section', [ __CLASS__, 'import_modules_section' ] );
		add_action( 'wp_ajax_dslc-ajax-delete-template', [ __CLASS__, 'delete_template' ] );
		add_action( 'wp_ajax_dslc-ajax-save-template', [ __CLASS__, 'save_template' ] );
		add_action( 'wp_ajax_dslc-ajax-import-template', [ __CLASS__, 'import_template' ] );
		add_action( 'wp_ajax_dslc-ajax-load-template', [ __CLASS__, 'load_template' ] );
		add_action( 'wp_ajax_dslc-ajax-save-draft-composer', [ __CLASS__, 'save_draft_composer' ] );
		add_action( 'wp_ajax_dslc-ajax-save-composer', [ __CLASS__, 'save_composer' ] );
		add_action( 'wp_ajax_dslc-preview-shortcode', [ __CLASS__, 'get_shortcode_preview' ] );
	}
}

/* Register actions */
DSLC_Callback::init();
