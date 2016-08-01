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

	global $dslc_var_templates_pt;
	global $dslc_post_types;

	$dslc_var_templates_pt = array();
	$dslc_var_templates_pt['post'] = 'Blog Posts';
	$dslc_var_templates_pt['dslc_projects'] = 'Projects';
	$dslc_var_templates_pt['dslc_galleries'] = 'Galleries';
	$dslc_var_templates_pt['dslc_downloads'] = 'Downloads';
	$dslc_var_templates_pt['dslc_staff'] = 'Staff';
	$dslc_var_templates_pt['dslc_partners'] = 'Partners';

	$dslc_var_templates_pt = apply_filters( 'dslc_post_templates_post_types', $dslc_var_templates_pt );

	$dslc_post_types = array();

	foreach ( $dslc_var_templates_pt as $key => $value ) {

		$dslc_post_types[] = $key;
	}
}
add_action( 'init', 'dslc_post_templates_init', 20 );
