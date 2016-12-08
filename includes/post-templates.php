<?php

/**
 * Table of Contents
 *
 * dslc_post_templates_init ( Initiates the post template system )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

function dslc_post_templates_init() {

	// List with custom post types that use templates in LC.
	// Developers: NEVER use/change this var directly. We will remove it soon.
	// If you need to change it use 'dslc_post_templates_post_types' filter.
	global $dslc_var_templates_pt;

	$dslc_var_templates_pt = array();
	$dslc_var_templates_pt['post'] = 'Blog Posts';
	$dslc_var_templates_pt['dslc_projects'] = 'Projects';
	$dslc_var_templates_pt['dslc_galleries'] = 'Galleries';
	$dslc_var_templates_pt['dslc_downloads'] = 'Downloads';
	$dslc_var_templates_pt['dslc_staff'] = 'Staff';
	$dslc_var_templates_pt['dslc_partners'] = 'Partners';

	// Developers: If you need to change $dslc_var_templates_pt, please
	// use the filter below.
	$dslc_var_templates_pt = apply_filters( 'dslc_post_templates_post_types', $dslc_var_templates_pt );

	// List with CPT that use templates system. For inner use only!
	global $dslc_post_types;

	$dslc_post_types = array();

	foreach ( $dslc_var_templates_pt as $key => $value ) {

		$dslc_post_types[] = $key;
	}

	// List with custom post types that you can edit in LC (without templates).
	// Developers: NEVER use/change this var directly. We will remove it soon.
	// If you need to change it use 'dslc_enabled_cpt' filter.
	global $dslc_enabled_cpt;

	$dslc_enabled_cpt = array();
	$dslc_enabled_cpt['page'] = 'Regular Pages';

	$dslc_enabled_cpt = apply_filters( 'dslc_enabled_cpt', $dslc_enabled_cpt );


} add_action( 'init', 'dslc_post_templates_init', 20 );


function dslc_can_edit_in_lc( $post_data ) {

	global $dslc_var_templates_pt;
	global $dslc_enabled_cpt;

	if ( is_int( $post_data ) ) {
		# code...
	} else {
		// Parameter $post_data is post type.
		$post_type = $post_data;

		// If $post_type is included in $dslc_var_templates_pt (can edit with LC).
		if ( array_key_exists( $post_type, $dslc_var_templates_pt ) ||
				array_key_exists( $post_type, $dslc_enabled_cpt ) ) {
			return true;
		} elseif ( 'dslc_hf' === $post_type ) {
			// Make header/footer CPT as editable.
			return true;
		}
	}

	return false;
}

function dslc_cpt_use_templates( $post_type ) {

	global $dslc_var_templates_pt;

	// If $post_type is included in $dslc_var_templates_pt (can edit with LC).
	if ( array_key_exists( $post_type, $dslc_var_templates_pt ) ) {
		return true;
	}

	return false;
}