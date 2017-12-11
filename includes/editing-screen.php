<?php
/**
 * Create editing page in WP Admin with live preview area.
 *
 * Create hidden admin page /wp-admin/admin.php?page=livecomposer_editor
 *
 * @package LiveComposer
 * @since 1.1
 *
 *
 * Table of Contents
 *
 * dslc_editing_screen ( Register hidden page in WP Admin used as a wrapper for LC editing )
 * dslc_editing_screen_content ( Output iframe with preview of the page we are editing. )
 * dslc_editing_screen_head ( Code to output in the <head> section of the editing page (WP Admin). )
 * dslc_editing_screen_footer ( Code to output before </body> on the editing page (WP Admin). )
 * dslc_editing_screen_title ( Change page title for the editing page (WP Admin). )
 * dslca_cancel_redirect_frontpage (Cancel canonical redirect for the main page.)
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register hidden page in WP Admin used as a wrapper for LC editing.
 *
 * Create /wp-admin/admin.php?page=livecomposer_editor&page_id=XX page.
 * Page has no menu item in WP Admin Panel.
 *
 * @since 1.1
 */
function dslc_editing_screen() {

	global $dslc_plugin_options;

	$capability = dslc_get_option( 'lc_min_capability_page', 'dslc_plugin_options_access_control' );
	if ( ! $capability ) {
		$capability = 'publish_posts';
	}

	// Base 64 encoded SVG image.
	$icon_svg = dslc_get_menu_svg();

	add_menu_page(
		__( 'Live Composer Editing', 'live-composer-page-builder' ),
		__( 'Live Composer Editing', 'live-composer-page-builder' ),
		$capability, // Capability.
		'livecomposer_editor', // Menu slug.
		'dslc_editing_screen_content', // Callable $function.
		$icon_svg, // Icon_url.
		'99' // Int $position.
	);

	remove_menu_page( 'livecomposer_editor', 'livecomposer_editor' );

} add_action( 'admin_menu', 'dslc_editing_screen' );


/**
 * Output iframe with preview of the page we are editing.
 *
 * On /wp-admin/admin.php?page=livecomposer_editor page we display
 * iframe used as live preview of the page we are editing using Live Composer.
 *
 * @since 1.1
 */
function dslc_editing_screen_content() {

	$screen = get_current_screen();

	// Proceed only if current page is Live Composer editing page in WP Admin
	// and has access role.
	if ( 'toplevel_page_livecomposer_editor' !== $screen->id || ! current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		return;
	}

	// Array with URL variables to be used in add_query_arg
	// @see https://developer.wordpress.org/reference/functions/add_query_arg/ .
	$previewurl_keys = array();
	$preview_output = true;

	// Set id of the page we are editing.
	if ( isset( $_GET['page_id'] ) && is_numeric( $_GET['page_id'] ) ) {

		$previewurl_keys['page_id'] = $_GET['page_id'];
	} else {
		// Otherwise signal to not output preview iframe.
		$preview_output = false;
	}

	// Preview id used when working with post templates in LC.
	if ( isset( $_GET['preview_id'] ) ) {

		$previewurl_keys['preview_id'] = intval( $_GET['preview_id'] );
	}

	// Set 'dslc' key – indicating that Live Composer editing mode is active.
	$previewurl_keys['dslc'] = '';

	// Output iframe with page being edited.
	if ( $preview_output ) {

		do_action( 'dslca_editing_screen_preview_before' );

		$frame_url = set_url_scheme( add_query_arg( $previewurl_keys, get_permalink( $previewurl_keys['page_id'] ) ) );

		echo '<div id="page-builder-preview-area">';
		echo '<iframe id="page-builder-frame" name="page-builder-frame" src="' . esc_url( $frame_url ) . '"></iframe>';
		echo '</div>';

		do_action( 'dslca_editing_screen_preview_after' );
	} else {

		// Output error if no page_id for editing provided.
		echo '<div id="dslc-preview-error"><p>';
		echo esc_attr__( 'Error: No page id provided.', 'live-composer-page-builder' );
		echo '</p></div>';
	}
}


/**
 * Code to output in the <head> section of the editing page (WP Admin).
 *
 * – Inline styles to cover WP Admin interface with preview iframe
 * – Inline styles to hide any notices in WP Admin interface
 *
 * @since 1.1
 */
function dslc_editing_screen_head() {

	$screen = get_current_screen();

	if ( ! $screen ) {
		return;
	}

	// Proceed only if current page is Live Composer editing page in WP Admin.
	if ( 'toplevel_page_livecomposer_editor' !== $screen->id || ! current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		return;
	}
	?>
	<style>
		#wpcontent, #wpbody, #wpbody-content, #page-builder-frame, #page-builder-preview-area {
		   height: 100%;
		   top: 0;
		   left: 0;
		   position: fixed;
		   width: 100%;
		   margin: 0;
		   padding: 0;
		}

		.update-nag, .updated,
		#wpadminbar, #wpfooter, #adminmenuwrap, #adminmenuback, #adminmenumain, #screen-meta  {
			display: none !important;
			opacity: 0 !important;
			visibility: hidden !important;
		}

		#wpbody-content > * {
			display: none!important;
		}

		#wpbody-content #page-builder-preview-area {
			display: block!important;
		}

		#page-builder-preview-area {
		  z-index: 10000;
		  background: #fff;
		}
	</style>
	<?php

	do_action( 'dslca_editing_screen_head' );
}
add_action( 'admin_head', 'dslc_editing_screen_head' );

/**
 * Code to output before </body> on the editing page (WP Admin).
 *
 * – Inline script to hide WP Admin interface
 *
 * @since 1.1
 */
function dslc_editing_screen_footer() {
	$screen = get_current_screen();

	if ( 'toplevel_page_livecomposer_editor' !== $screen->id || ! current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
		return;
	}

	?>
	<script type="text/javascript">
		jQuery('#wpadminbar, #wpfooter, #adminmenuwrap, #adminmenuback, #adminmenumain, #screen-meta, .update-nag, .updated').remove();
		jQuery('#wpbody-content > *').each(function() {
			var current_el = jQuery(this);
			if ( 'page-builder-preview-area' !== current_el[0].getAttribute('id') ) {
				current_el.remove();
			}
		});
	</script>
	<?php
	do_action( 'dslca_editing_screen_footer' );
}

add_action( 'admin_footer', 'dslc_editing_screen_footer' );


/**
 * Code to show in preview area head section.
 *
 * @since 1.1
 */
function dslc_preview_area_head() {

	global $dslc_active;

	if ( $dslc_active ) : ?>
	<style>
		#wpadminbar {
			display: none !important;
			opacity: 0 !important;
			visibility: hidden !important;
		}
	</style>
	<?php endif;
}

add_action( 'wp_head', 'dslc_preview_area_head' );


/**
 * Change page title for the editing page (WP Admin).
 *
 * @since 1.1
 */
function dslc_editing_screen_title( $title ) {
	$screen = get_current_screen();

	if ( 'toplevel_page_livecomposer_editor' !== $screen->id || ! isset( $_GET['page_id'] ) ) {
		return $title;
	}

	$title = 'Edit: ' . get_the_title( intval( $_GET['page_id'] ) );
	return $title;
}

add_filter( 'admin_title', 'dslc_editing_screen_title' );
