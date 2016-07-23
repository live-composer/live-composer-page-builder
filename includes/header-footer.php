<?php

/**
 * Table of contents
 *
 * - dslc_hf_init ( Register custom post type and add options )
 * - dslc_hf_col_title ( Listing - Column title )
 * - dslc_hf_col_content ( Listing - Column content )
 * - dslc_hf_unique_default ( Make sure there's only one default per header and footer )
 * - dslc_hf_options ( Register options for posts/pages to choose which header/footer to use )
 * - dslc_hf_get_ID ( Get the header and footer ID of a specific post/page )
 * - dslc_hf_get_code ( Get the header or footer LC code of a specific post/page )
 * - dslc_hf_get_header ( Get the header output code )
 * - dslc_hf_get_footer ( Get the footer output code )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register custom post type and add options
 *
 * @since 1.0
 */

function dslc_hf_init() {

	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return;
	}

	$capability = 'publish_posts';

	register_post_type( 'dslc_hf', array(
		'menu_icon' => 'dashicons-image-flip-vertical',
		'labels' => array(
			'name' => __( 'Header/Footer', 'live-composer-page-builder' ),
			'singular_name' => __( 'Add Header/Footer', 'live-composer-page-builder' ),
			'add_new' => __( 'Add Header/Footer', 'live-composer-page-builder' ),
			'add_new_item' => __( 'Add Header/Footer', 'live-composer-page-builder' ),
			'edit' => __( 'Edit', 'live-composer-page-builder' ),
			'edit_item' => __( 'Edit Header/Footer', 'live-composer-page-builder' ),
			'new_item' => __( 'New Header/Footer', 'live-composer-page-builder' ),
			'view' => __( 'View Header/Footer', 'live-composer-page-builder' ),
			'view_item' => __( 'View Header/Footer', 'live-composer-page-builder' ),
			'search_items' => __( 'Search Header/Footer', 'live-composer-page-builder' ),
			'not_found' => __( 'No Header/Footer found', 'live-composer-page-builder' ),
			'not_found_in_trash' => __( 'No Header/Footer found in Trash', 'live-composer-page-builder' ),
			'parent' => __( 'Parent Header/Footer', 'live-composer-page-builder' ),
		),
		'public' => true,
		'supports' => array('title', 'custom-fields', 'author', 'thumbnail'),
		'capabilities' => array(
			'publish_posts' => $capability,
			'edit_posts' => $capability,
			'edit_others_posts' => $capability,
			'delete_posts' => $capability,
			'delete_others_posts' => $capability,
			'read_private_posts' => $capability,
			'edit_post' => $capability,
			'delete_post' => $capability,
			'read_post' => $capability
		),
	) );

	/**
	 * Options
	 */

	global $dslc_var_post_options;
	$dslc_var_post_options['dslc-hf-opts'] = array(
		'title' => 'Options',
		'show_on' => 'dslc_hf',
		'options' => array(
			array(
				'label' => __( 'For', 'live-composer-page-builder' ),
				'descr' => __( 'Choose what is this for, header or footer.', 'live-composer-page-builder' ),
				'std' => 'header',
				'id' => 'dslc_hf_for',
				'type' => 'select',
				'choices' => array(
					array(
						'label' => 'Header',
						'value' => 'header'
					),
					array(
						'label' => 'Footer',
						'value' => 'footer'
					),
				)
			),
			array(
				'label' => __( 'Type', 'live-composer-page-builder' ),
				'std' => 'regular',
				'descr' => __( '<strong>Default</strong> will be used as the default for all the posts and pages. <strong>Regular</strong> is an additional type that you can set to specific posts/pages.', 'live-composer-page-builder' ),
				'id' => 'dslc_hf_type',
				'type' => 'radio',
				'choices' => array(
					array(
						'label' => 'Regular',
						'value' => 'regular'
					),
					array(
						'label' => 'Default',
						'value' => 'default'
					),
				)
			),
			array(
				'label' => __( 'Position', 'live-composer-page-builder' ),
				'std' => 'relative',
				'descr' => __( '<strong>Relative</strong> is normal positioning. <strong>Fixed</strong> will make the header/footer scroll with the page. <strong>Absolute</strong> will make the regular page content go behind the header/footer.', 'live-composer-page-builder' ),
				'id' => 'dslc_hf_position',
				'type' => 'radio',
				'choices' => array(
					array(
						'label' => 'Relative',
						'value' => 'relative'
					),
					array(
						'label' => 'Fixed',
						'value' => 'fixed'
					),
					array(
						'label' => 'Absolute',
						'value' => 'absolute'
					),
				)
			),
		)
	);

} add_action( 'init', 'dslc_hf_init' );

/**
 * Listing - Column Title
 *
 * @since 1.0
 */

