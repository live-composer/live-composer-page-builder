<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register Options
 *
 * @since 1.0
 */

function dslc_nav_menus_opts() {

	global $dslc_plugin_options;

	$dslc_plugin_options['dslc_plugin_options_navigation_m'] = array(
		'title' => __( 'Navigation Module', 'live-composer-page-builder' ),
		'options' => array(

			'menus' => array(
				'name' => 'dslc_plugin_options_navigation_m[menus]',
				'label' => __( 'Menus', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'list',
			),
		),
	);

} add_action( 'dslc_hook_register_options', 'dslc_nav_menus_opts' );


/**
 * Register Menus
 *
 * @since 1.0
 */

function dslc_nav_menus() {

	$menus = dslc_get_option( 'menus', 'dslc_plugin_options_navigation_m' );

	if ( $menus !== '' ) {

		$menus_array = explode( ',', substr( $menus, 0, -1 ) );

		foreach ( $menus_array as $menu ) {

			$menu_id = 'dslc_' . strtolower( str_replace( ' ', '_', $menu ) );
			register_nav_menu( $menu_id, $menu );
		}
	}

} add_action( 'init', 'dslc_nav_menus' );


/**
 * Shortcode needed to render Menu to make sure
 * current menu item highlighted properly even when LC cache enabled.
 */
function dslc_nav_render_menu( $atts, $content = null ) {

	$theme_location = '';
	$menu_class = 'menu';

	if ( isset( $atts['theme_location'] ) ) {
		$theme_location = $atts['theme_location'];
	}

	if ( isset( $atts['menu_class'] ) ) {
		$menu_class = $atts['menu_class'];
	}

	ob_start();
	wp_nav_menu( array(
		'theme_location' => $theme_location,
		'menu_class' => $menu_class,
	) );
	$shortcode_rendered = ob_get_contents();
	ob_end_clean();

	return $shortcode_rendered;

} add_shortcode( 'dslc_nav_render_menu', 'dslc_nav_render_menu' );

/**
 * Shortcode needed to render Menu to make sure
 * current menu item highlighted properly even when LC cache enabled.
 */
function dslc_nav_render_mobile_menu( $atts, $content = null ) {

	$theme_location = '';

	if ( isset( $atts['theme_location'] ) ) {
		$theme_location = $atts['theme_location'];
	}

	ob_start();

	if ( has_nav_menu( $theme_location ) ) {

		$mobile_nav_output = '';
		$mobile_nav_output .= '<select>';
		$mobile_nav_output .= '<option>' . __( '- Select -', 'live-composer-page-builder' ) . '</option>';

		if ( has_nav_menu( $theme_location ) ) {

			$locations = get_nav_menu_locations();
			$menu = wp_get_nav_menu_object( $locations[ $theme_location ] );
			$menu_items = wp_get_nav_menu_items( $menu->term_id );

			foreach ( $menu_items as $key => $menu_item ) {

				$title = $menu_item->title;
				$url = $menu_item->url;
				$nav_selected = '';

				if ( 0 !== $menu_item->post_parent ) {
					$mobile_nav_output .= '<option value="' . $url . '" ' . $nav_selected . '> - ' . $title . '</option>';
				} else {
					$mobile_nav_output .= '<option value="' . $url . '" ' . $nav_selected . '>' . $title . '</option>';
				}
			}
		}

		$mobile_nav_output .= '</select>';
		echo $mobile_nav_output;
	}

	$shortcode_rendered = ob_get_contents();
	ob_end_clean();

	return $shortcode_rendered;

} add_shortcode( 'dslc_nav_render_mobile_menu', 'dslc_nav_render_mobile_menu' );
