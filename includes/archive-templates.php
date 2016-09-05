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
 * @param  String $archive_template  Path to a template to filter.
 * @return String                    Return the a full path to a template file.
 * @since 1.0
 */
function dslc_archive_template_redirect( $archive_template ) {

	global $post;
	$lc = Live_Composer();

	if ( $post ) {

		$post_type = $post->post_type;
		$template = $lc->cpt_templates->get_template( 'by_type', $post_type . '_archive' );

	} else {

		$template = false;
	}

	if ( ! $template || 'none' === $template ) {
		return $archive_template;
	}

	$archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $archive_template;

}
// Replace the template used whenever the "archive" or "category" template is called.
add_filter( 'archive_template', 'dslc_archive_template_redirect' );
add_filter( 'category_template', 'dslc_archive_template_redirect' );


/**
 * Redirect to 404 page if archive posts listing has no posts
 *
 * @since 1.1
 * @return void
 */
function dslc_archive_noposts() {

	global $post;
	$lc = Live_Composer();

	// Allowed to do this?
	if ( is_archive() & ! $post ) {

		$template = $lc->cpt_templates->get_template( 'by_option', '404_page' );

		if ( ! $template || 'none' === $template ) {
			return;
		}

		wp_safe_redirect( get_permalink( $template ) );
		exit;
	}
}
add_action( 'template_redirect', 'dslc_archive_noposts' );


/**
 * Load custom template for the author archive.
 *
 * @param  String $archive_template  Path to a template to filter.
 * @return String                    Return the a full path to a template file.
 * @since 1.0
 */
function dslc_author_archive_template_redirect( $archive_template ) {

	$lc = Live_Composer();
	$template = $lc->cpt_templates->get_template( 'by_option', 'author' );

	if ( ! $template || 'none' === $template ) {
		return $archive_template;
	}

	$archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $archive_template;

}
// Replace the template used whenever the "author archive listing" template is called.
add_filter( 'author_template', 'dslc_author_archive_template_redirect' );

/**
 * Load custom template for search
 *
 * @since 1.0
 */
function dslc_search_template_redirect( $search_template ) {

	$lc = Live_Composer();
	$template = $lc->cpt_templates->get_template( 'by_option', 'search_results' );

	if ( ! $template || 'none' === $template ) {
		return $search_template;
	}

	$search_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $search_template;

} add_filter( 'search_template', 'dslc_search_template_redirect' );

/**
 * Load custom template for 404
 *
 * @since 1.0
 */
function dslc_404_template_redirect( $not_found_template ) {

	$lc = Live_Composer();
	$template = $lc->cpt_templates->get_template( 'by_option', '404_page' );

	if ( ! $template || 'none' === $template ) {
		return $not_found_template;
	}

	$not_found_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-404.php';
	return $not_found_template;

} add_filter( '404_template', 'dslc_404_template_redirect' );


/**
 * Fixes 404 on pagination caused when regular WP query has no more post
 *
 * @since 1.0
 */
function dslc_archive_template_404_fix( $query ) {

	$lc = Live_Composer();

	if ( $query->is_author() && $query->is_archive() && $query->is_main_query() ) {

		$template = $lc->cpt_templates->get_template( 'by_option', 'author' );

		if ( ! $template || 'none' === $template ) { /* nothing */ } else { $query->set( 'posts_per_page', 1 ); }

	}

	return $query;

} add_action( 'pre_get_posts', 'dslc_archive_template_404_fix' );

/**
 * Flush permalinks when a 404 error is detected
 *
 * Code from EDD (GPL).
 * https://github.com/easydigitaldownloads/easy-digital-downloads/
 *
 * @since 1.1
 * @return string
 */
function dslc_flush_permalinks_on_404() {

	global $wp;

	$lc = Live_Composer();
	$dslc_var_templates_pt = $lc->cpt_templates->get_posttypes_with_templates( true );

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
			wp_redirect( home_url( add_query_arg( array( 'dslc-flush' => 1 ), $wp->request ) ) );
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
		wp_safe_redirect( get_permalink() );
		exit;
	}
}
add_action( 'template_redirect', 'dslc_redirect_unauthorized' );
