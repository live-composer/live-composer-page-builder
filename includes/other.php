<?php

/**
 * Table of contents
 *
 * - dslc_yoast_seo_content_filter ( Include LC content in Yoast SEO filter )
 * - dslc_plugin_action_links ( Additional links on plugin listings page )
 */


/**
 * Include LC content in Yoast SEO filter
 *
 * @since 1.0
 */

function dslc_yoast_seo_content_filter( $post_content, $post ) {

	// If there's LC content append it to the post content var
	if ( get_post_meta( $post->ID, 'dslc_content_for_search', true ) ) {
		$post_content .= ' ' . get_post_meta( $post->ID, 'dslc_content_for_search', true );
	}

	// Return the post content var
	return $post_content;

} add_filter( 'wpseo_pre_analysis_post_content', 'dslc_yoast_seo_content_filter', 10, 2 );

/**
 * Additional links on plugin listings page 
 *
 * @since 1.0
 */

function dslc_plugin_action_links( $links ) {

	// Themes link
	$themes_link = '<a href="http://livecomposerplugin.com/themes" target="_blank">Themes</a>';
	array_unshift( $links, $themes_link );	

	// Addons link
	$addons_link = '<a href="http://livecomposerplugin.com/add-ons" target="_blank">Add-Ons</a>';
	array_unshift( $links, $addons_link );	

	// Support link
	$support_link = '<a href="http://livecomposerplugin.com/support" target="_blank">Support</a>';
	array_unshift( $links, $support_link );

	// Pass it back
	return $links;

} add_filter( 'plugin_action_links_' . DS_LIVE_COMPOSER_BASENAME, 'dslc_plugin_action_links' );

