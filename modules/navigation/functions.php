<?php

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
			'menus' => array (
				'label' => __( 'Menus', 'live-composer-page-builder' ),
				'std' => '',
				'type' => 'list'
			),
		)
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

		foreach( $menus_array as $menu ) {

			$menu_ID = 'dslc_' . strtolower( str_replace( ' ', '_', $menu ) );

			register_nav_menu( $menu_ID, $menu	);

		}

	}

} add_action( 'init', 'dslc_nav_menus' );