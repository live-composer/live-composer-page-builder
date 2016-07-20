<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

function dslc_st_template_switch() {

	global $post;
	global $dslc_post_types;

	// If there's no post, stop execution
	if ( ! isset( $post ) )
		return;

	// If the post is not supporting templates or it's not a template itself, stop execution
	if ( is_singular( $dslc_post_types ) || is_singular( 'dslc_templates' ) ) { } else {
		return;
	}

	// If the currently shown page is the template CPT
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
		$template_ID = dslc_st_get_template_ID( $post->ID );

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

			// Redirect
			include( $return_template );

			// Bye bye
        	exit();

		}

	}

} add_action( 'template_redirect', 'dslc_st_template_switch' );

function dslc_templates_col_title( $defaults ) {

	unset( $defaults['date'] );
	$defaults['dslc_templates_col_cpt'] = 'Post Type';
	$defaults['dslc_templates_col_default'] = '&nbsp;';
	return $defaults;

}

function dslc_templates_col_content( $column_name, $post_ID ) {

	if ( $column_name == 'dslc_templates_col_cpt' ) {
		echo get_post_meta( $post_ID, 'dslc_template_for', true );
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
 * @since 1.0
 */

function dslc_tp_unique_default( $post_id ) {

	// If no post type ( not really a save action ) stop execution
	if ( ! isset( $_POST['post_type'] ) ) return;

	// If not a template stop execution
	if ( $_POST['post_type'] !== 'dslc_templates' ) return;

	// If template type not supplied stop execution
	if ( ! isset( $_REQUEST['dslc_template_type'] ) ) return;

	// If template not default stop execution
	if ( $_REQUEST['dslc_template_type'] !== 'default' ) return;

	// Get templates ( if any ) in same CPT that are default
	$args = array(
		'post_type' => 'dslc_templates',
		'post_status' => 'any',
		'posts_per_page' => -1,
		'meta_query' => array(
			array(
				'key' => 'dslc_template_for',
				'value' => $_POST['dslc_template_for'],
				'compare' => '=',
			),
			array(
				'key' => 'dslc_template_type',
				'value' => 'default',
				'compare' => '=',
			),
		),
	);
	$templates = get_posts( $args );

	// Set those old defaults to regular tempaltes
	if ( $templates ) {
		foreach ( $templates as $template ) {
			update_post_meta( $template->ID, 'dslc_template_type', 'regular' );
		}
	}

	// Reset query
	wp_reset_query();

} add_action( 'save_post', 'dslc_tp_unique_default' );