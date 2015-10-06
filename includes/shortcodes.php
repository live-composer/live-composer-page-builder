<?php

/**
 * Notification
 */

function dslc_sc_notification( $atts, $content ) {

	/* Attributes */
	extract( shortcode_atts( array(
		'color' => 'default',
	), $atts));

	return '<div class="dslc-notification dslc-' . $color . '">' . $content . '<span class="dslc-notification-close"><span class="dslc-icon dslc-icon-remove-sign"></span></span></div>';

} add_shortcode( 'dslc_notification', 'dslc_sc_notification' );

/**
 * Output custom field value
 */

function dslc_sc_get_custom_field( $atts, $content ) {

	extract( shortcode_atts( array(
		'id' => false,
		'post_id' => false,
	), $atts));

	if ( ! $id )
		return 'Custom field ID not supplied ( "id" parameter ).';

	if ( ! $post_id && in_the_loop() )
		$post_id = get_the_ID();

	if ( ! $post_id )
		$post_id = $_POST['dslc_post_id'];

	if ( get_post_meta( $post_id, $id, true ) ) {
		return do_shortcode( get_post_meta( $post_id, $id, true ) );
	}

} add_shortcode( 'dslc_custom_field', 'dslc_sc_get_custom_field' );

/**
 * Site URL
 */

function dslc_sc_site_url( $atts, $content ) {

	return site_url();

} add_shortcode( 'dslc_site_url', 'dslc_sc_site_url' );

/**
 * Icon
 *
 * @since 1.0
 */

function dslc_sc_icon( $atts, $content ) {

	extract( shortcode_atts( array(
		'id' => false,
	), $atts));

	if ( ! $id )
		return '';

	return '<span class="dslc-icon dslc-icon-' . $id . ' dslc-icon-sc"></span>';

} add_shortcode( 'dslc_icon', 'dslc_sc_icon' ); 

/**
 * User Avatar
 *
 * @since 1.0
 */

function dslc_sc_user_avatar( $atts, $content ) {

	extract( shortcode_atts( array(
		'user' => false,
		'size' => 100,
		'url' => false,
		'target' => '_self'
	), $atts));

	if ( ! $url ) {
		echo '<span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span>';
	} else {
		echo '<a href="' . $url . '" target="' . $target. '"><span class="dslc-sc-user-avatar">' . get_avatar( get_current_user_id(), $size ) . '</span></a>';
	}

} add_shortcode( 'dslc_user_avatar', 'dslc_sc_user_avatar' ); 

/**
 * Category Description
 *
 * @since 1.0.4
 */
function dslc_sc_category_description( $atts, $content ) {

	extract( shortcode_atts( array(
		'category_ID' => false,
	), $atts));

	// If category ID not supplied, get current category
	if ( ! $category_ID ) {
		$category_ID = get_query_var('cat');
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