function dslc_hf_col_title( $defaults ) {

	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return;
	}

	unset( $defaults['date'] );
	unset( $defaults['author'] );
	$defaults['dslc_hf_col_cpt'] = 'For';
	$defaults['dslc_hf_col_default'] = 'Type';
	return $defaults;

} add_filter( 'manage_dslc_hf_posts_columns', 'dslc_hf_col_title', 5 );

/**
 * Listing - Column Content
 *
 * @since 1.0
 */

function dslc_hf_col_content( $column_name, $post_ID ) {

	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return;
	}

	if ( $column_name == 'dslc_hf_col_cpt' ) {
		echo get_post_meta( $post_ID, 'dslc_hf_for', true );
	}

	if ( $column_name == 'dslc_hf_col_default' ) {
		if ( get_post_meta( $post_ID, 'dslc_hf_type', true ) == 'default' ) {
					echo '<strong>Default</strong>';
		}
	}

} add_action( 'manage_dslc_hf_posts_custom_column', 'dslc_hf_col_content', 10, 2 );

/**
 * Make sure there's only one default per header and footer
 *
 * @since 1.0
 */

function dslc_hf_unique_default( $post_id ) {

	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return;
	}

	// If no post type ( not really a save action ) stop execution
	if ( ! isset( $_POST['post_type'] ) ) {
		return;
	}

	// If not a header/footer stop excution
	if ( $_POST['post_type'] !== 'dslc_hf' ) {
		return;
	}

	// If template type not supplied stop execution
	if ( ! isset( $_REQUEST['dslc_hf_type'] ) ) {
		return;
	}

	// If template not default stop execution
	if ( $_REQUEST['dslc_hf_type'] !== 'default' ) {
		return;
	}

	// Get header/footer that are default
	$args = array(
		'post_type' => 'dslc_hf',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'dslc_hf_for',
				'value' => $_POST['dslc_hf_for'],
				'compare' => '=',
			),
			array(
				'key' => 'dslc_hf_type',
				'value' => 'default',
				'compare' => '=',
			),
		),
	);
	$templates = get_posts( $args );

	// Set those old defaults to regular tempaltes
	if ( $templates ) {
		foreach ( $templates as $template ) {
			update_post_meta( $template->ID, 'dslc_hf_type', 'regular' );
		}
	}

	// Reset query
	wp_reset_query();

} add_action( 'save_post', 'dslc_hf_unique_default' );

/**
 * Register options for posts/pages to choose which header/footer to use
 *
 * @since 1.0
 */

function dslc_hf_options() {

	$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on', true );

	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF || true !== $dslc_admin_interface_on ) {

		return;
	}

	$headers_array = array();
	$headers_array[] = array(
		'label' => 'Default',
		'value' => 'default',
	);
	$headers_array[] = array(
		'label' => 'Disabled',
		'value' => '_disabled_',
	);
	$footers_array = array();
	$footers_array[] = array(
		'label' => 'Default',
		'value' => 'default',
	);
	$footers_array[] = array(
		'label' => 'Disabled',
		'value' => '_disabled_',
	);

	global $dslc_var_post_options;

	// Get header/footer.
	$args = array(
		'post_type' => 'dslc_hf',
		'post_status' => 'publish',
		'posts_per_page' => -1,
		'order' => 'DESC',
	);
	$templates = get_posts( $args );

	if ( $templates ) {

		foreach ( $templates as $template ) {
			$template_for = get_post_meta( $template->ID, 'dslc_hf_for', true );
			if ( $template_for == 'header' ) {
				$headers_array[] = array(
					'label' => $template->post_title,
					'value' => $template->ID
				);
			} elseif ( $template_for == 'footer' ) {
				$footers_array[] = array(
					'label' => $template->post_title,
					'value' => $template->ID
				);
			}
		}

		$dslc_var_post_options['dslc-hf-options'] = array(
			'title' => __( 'Header/Footer', 'live-composer-page-builder' ),
			'show_on' => array('page', 'dslc_templates'),
			'context' => 'side',
			'options' => array(
				array(
					'label' => __( 'Header', 'live-composer-page-builder' ),
					'std' => '',
					'id' => 'dslc_header',
					'type' => 'select',
					'choices' => $headers_array
				),
				array(
					'label' => __( 'Footer', 'live-composer-page-builder' ),
					'std' => '',
					'id' => 'dslc_footer',
					'type' => 'select',
					'choices' => $footers_array
				),
			)
		);

	}

} add_action( 'init', 'dslc_hf_options' );

/**
 * Get the header and footer IDs of a specific post/page
 *
 * @since 1.0
 *
 * @param int     $post_ID ID of the post/page. Default false ( Automatically finds ID ).
 * @return array  The IDs of the header and footer associated with the post/page. False if none.
 */
