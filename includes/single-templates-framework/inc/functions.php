<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Moved into LC_CPT_Templates class
 */
function dslc_st_init() {
	// Deprecated.
} add_action( 'init', 'dslc_st_init', 90 );

/**
 * Get the template ID of a specific post.
 * Moved into LC_CPT_Templates class
 *
 * @since 1.0
 * @param  string $post_id  Post ID that we want to find template ID for.
 * @return string   Template ID or false if not found
 */
function dslc_st_get_template_id( $post_id ) {
	// Deprecated.
}
