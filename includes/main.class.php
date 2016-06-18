<?php
/**
 * Main DSLC class
 */

/**
 * DSLC_Main class
 *
 * engine_ver - engine version. Global engine version.
 */
class DSLC_Main {

	const engine_ver = 1;

	/**
	 * Wp loaded hook
	 */
	static function wp_loaded()
	{
		global $LC_Registry;

		if ( ! is_user_logged_in() && $LC_Registry->get( 'dslc_active' ) == true ) {

			wp_redirect( "Location: //" . $_SERVER['REDIRECT_URL'], 301 );
			die();
		}

		add_shortcode('dslc-repeatable', [ __CLASS__, 'dslc_repeatable'] );
		add_shortcode('dslc-module-sc', [ __CLASS__, 'dslc_module_sc'] );
	}

	static function init() {

		add_action( 'admin_init', array( __CLASS__, 'dslc_welcome' ) );
		add_action( 'after_setup_theme', 'dslc_tutorials_load' );
	}

/**
	 * Tutorials disabled by default
	 *
	 * Use the next call to activate tutorilas form your theme
	 * add_filter( 'dslc_tutorials', '__return_true' );
	 *
	 * @since 1.0.7
	 */

	function dslc_tutorials_load() {

		$dslc_tutorials = false;

		if ( apply_filters( 'dslc_tutorials', $dslc_tutorials ) ) {

			include DS_LIVE_COMPOSER_ABS . '/includes/tutorials/tutorial.php';
		}
	}

	/**
	 * On activation hook
	 */
	static function dslc_on_activation() {

		DSLC_Upgrade::init();

		set_transient('_dslc_activation_redirect_1', true, 60);
	}

	static function dslc_welcome() {

				// Make Welcome screen optional for the theme developers
		$show_welcome_screen = true;

	   	if ( apply_filters( 'dslc_show_welcome_screen', $show_welcome_screen ) ) {

	   		return;
	   	}

		// Bail if no activation redirect
		if ( ! get_transient( '_dslc_activation_redirect_1' ) ) {

			return;
		}

		// Delete the redirect transient
		delete_transient( '_dslc_activation_redirect_1' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {

			return;
		}

		wp_safe_redirect( admin_url( 'admin.php?page=dslc_getting_started' ) ); 
		exit;
	}
}