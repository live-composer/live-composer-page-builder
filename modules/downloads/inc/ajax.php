<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Table of contents
 *
 * - dslc_front_ ( Add a new modules section )
 */

/**
 * Add a new module section
 *
 * @since 1.0
 */

function dslc_dlm_count_increment( $atts ) {

	// Get post ID
	$post_ID = $_POST['dslc_post_id'];

	// Get current download count
	$download_count = get_post_meta( $post_ID, 'dslc_download_count', true );

	// If no download count exists set it to 0
	if ( ! $download_count ) {
		$download_count = 0;
	}

	// Increment count by 1
	$download_count += 1;

	// Update the count in DB
	update_post_meta( $post_ID, 'dslc_download_count', $download_count );

	// Good night
	exit;

}
add_action( 'wp_ajax_dslc-download-count-increment', 'dslc_dlm_count_increment' );
add_action( 'wp_ajax_nopriv_dslc-download-count-increment', 'dslc_dlm_count_increment' );
