<?php

/**
 * Table Of Contents
 *
 * dslc_sc_notification ( Notification Shortcode )
 * dslc_sc_get_custom_field ( Custom Field Shortcode )
 * dslc_sc_site_url ( Site URL Shortcode )
 * dslc_sc_icon ( Icon Shortcode )
 * dslc_sc_user_avatar ( User Avatar Shortcode )
 * dslc_sc_category_description ( Category Description Shortcode )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


/**
 * Notification Shortcode
 *
 * Outputs a notification
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string HTML notification
 */
function dslc_sc_notification( $atts, $content ) {

	// Attributes
	extract( shortcode_atts( array(
		'color' => 'default',
	), $atts ) );

	// Return notifaction HTML
	return '<div class="dslc-notification dslc-' . $color . '">' . $content . '<span class="dslc-notification-close"><span class="dslc-icon dslc-icon-remove-sign"></span></span></div>';

} add_shortcode( 'dslc_notification', 'dslc_sc_notification' );

/**
 * Custom Field Shortcode
 *
 * Outputs custom field value of a post
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Custom field value
 */
function dslc_sc_get_custom_field( $atts, $content ) {

	// Attributes
	extract( shortcode_atts( array(
		'id' => false,
		'post_id' => false,
	), $atts ) );

	// If no custom field ID return error message
	if ( ! $id ) {
		return 'Custom field ID not supplied ( "id" parameter ).';
	}

	// If no post ID but in the loop, get current ID
	if ( ! $post_id && in_the_loop() ) {
		$post_id = get_the_ID();
	}

	// If no post ID use $_POST ( this is mostly for the editor usage )
	if ( ! $post_id ) {
		$post_id = $_POST['dslc_post_id'];
	}

	// If the post has the custom field return the value
	if ( get_post_meta( $post_id, $id, true ) ) {
		return do_shortcode( get_post_meta( $post_id, $id, true ) );
	}

} add_shortcode( 'dslc_custom_field', 'dslc_sc_get_custom_field' );

/**
 * Site URL Shortcode
 *
 * Outputs the site URL ( URL to homepage )
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Site URL
 */
function dslc_sc_site_url( $atts, $content ) {

	// Return site URL
	return site_url();

} add_shortcode( 'dslc_site_url', 'dslc_sc_site_url' );

/**
 * Icon Shortcode
 *
 * Outputs an icon
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Icon HTML
 */
function dslc_sc_icon( $atts, $content ) {

	// Attributes
	extract( shortcode_atts( array(
		'id' => false,
	), $atts ) );

	// If no ID return empty
	if ( ! $id ) {
		return '';
	}

	// Return Icon HTML
	return '<span class="dslc-icon dslc-icon-' . $id . ' dslc-icon-sc"></span>';

} add_shortcode( 'dslc_icon', 'dslc_sc_icon' );

/**
 * User Avatar Shortcode
 *
 * Outputs the user avatar
 *
 * @since 1.0
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string HTML avatar image
 */
function dslc_sc_user_avatar( $atts, $content ) {

	// Attributes
	extract( shortcode_atts( array(
		'user' => false,
		'size' => 100,
		'url' => false,
		'target' => '_self',
	), $atts ) );

	// If URL not supplied return avatar HTML without link
	if ( ! $url ) {
		return '<span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span>';
		// If URL supplied wrap the avatar HTML in a link
	} else {
		return '<a href="' . $url . '" target="' . $target . '"><span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span></a>';
	}

} add_shortcode( 'dslc_user_avatar', 'dslc_sc_user_avatar' );

/**
 * Category Description Shortcode
 *
 * Outputs category description
 *
 * @since 1.0.4
 * @param array  $atts Shortcode attributes
 * @param string $content
 * @return string Category description
 */
function dslc_sc_category_description( $atts, $content ) {

	// Attributes
	extract( shortcode_atts( array(
		'category_ID' => false,
	), $atts ) );

	// If category ID not supplied, get current category
	if ( ! $category_ID ) {
		$category_ID = get_query_var( 'cat' );
	}

	// Get category description
	$category_description = category_description( $category_ID );

	// Placeholder description
	if ( ! is_category() && empty( $category_description ) && dslc_is_editor_active( 'access' ) ) {
		$category_description = __( 'Category description will be shown here.', 'live-composer-page-builder' );
	}

	// Return category description
	return $category_description;

} add_shortcode( 'dslc_category_description', 'dslc_sc_category_description' );
