<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

add_action( 'widgets_init', 'dslc_sidebars' );
function dslc_sidebars() {

	$sidebars = dslc_get_option( 'sidebars', 'dslc_plugin_options_widgets_m' );

	if ( $sidebars !== '' ) {

		$sidebars_array = explode( ',', substr( $sidebars, 0, -1 ) );

		foreach ( $sidebars_array as $sidebar ) {

			$sidebar_ID = 'dslc_' . strtolower( str_replace( ' ', '_', $sidebar ) );

			register_sidebar( array(
				'name' => $sidebar,
				'id' => $sidebar_ID,
				'before_widget' => '<div id="%1$s" class="dslc-widget dslc-col %2$s"><div class="dslc-widget-wrap">',
				'after_widget' => '</div></div>',
				'before_title' => apply_filters( 'dslc_sidebar_before_title', '<h3 class="dslc-widget-title"><span class="dslc-widget-title-inner">' ),
				'after_title' => apply_filters( 'dslc_sidebar_after_title', '</span></h3>' ),
			) );
		}
	}
}
