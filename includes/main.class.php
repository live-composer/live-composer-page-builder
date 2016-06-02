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

	const engine_ver = 2;

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

	/**
	 * Repeater for underscore templates
	 * @return string
	 */
	static function dslc_repeatable( $atts, $content ) {

		if ( ! isset( $atts['module-instance-id'] ) ) {

			trigger_error("Module instance id not exists ", E_USER_WARNING );
			return '';
		}

		$curr_module = DSLC_Main::get_module_class( $atts['module-instance-id'] );

		if ( ! empty( $atts['repeatable'] ) && method_exists( $curr_module, $atts['repeatable']) ) {

			return $curr_module->$atts['repeatable']( $atts, $content );
		}

		return 'something gone wrong';
	}

	/**
	 * Returns active template module.
	 *
	 * @param  int $mod_id
	 * @return DSLC_Module
	 */
	static function get_module_class( $mod_id ) {

		global $LC_Registry;

		$active_modules = $LC_Registry->get( 'activeModules' );

		if ( ! isset( $active_modules['a' . $mod_id] ) ) {

			trigger_error( "No active module under given instnance id.", E_USER_WARNING );
			return '';
		}

		$curr_module = $active_modules['a' . $mod_id];

		return $curr_module;
	}

	/**
	 * Workaround above the WP safety issues
	 *
	 * @param  string $content
	 * @return srting
	 */
	static function dslc_do_shortcode( $content ) {

		$content = preg_replace("/{{(.*?)}}/", '[$1]', $content);
		$content = do_shortcode( $content );

		return $content;
	}

	/**
	 * Returns concrete prop from repeater object
	 *
	 * @param  array $atts
	 * @return string
	 */
	static function dslc_module_sc( $atts = [] ) {

		if ( isset( $atts['module-instance-id'] ) ) {

			$curr_class = DSLC_Main::get_module_class( $atts['module-instance-id'] );
		} else {

			global $LC_Registry;
			$curr_class = $LC_Registry->get( 'curr_class' );
		}

		$mod_method = @$atts['module-method'];

		if ( ! empty( $mod_method ) && method_exists( $curr_class, $mod_method ) ) {

			return $curr_class->$mod_method( $atts );
		}
	}

	/**
	 * Dslc tuts
	 */
	static function dslc_tutorials_load()
	{
		$dslc_tutorials = false;
		if ( apply_filters( 'dslc_tutorials', $dslc_tutorials ) ) {
			include DS_LIVE_COMPOSER_ABS . '/includes/tutorials/tutorial.php';
		}
	}

	/**
	 * On activation hook
	 */
	static function dslc_on_activation()
	{
		set_transient('_dslc_activation_redirect_1', true, 60);
	}

	/**
	 * Welcome hook
	 */
	static function welcome()
	{
		if ( ! get_transient( '_dslc_activation_redirect_1' ) )
			return;

		// Delete the redirect transient
		delete_transient( '_dslc_activation_redirect_1' );

		// Bail if activating from network, or bulk
		if ( is_network_admin() || isset( $_GET['activate-multi'] ) )
			return;

		wp_safe_redirect( admin_url( 'admin.php?page=dslc_getting_started' ) ); exit;
	}

	/**
	 * Returns static html cache from current page
	 * @return string
	 */
	static function getCurPageHTMLCache()
	{
		global $dslc_post_types;

		$currID = get_the_ID();
		$template_ID = 0;

		// If currently showing a singular post of a post type that supports "post templates"
		if ( is_singular( $dslc_post_types ) ) {

			// Get template ID set for currently shown post
			$template_ID = dslc_st_get_template_ID( get_the_ID() );
		}

		// If currently showing a category archive page
		if ( is_archive() && !is_author() && !is_search() ) {

			// Get ID of the page set to power the category of the current post type
			$template_ID = dslc_get_option( get_post_type(), 'dslc_plugin_options_archives' );
		}

		// If currently showing an author archive page
		if ( is_author() ) {

			// Get ID of the page set to power the author archives
			$template_ID = dslc_get_option( 'author', 'dslc_plugin_options_archives' );
		}

		// If currently showing a search results page
		if ( is_search() ) {

			// Get ID of the page set to power the search results page
			$template_ID = dslc_get_option('search_results', 'dslc_plugin_options_archives');
		}

		// If currently showina 404 page
		if ( is_404() ) {

			// Get ID of the page set to power the 404 page
			$template_ID = dslc_get_option( '404_page', 'dslc_plugin_options_archives' );
		}

		// If template ID exists
		if ( $template_ID > 0 ) {

			$currID = $template_ID;
		}

		return base64_decode( get_post_meta( $currID, 'dslc_cache', true ) );
	}

}