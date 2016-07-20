<?php
/**
 * LC editor interface class
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * DSLC_EditorInterface class
 */
class DSLC_EditorInterface{

	/**
	 * Init all hooks
	 */
	static function init() {

		add_action( 'wp_footer', array( __CLASS__, 'show_lc_button_on_front' ) );
	}

	/**
	 * Returns editor link
	 *
	 * @return string
	 */
	static function get_editor_link( $page_id, $preview_id = '' ) {

		if ( '' !== $preview_id ) {

			$preview_id = '&preview_id=' . $preview_id;
		}

		return admin_url( 'admin.php?page=livecomposer_editor&page_id=' . $page_id . $preview_id);
	}

	/**
	 * Shows button on front
	 *
	 * @echoes string{HTML}
	 */
	static function show_lc_button_on_front() {

		$dslc_admin_interface_on = apply_filters( 'dslc_admin_interface_on_frontend', true );

		if ( true !== $dslc_admin_interface_on ) {

			return;
		}

		global $dslc_active, $dslc_var_templates_pt;

		// Get the position of the activation button.
		$activate_button_position = dslc_get_option( 'lc_module_activate_button_pos', 'dslc_plugin_options_other' );

		if ( empty( $activate_button_position ) ) {

			$activate_button_position = 'right';
		}

		// LC and WP Customizer do not work well together, don't proceed if customizer active.
		if ( ( ! function_exists( 'is_customize_preview' ) || ! is_customize_preview() ) ) :

			// If editor not active and user can access the editor.
			if ( ! DS_LIVE_COMPOSER_ACTIVE && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

				// If a singular page ( posts and pages ).
				if ( is_singular() ) {

					// If a page or a template go ahead normally.
					if ( is_page() || get_post_type() === 'dslc_templates' || ! isset( $dslc_var_templates_pt[ get_post_type() ] ) ) {

						?><a href="<?php echo self::get_editor_link( get_the_ID() ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'Activate Live Composer', 'live-composer-page-builder' ); ?></a><?php

					// If not a page or a template post type.
					} else {

						// Check if it has a template attached to it.
						$template = dslc_st_get_template_ID( get_the_ID() );

						if ( $template ) {

							?><a target="_blank" href="<?php echo self::get_editor_link( $template, get_the_ID() ); ?>" class="dslca-activate-composer-hook"><?php _e( 'Edit Template', 'live-composer-page-builder' ); ?></a><?php

						} else {

							?><a target="_blank" href="<?php echo admin_url( 'post-new.php?post_type=dslc_templates' ); ?>" class="dslca-activate-composer-hook"><?php _e( 'Create Template', 'live-composer-page-builder' ); ?></a><?php

						}

					}

				// If a 404 page.
				} elseif ( is_404() ) {

					// Get ID of the page set to power the 404 page.
					$template_id = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );

					// If there is a page that powers it.
					if ( $template_id != 'none' ) {

						// Output the button
						?><a href="<?php echo self::get_editor_link( $template_id ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'Activate Live Composer', 'live-composer-page-builder' ); ?></a><?php

					}

				// If a search results page.
				} elseif ( is_search() ) {

					// Get ID of the page set to power the search results page.
					$template_id = dslc_get_option( 'search_results', 'dslc_plugin_options_archives' );

					// If there is a page that powers it?
					if ( $template_id != 'none' ) {

						// Output the button.
						?><a href="<?php echo esc_attr( self::get_editor_link( $template_id, get_the_ID() ) ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'Activate Live Composer', 'live-composer-page-builder' ); ?></a><?php

					}

				// If authors archives page?
				} elseif ( is_author() ) {

					// Get ID of the page set to power the author archives
					$template_id = dslc_get_option( 'author', 'dslc_plugin_options_archives' );

					// If there is a page that powers it?
					if ( 'none' !== $template_id ) {

						// Output the button.
						?><a href="<?php echo esc_attr( self::get_editor_link( $template_id, get_the_ID() ) ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo $activate_button_position; ?>"><?php _e( 'Activate Live Composer', 'live-composer-page-builder' ); ?></a><?php

					}
				// If other archives ( not author )?
				} elseif ( is_archive() ) {
					// Get ID of the page set to power the archives of the shown post type.
					$template_id = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );

					// If there is a page that powers it?
					if ( 'none' !== $template_id ) {

						// Output the button.
						?><a href="<?php echo esc_attr( self::get_editor_link( $template_id, get_the_ID() ) ); ?>" class="dslca-activate-composer-hook dslca-position-<?php echo esc_attr( $activate_button_position ); ?>"><?php esc_html_e( 'Activate Live Composer', 'live-composer-page-builder' ); ?></a><?php

					}
				}

			endif;

		endif;

		if ( is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) :

			?><div class="dslca-container dslca-state-off" data-post-id="<?php the_ID(); ?>"></div><?php
		endif;
	}
}

DSLC_EditorInterface::init();
