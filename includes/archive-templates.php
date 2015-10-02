<?php

/**
 * Table of Contents
 *
 * dslc_archive_template_redirect ( Load custom template )
 * dslc_archive_template_init ( Register options )
 * dslc_archive_template_404_fix ( Fixes 404 on pagination caused when regular WP query has no more post )
 */


/**
 * Load custom template 
 *
 * @since 1.0
 */

function dslc_archive_template_redirect( $archive_template ) {

	global $post;

	$template = dslc_get_option( $post->post_type, 'dslc_plugin_options_archives' );
	if ( ! $template || $template == 'none' ) return $archive_template;

	$archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $archive_template;

}
add_filter( 'archive_template', 'dslc_archive_template_redirect' );
add_filter( 'category_template', 'dslc_archive_template_redirect' );

/**
 * Load custom template for author archive
 *
 * @since 1.0
 */

function dslc_author_archive_template_redirect( $archive_template ) {	

	$template = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
	if ( ! $template || $template == 'none' ) return $archive_template;

	$archive_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $archive_template;

} add_filter( 'author_template', 'dslc_author_archive_template_redirect' );

/**
 * Load custom template for search
 *
 * @since 1.0
 */

function dslc_search_template_redirect( $search_template ) {	

	$template = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );
	if ( ! $template || $template == 'none' ) return $search_template;

	$search_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-archive.php';
	return $search_template;

} add_filter( 'search_template', 'dslc_search_template_redirect' );

/**
 * Load custom template for 404
 *
 * @since 1.0
 */

function dslc_404_template_redirect( $not_found_template ) {

	$template = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );
	if ( ! $template || $template == 'none' ) return $not_found_template;

	$not_found_template = DS_LIVE_COMPOSER_ABS . '/templates/dslc-404.php';
	return $not_found_template;

} add_filter( '404_template', 'dslc_404_template_redirect' );

/**
 * Register options
 *
 * @since 1.0
 */

function dslc_archive_template_init() {

	global $dslc_plugin_options;
	global $dslc_var_modules;
	global $dslc_post_types;

	$opts = array();

	// Page Options
	$pages_opts = array();
	$pages_opts[] = array(
		'label' => __( 'Default', 'live-composer-page-builder' ),
		'value' => 'none'
	);
	$pages = get_pages();	
	foreach ( $pages as $page ) {
		$pages_opts[] = array(
			'label' => $page->post_title,
			'value' => $page->ID
		);
	}

	foreach ( $dslc_post_types as $post_type ) {

		$opts[$post_type] = array(
			'label' => $post_type . ' archives',
			'descr' => __( 'Choose which page should serve as template.', 'live-composer-page-builder' ),
			'std' => 'none',
			'type' => 'select',
			'choices' => $pages_opts
		);

	}

	$opts['author'] = array(
		'label' => 'Author archives',
		'descr' => __( 'Choose which page should serve as template.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $pages_opts
	);

	$opts['search_results'] = array(
		'label' => 'Search Results',
		'descr' => __( 'Choose which page should serve as template.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $pages_opts
	);

	$opts['404_page'] = array(
		'label' => '404 Page',
		'descr' => __( 'Choose which page should serve as template.', 'live-composer-page-builder' ),
		'std' => 'none',
		'type' => 'select',
		'choices' => $pages_opts
	);

	$dslc_plugin_options['dslc_plugin_options_archives'] = array(
		'title' => __( 'Archives and Search', 'live-composer-page-builder' ),
		'options' => $opts
	);

} add_action( 'dslc_hook_register_options', 'dslc_archive_template_init' );

/**
 * Fixes 404 on pagination caused when regular WP query has no more post
 * 
 * @since 1.0
 */

function dslc_archive_template_404_fix( $query ) {

	if ( $query->is_author() && $query->is_archive() && $query->is_main_query() ) {

		$template = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		if ( ! $template || $template == 'none' ) { /* nothing */ } else { $query->set( 'posts_per_page', 1 ); }

	}

	return $query;

} add_action( 'pre_get_posts', 'dslc_archive_template_404_fix' );