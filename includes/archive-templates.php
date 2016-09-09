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

	if ( $post ) {

		$post_type = $post->post_type;

		if ( isset( $post_type ) && 'post' === $post_type ) {
			$post_type = 'post_archive';
		}

		$template = dslc_get_option( $post_type, 'dslc_plugin_options_archives' );

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

	// Allowed to do this?
	if ( is_archive() & ! $post ) {

		$template = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

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

	$template = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
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

	$template = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
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
function dslc_404_template_redirect( $template ) {

	if ( is_404() ) {

		$template = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

		if ( ! $template || 'none' === $template ) {
			return $template;
		}

		$not_found_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-404.php';

		return $not_found_template;
	}

	return $template;

} add_filter( 'template_include', 'dslc_404_template_redirect' );
// add_filter( '404_template', 'dslc_404_template_redirect' );



/**
 * Register 'Archives and Search' options panel fields.
 *
 * @since 1.0
 */
/*
function dslc_archive_template_init() {

	global $dslc_plugin_options;
	global $dslc_post_types;

	$opts = array();

	// Page Options.
	$pages_opts = array();
	$pages_opts[] = array(
		'label' => __( 'Default', 'live-composer-page-builder' ),
		'value' => 'none',
	);

	$pages = get_pages();
	// Add 'dslc_archive_template_cpt' filter to give the theme developers
	// an option to show their own custom posts types in the templates dropdown.
	$pages = apply_filters( 'dslc_archive_template_cpt', $pages );

	foreach ( $pages as $page ) {
		$pages_opts[] = array(
			'label' => $page->post_title,
			'value' => $page->ID,
		);
	}

	// Form list of Templates ('dslc_templates' post type).
	$lc_templates = array();

	$lc_templates_args = array(
		'post_type' => 'dslc_templates',
		'post_status' => 'publish',
	);

	$templates_array = get_posts( $lc_templates_args );

	foreach ( $templates_array as $post ) {
		$lc_templates[] = array(
			'label' => $post->post_title,
			'value' => $post->ID,
		);
	}

	$lc_templates[] = array(
		'label' => __( 'Default', 'live-composer-page-builder' ),
		'value' => 'none',
	);

	foreach ( $dslc_post_types as $post_type ) {

		$opts[ $post_type ] = array(
			'name' => 'dslc_plugin_options_archives[' . $post_type . ']',
			'label' => $post_type . ' archives',
			'descr' => __( 'Choose which page should serve as template.', 'live-composer-page-builder' ),
			'std' => 'none',
			'type' => 'select',
			'choices' => $pages_opts,
		);
	}

	$opts['author'] = array(
		'name' => 'dslc_plugin_options_archives[author]',
		'label' => 'Author archives',
		'descr' => __( 'Author posts listing template.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $lc_templates,
	);

	$opts['search_results'] = array(
		'name' => 'dslc_plugin_options_archives[search_results]',
		'label' => 'Search Results',
		'descr' => __( 'Search results listing template.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $lc_templates,
	);

	$opts['404_page'] = array(
		'name' => 'dslc_plugin_options_archives[404_page]',
		'label' => '404 Page',
		'descr' => __( 'Custom template for 404 error page.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $lc_templates,
	);

	$dslc_plugin_options['dslc_plugin_options_archives'] = array(
		'title' => __( 'Archives and Search', 'live-composer-page-builder' ),
		'options' => $opts,
	);

} add_action( 'dslc_hook_register_options', 'dslc_archive_template_init' );
*/

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
