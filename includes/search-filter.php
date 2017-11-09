<?php

/**
 * Table of Contents
 *
 * dslc_search_filter_join ( Include the post meta table in search results )
 * dslc_search_filter_request ( Search post meta for the search term )
 * dslc_search_filter_distinct ( Eliminate duplicated search results )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


/**
 * Include the post meta table in search results
 *
 * @since 1.0
 */

if ( ! function_exists( 'dslc_search_filter_join' ) ) {

	function dslc_search_filter_join( $join ) {

		global $wp_query, $wpdb;

		if ( is_search() && ! empty( $wp_query->query_vars['s'] ) && strpos( $join, $wpdb->postmeta ) === false ) {
			$join .= "JOIN $wpdb->postmeta ON $wpdb->posts.ID = $wpdb->postmeta.post_id ";
		}

		return $join;

	}
} add_filter( 'posts_join', 'dslc_search_filter_join' );


/**
 * Search post meta for the search term
 *
 * @since 1.0
 */

if ( ! function_exists( 'dslc_search_filter_request' ) ) {

	function dslc_search_filter_request( $where ) {

		global $wp_query, $wpdb;

		// Last occurence of %
		$last_occurence_position = strrpos( $where, '%' );

		// Check if we're on a search page
		if ( is_search() && false !== $last_occurence_position && ! empty( $wp_query->query_vars['s'] ) ) {

			// Get the usual WP checks like post status
			$end_pos_where = 5 + $last_occurence_position;
			$request_append = substr( $where, $end_pos_where );

			// Get the search term(s)
			$user_request = esc_sql( trim( $wp_query->query_vars['s'] ) );

			// Separate keywords from search terms
			$user_request_arr = preg_split( '/[\s,]+/', $user_request );

			// Append the post meta ( dslc_content_for_search ) in the request
			$where .= ' OR (' . $wpdb->postmeta . ".meta_key IN ('dslc_content_for_search') ";

			// Append the post value(s) in the request
			foreach ( $user_request_arr as $value ) {
				$where .= 'AND ' . $wpdb->postmeta . ".meta_value LIKE '%" . $value . "%' ";
			}

			// End with the usual WP checks like post status
			$where .= $request_append . ') ';

		}

		// Pass it back to WP
		return $where;

	}
}// End if().
	add_filter( 'posts_where', 'dslc_search_filter_request' );

/**
 * Eliminate duplicated search results
 *
 * @since 1.0
 */

if ( ! function_exists( 'dslc_search_filter_distinct' ) ) {

	function dslc_search_filter_distinct( $distinct ) {

		global $wp_query;

		if ( is_search() && ! empty( $wp_query->query_vars['s'] ) ) {
			$distinct .= 'DISTINCT';
		}

		return $distinct;

	}
} add_filter( 'posts_distinct', 'dslc_search_filter_distinct' );