function dslc_hf_get_ID( $post_ID = false ) {

	// If theme does not define header/footer compatibility return false
	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return array('header' => false, 'footer' => false);
	}

	// If current page is actually header/footer post, return false
	if ( is_singular( 'dslc_hf' ) ) {
		return array('header' => false, 'footer' => false);
	}

	// Global vars
	global $dslc_post_types;

	// If post ID not supplied, figure it out
	if ( ! $post_ID ) {

		// If currently showing a singular post of a post type that supports "post templates"
		if ( is_singular( $dslc_post_types ) ) {
			$post_ID = dslc_st_get_template_ID( get_the_ID() );

		// If currently showing a category archive page
		} elseif ( is_archive() && ! is_author() && ! is_search() ) {
			$post_ID = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );

		// If currently showing an author archive page
		} elseif ( is_author() ) {
			$post_ID = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

		// If currently showing a search results page
		} elseif ( is_search() ) {
			$post_ID = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );

		// If currently showina 404 page
		} elseif ( is_404() ) {
			$post_ID = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

		// Otherwise just get the ID
		} else {
			$post_ID = get_the_ID();
		}

	}

	// Get header/footer template
	$header_tpl = get_post_meta( $post_ID, 'dslc_header', true );
	$footer_tpl = get_post_meta( $post_ID, 'dslc_footer', true );

	// If no header template set, make it "default"
	if ( ! $header_tpl ) {
		$header_tpl = 'default';
	}

	// If no footer template set make it "default"
	if ( ! $footer_tpl ) {
		$footer_tpl = 'default';
	}

	// Default header template supplied, find it and return the ID
	if ( $header_tpl == 'default' ) {

		// Query for default template
		$args = array(
			'post_type' => 'dslc_hf',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => 'dslc_hf_for',
					'value' => 'header',
					'compare' => '=',
				),
				array(
					'key' => 'dslc_hf_type',
					'value' => 'default',
					'compare' => '=',
				),
			),
			'order' => 'DESC'
		);
		$tpls = get_posts( $args );

		// If default template found set the ID if not make it false
		if ( $tpls ) {
					$header_tpl_ID = $tpls[0]->ID;
		} else {
					$header_tpl_ID = false;
		}

	// Specific template supplied, return the ID
	} elseif ( $header_tpl && $header_tpl != '_disabled_' ) {

		$header_tpl_ID = $header_tpl;

	} elseif ( $header_tpl && $header_tpl == '_disabled_' ) {

		$header_tpl_ID = false;

	}

	// Default footer template supplied, find it and return the ID
	if ( $footer_tpl == 'default' ) {

		// Query for default template
		$args = array(
			'post_type' => 'dslc_hf',
			'post_status' => 'publish',
			'posts_per_page' => 1,
			'meta_query' => array(
				array(
					'key' => 'dslc_hf_for',
					'value' => 'footer',
					'compare' => '=',
				),
				array(
					'key' => 'dslc_hf_type',
					'value' => 'default',
					'compare' => '=',
				),
			),
			'order' => 'DESC'
		);
		$tpls = get_posts( $args );

		// If default template found set the ID if not make it false
		if ( $tpls ) {
					$footer_tpl_ID = $tpls[0]->ID;
		} else {
					$footer_tpl_ID = false;
		}

	// Specific template supplied, return the ID
	} elseif ( $footer_tpl && $footer_tpl != '_disabled_' ) {

		$footer_tpl_ID = $footer_tpl;

	} elseif ( $footer_tpl && $footer_tpl == '_disabled_' ) {

		$footer_tpl_ID = false;

	}

	// Return the template ID
	return array('header' => $header_tpl_ID, 'footer' => $footer_tpl_ID);

}

/**
 * Get the header or footer LC code of a specific post/page
 *
 * @since 1.0.2
 *
 * @param int     $post_ID ID of the post/page. Default false.
 * @param string  $h_or_f Accepted values 'header' and 'footer'. Defaults to 'header'
 * @return string The LC code for the header/footer of the post/page. Empty string if no LC code.
 */
function dslc_hf_get_code( $post_ID = false, $h_or_f = 'header' ) {

	// If support for header/footer functionality not set or is set to false, return empty string
	if ( ! defined( 'DS_LIVE_COMPOSER_HF' ) || ! DS_LIVE_COMPOSER_HF ) {
		return '';
	}

	// This will be returned at the end
	$code = '';

	// If post ID not supplied ask WordPress
	if ( ! $post_ID ) {
		$post_ID = get_the_ID();
	}

	// If still no ID return empty string
	if ( ! $post_ID ) {
		return '';
	}

	// Get ID of the header/footer powering the post
	$header_footer = dslc_hf_get_ID( $post_ID );

	// If post has header/footer attached
	if ( $header_footer[$h_or_f] ) {
		// Get LC code of the header/footer powering the post
		$code = get_post_meta( $header_footer[$h_or_f], 'dslc_code', true );
	}

	// Pass it back
	return $code;

}

