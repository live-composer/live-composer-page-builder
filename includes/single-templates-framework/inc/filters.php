<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

function dslc_st_template_switch() {

	global $post;
	global $dslc_post_types;

	// If there's no post, stop execution.
	if ( ! isset( $post ) )
		return;

	// If the post is not supporting templates or it's not a template itself, stop execution.
	// @todo: Rewrite this condition.
	if ( is_singular( $dslc_post_types ) || is_singular( 'dslc_templates' ) ) { } else {
		return;
	}

	// If the currently shown page is the template CPT.
	if ( $post->post_type == 'dslc_templates' ) {

		// Get template base
		$template_base = get_post_meta( $post->ID, 'dslc_template_base', true );

		// If custom base
		if ( $template_base == 'custom' ) {

			// The template filename
			$templatefilename = 'dslc-single.php';

			// If the template file is in the theme
			if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {

				$return_template = TEMPLATEPATH . '/' . $templatefilename;

			// If not in the theme use the default one from the plugin
			} else {

				$return_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-single.php';
			}

			// Redirect
			include( $return_template );

			// Bye bye
        	exit();

		}

	}

	// If the currently shown page is actually a post we should filter
	if ( in_array( $post->post_type, $dslc_post_types ) ) {

		// Get template ID
		$template_ID = dslc_st_get_template_id( $post->ID );

		// If the post has specific template, set it in variable
		if ( $template_ID ) {

			$template_base = get_post_meta( $template_ID, 'dslc_template_base', true );

		// If the post does not have a specific template, just use regular base from theme
		} else {
			$template_base = 'theme';
		}

		if ( $template_base == 'custom' ) {

			// The template filename
			$templatefilename = 'dslc-single.php';

			// If the template file is in the theme
			if ( file_exists( TEMPLATEPATH . '/' . $templatefilename ) ) {

				$return_template = TEMPLATEPATH . '/' . $templatefilename;

			// If not in the theme use the default one from the plugin
			} else {

				$return_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-single.php';
			}

			// Redirect.
			include( $return_template );

			// Bye bye.
			exit();

		}
	}

} add_action( 'template_redirect', 'dslc_st_template_switch' );

/**
 * Add columns to the Templates Listing table.
 */
function dslc_templates_col_title( $defaults ) {

	unset( $defaults['date'] );
	$defaults['dslc_templates_col_cpt'] = 'Post Type';
	$defaults['dslc_templates_col_default'] = '&nbsp;';
	return $defaults;

}

function dslc_templates_col_content( $column_name, $post_ID ) {

	if ( $column_name == 'dslc_templates_col_cpt' ) {
		$post_types = get_post_meta( $post_ID, 'dslc_template_for');

		foreach ($post_types as $key => $value) {
			if ( '404_page' === $value) {
				$post_types[$key] = __('404 – Page Not Found', 'live-composer-page-builder' );
			} elseif ( 'search_results' === $value) {
				$post_types[$key] = __('Search Results', 'live-composer-page-builder' );
			} elseif ( 'author' === $value) {
				$post_types[$key] = __('Author Archive Page', 'live-composer-page-builder' );
			} elseif ( 'post' === $value) {
				$post_types[$key] = __('Blog Post', 'live-composer-page-builder' );
			} elseif ( 'dslc_projects' === $value) {
				$post_types[$key] = __('Projects', 'live-composer-page-builder' );
			} elseif ( 'dslc_staff' === $value) {
				$post_types[$key] = __('Staff', 'live-composer-page-builder' );
			} elseif ( 'dslc_partners' === $value) {
				$post_types[$key] = __('Partners', 'live-composer-page-builder' );
			} elseif ( 'dslc_downloads' === $value) {
				$post_types[$key] = __('Downloads', 'live-composer-page-builder' );
			} elseif ( 'dslc_galleries' === $value) {
				$post_types[$key] = __('Galleries', 'live-composer-page-builder' );

			} elseif ( 'dslc_projects_archive' === $value) {
				$post_types[$key] = __('Projects Archive', 'live-composer-page-builder' );
			} elseif ( 'dslc_staff_archive' === $value) {
				$post_types[$key] = __('Staff Archive', 'live-composer-page-builder' );
			} elseif ( 'dslc_partners_archive' === $value) {
				$post_types[$key] = __('Partners Archive', 'live-composer-page-builder' );
			} elseif ( 'dslc_downloads_archive' === $value) {
				$post_types[$key] = __('Downloads Archive', 'live-composer-page-builder' );
			} elseif ( 'dslc_galleries_archive' === $value) {
				$post_types[$key] = __('Galleries Archive', 'live-composer-page-builder' );
			} elseif ( ! is_string( $value ) ) {
				unset( $post_types[$key] );
			}
		}

		$cpt_col_val = '<ul><li> – ';
		$cpt_col_val .= implode('</li><li> – ', $post_types);
		$cpt_col_val .= '</li></ul>';

		if ( ! empty( $post_types ) ) {
			echo $cpt_col_val;
		}
	}

	if ( $column_name == 'dslc_templates_col_default' ) {
		if ( get_post_meta( $post_ID, 'dslc_template_type', true ) == 'default' )
			echo '<strong>Default Template</strong>';
	}

}

