<?php

/**
 * Table of Contents
 *
 * dslc_archive_template_redirect ( Load custom template )
 * dslc_archive_template_init ( Register options )
 * dslc_archive_template_404_fix ( Fixes 404 on pagination caused when regular WP query has no more post )
 */


// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Load custom template for the archive listings.
 *
 * @param  String $template  Path to a template to filter.
 * @return String            Return the a full path to a template file.
 * @since 1.0
 */
function dslc_template_redirects( $template ) {

	global $post;

	$template_custom = '';

	if ( is_author() && $post ) {
		// If authors archives page?
		$template_custom = dslc_author_archive_template_redirect( $template );

	} elseif ( is_archive() && $post ) {
		// If archive page (when there are posts to show).
		$template_custom = dslc_archive_template_redirect( $template );

	} elseif ( is_search() && $post ) {
		// If search results post.
		$template_custom = dslc_search_template_redirect( $template );

	} elseif ( is_404() ||
			( is_archive() && ! $post ) ||
			( is_search() && ! $post ) ||
			( is_author() && ! $post ) ) {

		// If 404 page.
		// If Archive page and no posts to show.
		// If Search page and no posts to show.
		// If Author post listing and no posts to show.
		// ---
		// Redirect to 404 page if archive posts listing has no posts.
		$template_custom = dslc_404_template_redirect( $template );

	}

	// Return custom or default template.
	if ( $template_custom ) {
		return $template_custom;
	} else {
		return $template;
	}

}
/**
 * Filter 'template_include'.
 *
 * This filter hook is executed immediately before WordPress includes
 * the predetermined template file. This can be used to override
 * WordPress's default template behavior.
 */
add_filter( 'template_include', 'dslc_template_redirects', 99 );


/*
	Below I was trying to fix redirects from author listing with no posts to show.
	No luck for now.

	function dslc_fix_unwanted_redirects( $redirect_url, $requested_url ) {

		return $redirect_url;
	}
	// add_filter( 'redirect_canonical', 'dslc_fix_unwanted_redirects', 10, 2  );

	// remove the filter 
	remove_filter( 'redirect_canonical', 'filter_redirect_canonical', 10, 2 );
*/

/**
 * Load custom template for the archive listings.
 *
 * @param  String $archive_template  Path to a template to filter.
 * @return String                    Return the a full path to a template file.
 * @since 1.0
 */
function dslc_archive_template_redirect( $archive_template ) {

	global $post;

	if ( $post ) {

		$template = dslc_get_archive_template_by_pt( $post->post_type );

	} else {

		$template = false;
	}

	// Do nothing, follow standard WP templates flow.
	if ( ! $template || 'none' === $template ) {
		return $archive_template;
	}

	$custom_archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';

	return $custom_archive_template;
}


/**
 * Load custom template for the author archive.
 *
 * @param  String $archive_template  Path to a template to filter.
 * @return String                    Return the a full path to a template file.
 * @since 1.0
 */
function dslc_author_archive_template_redirect( $archive_template ) {

	$template = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
	if ( ! $template || 'none' === $template ) {
		return $archive_template;
	}

	$archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $archive_template;

}

/**
 * Load custom template for search.
 *
 * @param  String $search_template  Path to a template to filter.
 * @return String                  Return the a full path to a template file.
 * @since 1.0
 */
function dslc_search_template_redirect( $search_template ) {

	$template = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
	if ( ! $template || 'none' === $template ) {
		return $search_template;
	}

	$search_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $search_template;

}

/**
 * Load custom template for 404
 *
 * @param  String $template  Path to a template to filter.
 * @return String            Return the a full path to a template file.
 * @since 1.0
 */
function dslc_404_template_redirect( $template ) {

	$template_id = dslc_get_archive_template_by_pt( '404_page' );

	if ( ! $template_id || 'none' === $template_id ) {
		return $template;
	}

	$not_found_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-404.php';

	return $not_found_template;
}

/**
 * Fixes 404 on pagination caused when regular WP query has no more post
 *
 * @since 1.0
 */
function dslc_archive_template_404_fix( $query ) {

	if ( $query->is_author() && $query->is_archive() && $query->is_main_query() ) {

		$template = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		if ( ! $template || 'none' === $template ) { /* nothing */ } else { $query->set( 'posts_per_page', 1 ); }
	}

	return $query;

} add_action( 'pre_get_posts', 'dslc_archive_template_404_fix' );

/**
 * Flush permalinks when a 404 error is detected.
 *
 * Code from EDD (GPL).
 * https://github.com/easydigitaldownloads/easy-digital-downloads/
 *
 * @since 1.1
 * @return string
 */
function dslc_flush_permalinks_on_404() {

	global $wp;
	global $dslc_var_templates_pt;

	if ( ! is_404() ) {
		return;
	}

	if ( isset( $_GET['dslc-flush'] ) ) {
		return;
	}

	if ( false === get_transient( 'dslc_flush_permalinks' ) ) {

		if ( isset( $_SERVER['REQUEST_URI'] ) && stristr( $_SERVER['REQUEST_URI'], '/?' ) ) {
			$url_part = explode( '=', $_SERVER['REQUEST_URI'] );
			$url_part = str_replace( '/?', '', $url_part[0] );
		}

		$flush_rules = false;

		if ( isset( $_GET['dslc'] ) ) {
			$flush_rules = true;
		} elseif ( isset( $url_part ) && 'dslc_hf' === $url_part ) {
			$flush_rules = true;
		} elseif ( isset( $url_part ) && array_key_exists( $url_part, $dslc_var_templates_pt ) ) {
			$flush_rules = true;
		}

		if ( $flush_rules ) {

			flush_rewrite_rules( false );
			set_transient( 'dslc_flush_permalinks', 1, HOUR_IN_SECONDS * 12 );
			wp_redirect( home_url( add_query_arg( array(
				'dslc-flush' => 1,
			), $wp->request ) ) );
			exit;

		} else {
			return;
		}
	}
} add_action( 'template_redirect', 'dslc_flush_permalinks_on_404' );

/**
 * Redirect page with ?dslc=active
 * to the page without this URL var when users has no rights to edit page
 *
 * @since 1.1
 * @return void
 */
function dslc_redirect_unauthorized() {

	// Allowed to do this?
	if ( isset( $_GET['dslc'] ) && ( ! is_user_logged_in() || ! current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) ) {
		wp_safe_redirect( get_home_url() );
		exit;
	}
} add_action( 'template_redirect', 'dslc_redirect_unauthorized' );