/**
 * Get the header output code
 *
 * @since 1.0.2
 *
 * @param int     $post_ID ID of the post/page. Default false.
 * @return string The HTML ouput of the header for a defined post/page
 */
function dslc_hf_get_header( $post_ID = false ) {

	// Var defaults
	$append = '';
	$wrapper_start = '';

	// Wrap if header handled by theme
	if ( defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) && ! DS_LIVE_COMPOSER_HF_AUTO ) {
		$wrapper_start = '<div id="dslc-content" class="dslc-content dslc-clearfix">';
	}

	// If the page displayed is header/footer, do not repeat
	if ( is_singular( 'dslc_hf' ) ) {
		return $wrapper_start;
	}

	// Get header/footer ID associated with the post
	$header_footer = dslc_hf_get_ID( $post_ID );

	// If there is a header applied
	if ( $header_footer['header'] && is_numeric ( $header_footer['header'] ) ) {

		// Get the header LC code
		$header_code = get_post_meta( $header_footer['header'], 'dslc_code', true );

		// If the "position" option value exists
		if ( get_post_meta( $header_footer['header'], 'dslc_hf_position', true ) ) {

			// Set the "position" option value to the one from the settings
			$header_position = get_post_meta( $header_footer['header'], 'dslc_hf_position', true );

		} else {

			// Set the "position" option value to default "relative"
			$header_position = 'relative';

		}

		// If editor active? Add a link to the header editing.
		if ( dslc_is_editor_active( 'access' ) ) {

			$header_link = DSLC_EditorInterface::get_editor_link( $header_footer['header'] );

			// Set the HTML for the edit overlay.
			$append = '<div class="dslc-hf-block-overlay"><a target="_blank" href="' . $header_link . '" class="dslc-hf-block-overlay-button dslca-link">' . __( 'Edit Header','live-composer-page-builder' ) . '</a></div>';

		}

		// Add the header code to the variable holder
		return $wrapper_start . '<div id="dslc-header" class="dslc-header-pos-' . $header_position . '">' . do_shortcode( $header_code ) . $append . '</div>';

	// If no header applied
	} else {

		return $wrapper_start . '';

	}

}

/**
 * Get the footer output code
 *
 * @since 1.0.2
 *
 * @param int     $post_ID ID of the post/page. Default false.
 * @return string The HTML ouput of the footer for a defined post/page
 */
function dslc_hf_get_footer( $post_ID = false ) {

	// Var defaults
	$append = '';
	$wrapper_end = '';

	// Wrap if header handled by theme
	if ( defined( 'DS_LIVE_COMPOSER_HF_AUTO' ) && ! DS_LIVE_COMPOSER_HF_AUTO ) {
		$wrapper_end = '</div>';
	}

	// If the page displayed is header/footer, do not repeat
	if ( is_singular( 'dslc_hf' ) ) {
		return $wrapper_end;
	}

	// Get header/footer ID associated with the post
	$header_footer = dslc_hf_get_ID( $post_ID );

	// If there is a footer applied
	if ( $header_footer['footer'] && is_numeric ( $header_footer['footer'] )  ) {

		// Get the footer LC code
		$footer_code = get_post_meta( $header_footer['footer'], 'dslc_code', true );

		// If the "position" option value exists
		if ( get_post_meta( $header_footer['footer'], 'dslc_hf_position', true ) ) {

			// Set the "position" option value to the one from the settings
			$footer_position = get_post_meta( $header_footer['footer'], 'dslc_hf_position', true );

		} else {

			// Set the "position" option value to default "relative"
			$footer_position = 'relative';

		}

		// If editor active? Add a link to the footer editing.
		if ( dslc_is_editor_active( 'access' ) ) {

			$footer_link = DSLC_EditorInterface::get_editor_link( $header_footer['footer'] );

			// Set the HTML for the edit overlay.
			$append = '<div class="dslc-hf-block-overlay"><a target="_blank" href="' . $footer_link . '" class="dslc-hf-block-overlay-button dslca-link">' . __( 'Edit Footer','live-composer-page-builder' ) . '</a></div>';

		}

		// Add the header code to the variable holder.
		return '<div id="dslc-footer"  class="dslc-footer-pos-' . $footer_position . '">' . do_shortcode( $footer_code ) . $append . '</div>' . $wrapper_end;

	// If no header applied
	} else {

		return '' . $wrapper_end;

	}

}