add_filter( 'manage_dslc_templates_posts_columns', 'dslc_templates_col_title', 5 );
add_action( 'manage_dslc_templates_posts_custom_column', 'dslc_templates_col_content', 10, 2 );


/**
 * Makes sure there is only one default template per post type
 *
 * If current template set as default
 * go though all other templates for this post type
 * and make sure there is no other default template set.
 *
 * @param  String $post_id  ID of the post being saved.
 * @return void
 */
function dslc_tp_unique_default( $post_id ) {

	// Allowed to do this?
	if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY_SAVE ) ) {

		// If no post type ( not really a save action ) stop execution.
		if ( ! isset( $_POST['post_type'] ) ) {
			return;
		}

		// If template type not supplied stop execution.
		if ( ! isset( $_POST['dslc_template_for'] ) ) {
			return;
		}

		// If template type not supplied stop execution.
		if ( ! isset( $_REQUEST['dslc_template_type'] ) ) {
			return;
		}

		// If not a template stop execution.
		$post_type = esc_attr( $_POST['post_type'] );
		if ( 'dslc_templates' !== $post_type ) { return; }

		// If template not default stop execution.
		$dslc_template_type = esc_attr( $_REQUEST['dslc_template_type'] );
		if ( 'default' !== $dslc_template_type ) { return; }

		// Make dslc_template_for an array even if it's string (for easier processing).
		$dslc_template_for = array();
		if ( ! is_array( $_POST['dslc_template_for'] ) ) {
			$dslc_template_for[] = $_POST['dslc_template_for'];
		} else {
			$dslc_template_for = $_POST['dslc_template_for'];
		}

		// Get templates ( if any ) in same CPT that are default.
		$args = array(
			'post_type' => 'dslc_templates',
			'post_status' => 'any',
			'posts_per_page' => -1,
			'meta_query' => array(
				array(
					'key' => 'dslc_template_for',
					'value' => $dslc_template_for,
					'compare' => 'IN',
				),
				array(
					'key' => 'dslc_template_type',
					'value' => 'default',
					'compare' => '=',
				),
			),
		);

		$templates = get_posts( $args );

		// Set those old defaults to regular templates.
		if ( $templates ) {
			foreach ( $templates as $template ) {
				update_post_meta( $template->ID, 'dslc_template_type', 'regular' );
			}
		}

		// Reset query.
		wp_reset_query();

	} else {
		return;
	}

} add_action( 'save_post', 'dslc_tp_unique_default' );

/**
 * Update dslc_plugin_options_archives option
 * if current template created for archive listing / 404 page / Search Results.
 *
 * Archive, Author, 404 and Search result templates can't have multiply templates
 * as single post templates. In this function we check:
 * – if we are saving a template that can't have more than one template,
 * – update the LC plugin options with selected template
 * - remove 'dslc_template_for' meta value from any other duplicates.
 *
 * This function has nothing to do with single post templates.
 *
 * @param  String $post_id  ID of the post being saved.
 * @return void
 */
function dslc_tp_update_archive_templates_option( $post_id ) {

	// Allowed to do this?
	if ( dslc_current_user_can( 'save' ) ) {

		// $post_type = get_post_type( $post_id );

		// If no post type ( not really a save action ) stop execution.
		/*if ( 'dslc_templates' !== $post_type ) {
			return;
		}*/

		// If template type not supplied.
		/*if ( ! isset( $_POST['dslc_template_for'] ) ) {
			$_POST['dslc_template_for'] = false;
		}

		$post_type = esc_attr( $post_type );*/

		// Make dslc_template_for an array even if it's string (for easier processing).
		$dslc_template_for = array();
		/*if ( ! is_array( $_POST['dslc_template_for'] ) ) {
			$dslc_template_for[] = $_POST['dslc_template_for'];
		} else {
			$dslc_template_for = $_POST['dslc_template_for'];
		}*/

		$dslc_metadata = get_post_meta( $post_id, 'dslc_template_for' );
		$dslc_template_for = $dslc_metadata;

		// List of options that should have single template only (no alternative designs).
		// Like: Search results, 404 page, Author listing, Archive pages, etc.
		$option_require_single_template = array(
			'author',
			'404_page',
			'search_results',
			'post_archive',
			'dslc_projects_archive',
			'dslc_galleries_archive',
			'dslc_downloads_archive',
			'dslc_staff_archive',
			'dslc_partners_archive',
		);

		$plugin_options = get_option( 'dslc_plugin_options' );

		$this_template_in_options = array();

		if ( $plugin_options ) {
			foreach ( $plugin_options as $key => $value ) {
				if ( ! is_array( $value ) && strval( $value ) === strval( $post_id ) ) {
					$this_template_in_options[] = $key;
				}
			}
		}
		/**
		 * First of all find and delete options (DB) that not checked anymore.
		 * Ex.: when user had the current template assigned to the Projects CPT before
		 * but now unchecked the Projects in the list of CPT to apply.
		 */
		// Function array_diff depends on the order of arguments,
		// so we compare twice and then merge result to get what wee need.
		$options_to_delete_a = array_diff( $this_template_in_options, $dslc_template_for );
		$options_to_delete_b = array_diff( $dslc_template_for, $this_template_in_options );
		$options_to_delete = array_merge( $options_to_delete_a, $options_to_delete_b );
		foreach ( $options_to_delete as $option ) {
			unset( $plugin_options[ $option ] );
		}

		// Sanitize and process.
		foreach ( $dslc_template_for as $key => $value ) {

			// Sanitize template slug.
			$dslc_template_for[ $key ] = esc_attr( $value );

			// If option have '_archive' suffix
			// or it's included in $option_require_single_template array
			// put the setting in plugin options table
			// and make sure we have only one LC template
			// for this option selected LC templates section.
			if ( stristr( $value, '_archive' ) || in_array( $value, $option_require_single_template ) ) {
				// Put template post ID into plugin options.
				$plugin_options[ $value ] = $post_id;
				// Make sure we have only one LC template for this option.
				dslc_tp_remove_template_from_meta( $value, $post_id );
			}
		}

		update_option( 'dslc_plugin_options', $plugin_options );

		// Reset query.
		wp_reset_query();

	} else {
		return;
	}

}

