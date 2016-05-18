<?php
/**
 * Main DSLC class
 */

/**
 * DSLC_Main class
 */
class DSLC_Main {

	/**
	 * Wp loaded hook
	 */
	static function wp_loaded()
	{
		global $LC_Registry;

		if(!is_user_logged_in() && $LC_Registry->get( 'dslc_active' ) == true){

			wp_redirect("Location: //" . $_SERVER['REDIRECT_URL'], 301);
			die();
		}

		add_shortcode('dslc-repeatable', [ __CLASS__, 'dslc_repeatable'] );
		add_shortcode('dslc-repeatable-prop', [ __CLASS__, 'dslc_repeatable_prop'] );
	}

	/**
	 * Repeater for underscore templates
	 * @return [] some data pull
	 */
	static function dslc_repeatable( $attrs, $content ) {

		if ( ! isset( $attrs['module_instance_id'] ) ) {

			pre($attrs);
			trigger_error("Module instance id not exists ", E_USER_WARNING );
			return '';
		}

		global $LC_Registry;

		$activeModules = $LC_Registry->get( 'activeModules' );

		if ( ! isset( $activeModules['a' . $attrs['module_instance_id']] ) ) {

			pre( $activeModules );
			pre( $attrs['module_instance_id'] );

			trigger_error( "No active module under given instnance id.", E_USER_WARNING );
			return '';
		}

		$currModule = $activeModules['a' . $attrs['module_instance_id']];


		if ( ! empty( $attrs['array'] ) && method_exists( $currModule, $attrs['array']) ) {

			$repeatArray = $currModule->$attrs['array']();

			if ( ! is_array( $repeatArray ) ) {

				pre( $repeatArray );
				trigger_error( "Method has to return an array!", E_USER_WARNING );
				return '';
			}
		}


		if ( ! empty( $attrs['wpquery'] ) && method_exists( $currModule, $attrs['wpquery']) ) {

			$repeatArray = $currModule->$attrs['wpquery']();

			if ( ! $repeatArray instanceof WP_Query ) {

				pre( $repeatArray );
				trigger_error( $repeatArray, E_USER_WARNING );
				return 'Method has to return WP_Query!';
			}

			$temp = array();

			while( $repeatArray->have_posts() ) {

				$repeatArray->the_post();
				global $post;

				$temp[] = $post;
			}

			$repeatArray = $temp;
		}

		$out = '';

		if ( is_array( $repeatArray ) ) {

			foreach( $repeatArray as $repeatElement ) {

				$LC_Registry->set( 'repeater', $repeatElement );
				$LC_Registry->set( 'repeaterCurrClass', $currModule );
				$out .= do_shortcode( $content );
			}

			$LC_Registry->set( 'repeater', null );
			$LC_Registry->set( 'repeaterCurrClass', null );
		}

		return $out;
	}

	/**
	 * Returns concrete prop from repeater object
	 *
	 * @param  array $atts
	 * @return string
	 */
	static function dslc_repeatable_prop( $atts ) {

		global $LC_Registry;
		$repeater = $LC_Registry->get('repeater');
		$currModule = $LC_Registry->get( 'repeaterCurrClass' );

		if ( ! empty( $atts['module-method'] ) && method_exists( $currModule, $atts['module-method'] ) ) {

			return $currModule->$atts['module-method']();
		}


		if ( ! empty( $atts['array-field'] ) ) {

			if ( is_array( $repeater ) && isset( $repeater[$atts['array-field']] ) ) {

				return do_shortcode( $repeater[$atts['array-field']] );
			}
		}


		if ( ! empty( $atts['wppost-field'] ) ) {

			if ( $repeater instanceof WP_Post && isset( $repeater->$atts['wppost-field'] ) ) {

				return do_shortcode( $repeater->$atts['wppost-field'] );
			}
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