// add_action( 'save_post', 'dslc_tp_update_archive_templates_option' );

add_action( 'added_post_meta', 'dslc_template_for_meta_updated', 10, 4 );
add_action( 'updated_postmeta', 'dslc_template_for_meta_updated', 10, 4 );
add_action( 'deleted_post_meta', 'dslc_template_for_meta_updated', 10, 4 );

function dslc_template_for_meta_updated( $meta_id, $object_id, $meta_key, $meta_value ) {

	if ( 'dslc_template_for' !== $meta_key ) {
		return;
	}

	dslc_tp_update_archive_templates_option( $object_id );
}


/**
 * Archive Template Moved To Trash.
 */
function dslc_tp_update_archive_templates_option_ondelete( $post_id ) {

	// Allowed to do this?
	if ( dslc_current_user_can( 'save' ) ) {

		$post_type = get_post_type( $post_id );

		// If no post type ( not really a save action ) stop execution.
		if ( 'dslc_templates' !== $post_type ) {
			return;
		}

		$plugin_options = get_option( 'dslc_plugin_options' );

		$this_template_in_options = array();
		foreach ( $plugin_options as $key => $value ) {
			if ( ! is_array( $value ) && strval( $value ) === strval( $post_id ) ) {
				unset( $plugin_options[ $key ] );
			}
		}

		update_option( 'dslc_plugin_options', $plugin_options );

	} else {
		return;
	}

}

add_action( 'wp_trash_post', 'dslc_tp_update_archive_templates_option_ondelete' );


/**
 * Remove template type from 'dslc_template_for' meta key (Array).
 *
 * @param  String $template_to_remove  Name of the template to remove.
 * @return void
 */
function dslc_tp_remove_template_from_meta( $template_to_remove, $post_id_to_keep ) {
	// Get templates ( if any ) in same CPT that has $template_to_remove
	// as value for 'dslc_template_for' custom field.
	$args = array(
		'post_type' => 'dslc_templates',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'dslc_template_for',
				'value' => $template_to_remove,
				'compare' => 'IN',
			),
		),
	);

	$templates = get_posts( $args );

	// Set those old defaults to regular templates.
	if ( $templates ) {
		foreach ( $templates as $template ) {
			if ( $template->ID !== $post_id_to_keep  ) {
				// Get current value of 'dslc_template_for' custom field.
				$dslc_template_for = get_post_meta( $template->ID, 'dslc_template_for' );
				delete_post_meta( $template->ID, 'dslc_template_for' );

				// Remove value from the array.
				if ( ( $key = array_search( $template_to_remove, $dslc_template_for ) ) !== false ) {
				    unset( $dslc_template_for[ $key ] );
				}

				// Put back updated value for 'dslc_template_for' custom field.
				// DON'T CHANGE IT TO udpate_post_meta!
				// We don't want to struggle with serialized arrays.
				foreach ( $dslc_template_for as $template_cpt ) {
					add_post_meta( $template->ID, 'dslc_template_for', $template_cpt );
				}
			}
		}
	}
}

function dslc_refresh_template_ids() {

	// Get all the posts of 'dslc_templates' type.
	$args = array(
		'posts_per_page' => 99, // Not likely someone have more.
		'post_type' => 'dslc_templates',
	);

	$template_posts = get_posts( $args );

	foreach ( $template_posts as $template ) {
		$template_id = $template->ID;
		dslc_tp_update_archive_templates_option( $template_id );
	}
}
