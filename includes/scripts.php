<?php
/**
 * Scripts declarations class
 *
 * @package LiveComposer
 *
 * Table of Contents
 * - dslc_load_scripts_frontend ( Load CSS and JS files )
 * - dslc_load_scripts_admin ( Load CSS and JS files for the admin )
 * - dslc_load_fonts ( Load Google Fonts )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}


final class DSLC_Scripts {

	/**
	 * Init Scripts loading
	 */
	public static function init() {

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'dslc_load_iconfont_files' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'dslc_load_iconfont_files' ) );

		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'dslc_load_scripts_frontend' ) );
		add_action( 'wp_enqueue_scripts', array( __CLASS__, 'dslc_load_fonts' ) );
		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'dslc_load_scripts_admin' ) );
		add_action( 'admin_footer', array( __CLASS__, 'dslc_inline_js_plugin_title' ) );
	}

	/**
	 * Load icon font files (css).
	 *
	 * @return void
	 */
	public static function dslc_load_iconfont_files() {

		$load_for_admin_screens = array( 'toplevel_page_livecomposer_editor' );
		// ↑↑↑ List of admin screens were to load icon font files.
		$load_for_admin_screens = apply_filters( 'dslc_icons_admin_screens', $load_for_admin_screens );
		// Theme/extension plugin authors can extend list of the admin screens
		// were they want to use icons popup.
		if ( is_admin() ) {
			$screen_data = get_current_screen();
			$screen = $screen_data->base;
		} else {
			$screen = false;
		}

		if ( ! $screen || in_array( $screen, $load_for_admin_screens, true ) ) {

			// Array of icon fonts for load.
			global $dslc_var_icon_fonts;

			foreach ( $dslc_var_icon_fonts as $key => $font_details ) {
				$version_stamp = DS_LIVE_COMPOSER_VER;

				if ( isset( $font_details['version'] ) ) {
					$version_stamp = $font_details['version'];
				}

				wp_enqueue_style( 'dslc-' . $key, $font_details['font_path'], array(), $version_stamp );
				// wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome.css', array(), DS_LIVE_COMPOSER_VER );
			}
		}
	}

	/**
	 * Load CSS and JS files
	 *
	 * @since 1.0
	 */
	public static function dslc_load_scripts_frontend() {

		global $dslc_active;

		/**
		 * CSS
		 */
		wp_enqueue_style( 'dslc-main-css', DS_LIVE_COMPOSER_URL . 'css/frontend/main.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-modules-css', DS_LIVE_COMPOSER_URL . 'css/frontend/modules.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-plugins-css', DS_LIVE_COMPOSER_URL . 'css/frontend/plugins.css', array(), DS_LIVE_COMPOSER_VER );

		/**
		 * Load our IE-only stylesheet for all versions of IE:
		 * <!--[if IE]> ... <![endif]-->
		 */
		wp_enqueue_style( 'dslc-css-ie', DS_LIVE_COMPOSER_URL . 'css/ie.css', array( 'dslc-main-css' ), DS_LIVE_COMPOSER_VER );
		wp_style_add_data( 'dslc-css-ie', 'conditional', 'IE' );

		/**
		 * JavaScript
		 */
		wp_enqueue_script( 'wp-mediaelement' ); // Used for playing videos.
		wp_enqueue_script( 'imagesloaded' ); // Need this for Masonry.
		wp_enqueue_script( 'jquery-masonry' );

		wp_enqueue_script( 'dslc-plugins-js', DS_LIVE_COMPOSER_URL . 'js/frontend/plugins.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_script( 'dslc-main-js', DS_LIVE_COMPOSER_URL . 'js/frontend/main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER, $in_footer = true );

		if ( is_ssl() ) {

			wp_localize_script( 'dslc-main-js', 'DSLCAjax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ),
			) );
		} else {

			wp_localize_script( 'dslc-main-js', 'DSLCAjax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ),
			) );
		}

		/**
		 * Live Composer Editing State
		 */
		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			add_action( 'after_wp_tiny_mce', array( __CLASS__, 'callback_tinymce' ) );

			ob_start();
			wp_editor( '', 'enqueue_tinymce_scripts' );
			ob_end_clean();

			/**
			 * CSS
			 */
			wp_enqueue_style( 'dslc-builder-main-css', DS_LIVE_COMPOSER_URL . 'css/builder/builder.main.css', array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-builder-plugins-css', DS_LIVE_COMPOSER_URL . 'css/builder/builder.plugins.css', array(), DS_LIVE_COMPOSER_VER );

			/**
			 * JavaScript
			 */
			wp_enqueue_script( 'dslc-load-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js' );
			wp_enqueue_script( 'dslc-iframe-main-js', DS_LIVE_COMPOSER_URL . 'js/builder.frontend/builder.frontend.main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

		}
	}

	/**
	 * Fires after tinyMCE included
	 */
	public static function callback_tinymce() {
		?>
		<script type="text/javascript">
			window.parent.previewAreaTinyMCELoaded.call(window);
		</script>
		<?php
	}


	/**
	 * Load CSS and JS files in wp-admin area
	 *
	 * @since 1.1
	 */
	public static function dslc_load_scripts_admin( $hook ) {

		/* Check current screen id and set var accordingly */
		$current_screen = '';

		if ( 'post-new.php' === $hook || 'post.php' === $hook ) {
			$current_screen = 'post-editing';
		}

		if ( false !== strpos( $hook, 'dslc_plugin_options' ) ||
			  false !== strpos( $hook, 'tab-extend' ) ||
			 'dslc_plugin_options' === get_admin_page_parent() ) {

			$current_screen = 'dslc-options';
		}

		if ( 'toplevel_page_livecomposer_editor' === $hook ) {
			$current_screen = 'dslc-editing-screen';
		}

		/* Define some variables affecting further scripts loading */

		// Load minimized scripts and css resources.
		$min_suffix = '';

		if ( ! SCRIPT_DEBUG ) {
			$min_suffix = '.min';
		}

		// What protocol to use.
		$protocol = 'http';

		if ( is_ssl() ) {
			$protocol = 'https';
		}

		/* If current screen is Live Composer editing screen */
		if ( 'dslc-editing-screen' === $current_screen && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

			global $dslc_active;

			/**
			 * Live Composer Active
			 */

			wp_enqueue_media();

			/**
			 * CSS
			 */

			wp_enqueue_style( 'dslc-builder-main-css', DS_LIVE_COMPOSER_URL . 'css/builder/builder.main.css', array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-builder-plugins-css', DS_LIVE_COMPOSER_URL . 'css/builder/builder.plugins.css', array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome' . $min_suffix . '.css', array(), DS_LIVE_COMPOSER_VER );

			/**
			 * JavaScript
			 */

			wp_enqueue_script( 'jquery-ui-core' );
			wp_enqueue_script( 'jquery-ui-sortable' );
			wp_enqueue_script( 'jquery-ui-draggable' );
			wp_enqueue_script( 'jquery-ui-droppable' );
			wp_enqueue_script( 'jquery-effects-core' );
			wp_enqueue_script( 'jquery-ui-resizable' );
			wp_enqueue_script( 'jquery-ui-slider' );

			wp_enqueue_script( 'wp-mediaelement' );

			// Color picker.
			wp_enqueue_style( 'wp-color-picker' );

			// wp_enqueue_script( 'imagesloaded' ); // Need this for Masonry.
			// wp_enqueue_script( 'jquery-masonry' );
			wp_enqueue_script( 'dslc-builder-plugins-js', DS_LIVE_COMPOSER_URL . 'js/builder/builder.plugins.js', array( 'jquery', 'wp-color-picker' ), DS_LIVE_COMPOSER_VER );

			self::load_scripts( 'builder', 'dslc-builder-main-js' );

			wp_localize_script( 'dslc-builder-main-js', 'DSLCAjax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php', $protocol ),
			) );
			wp_localize_script( 'dslc-builder-main-js', 'DSLCSiteData', array(
				'siteurl' => get_option( 'siteurl' ),
			) );

			$translation_array = array(
				'str_confirm' => __( 'Confirm', 'live-composer-page-builder' ),
				'str_ok' => __( 'OK', 'live-composer-page-builder' ),
				'str_import' => __( 'IMPORT', 'live-composer-page-builder' ),
				'str_exit_title' => __( 'You are about to exit Live Composer', 'live-composer-page-builder' ),
				'str_exit_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'live-composer-page-builder' ),
				'str_area_helper_text' => __( 'MODULES AREA', 'live-composer-page-builder' ),
				'str_row_helper_text' => __( 'MODULES ROW', 'live-composer-page-builder' ),
				'str_import_row_title' => __( 'Import Row', 'live-composer-page-builder' ),
				'str_import_row_descr' => __( 'Copy the row export code bellow.', 'live-composer-page-builder' ),
				'str_del_module_title' => __( 'Delete Module', 'live-composer-page-builder' ),
				'str_del_module_descr' => __( 'Are you sure you want to delete this module?', 'live-composer-page-builder' ),
				'str_del_area_title' => __( 'Delete Area/Column', 'live-composer-page-builder' ),
				'str_del_area_descr' => __( 'Are you sure you want to delete this modules area?', 'live-composer-page-builder' ),
				'str_del_row_title' => __( 'Delete Row', 'live-composer-page-builder' ),
				'str_del_row_descr' => __( 'Are you sure you want to delete this row?', 'live-composer-page-builder' ),
				'str_export_row_title' => __( 'Export Row', 'live-composer-page-builder' ),
				'str_export_row_descr' => __( 'The code bellow is the importable code for this row.', 'live-composer-page-builder' ),
				'str_module_curr_edit_title' => __( 'You are currently editing a module', 'live-composer-page-builder' ),
				'str_module_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'live-composer-page-builder' ),
				'str_row_curr_edit_title' => __( 'You are currently editing a modules row', 'live-composer-page-builder' ),
				'str_row_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'live-composer-page-builder' ),
				'str_refresh_title' => __( 'You are about to refresh the page', 'live-composer-page-builder' ),
				'str_refresh_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'live-composer-page-builder' ),
				'str_res_tablet' => __( 'Tablet', 'live-composer-page-builder' ),
				'str_res_phone' => __( 'Phone', 'live-composer-page-builder' ),
			);

			global $dslc_available_fonts;

			wp_localize_script( 'dslc-builder-main-js', 'DSLCString', $translation_array );
			wp_localize_script( 'dslc-builder-main-js', 'DSLCFonts', $dslc_available_fonts );

			// Array of icons available to be used.
			global $dslc_var_icons;

			wp_localize_script( 'dslc-builder-main-js', 'DSLCIcons', $dslc_var_icons );
		}// End if().

		/* If current screen is standard post editing screen in WP Admin */
		if ( 'post-editing' === $current_screen ) {

			wp_enqueue_script( 'dslc-post-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/js/main' . $min_suffix . '.js', array( 'jquery', 'jquery-ui-core', 'jquery-ui-datepicker' ), DS_LIVE_COMPOSER_VER );

			if ( 'page' === get_post_type( get_the_ID() ) && 'post.php' === $hook ) {

				wp_localize_script( 'dslc-post-options-js-admin', 'tabData', array(
					'tabTitle' => __( 'Page Builder', 'live-composer-page-builder' ),
				) );
			}

			wp_enqueue_style( 'jquery-ui-datepicker', '//ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
			wp_enqueue_style( 'dslc-post-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/css/main' . $min_suffix . '.css', array(), DS_LIVE_COMPOSER_VER );

			/* If Yoast WP is active */
			if ( defined( 'WPSEO_VERSION' ) ) {

				wp_enqueue_script( 'dslc-yoast-seo-admin', DS_LIVE_COMPOSER_URL . 'js/builder.wpadmin/builder.yoast-seo.js', array(), DS_LIVE_COMPOSER_VER, true );
			}
		}

		/* If current screen is Live Composer options page */
		if ( 'dslc-options' === $current_screen ) {
			wp_enqueue_script( 'dslc-plugin-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/js/main' . $min_suffix . '.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main' . $min_suffix . '.css', array(), DS_LIVE_COMPOSER_VER );
			wp_localize_script( 'dslc-plugin-options-js-admin', 'dslcajax', array(
				'nonce' => wp_create_nonce( 'dslc-optionspanel-ajax' ),
			) );
		}

		wp_enqueue_style( 'dslc-css-wpadmin', DS_LIVE_COMPOSER_URL . 'css/wp-admin.css', array(), DS_LIVE_COMPOSER_VER );
	}

	/**
	 * TODO more universal func
	 * Dynamic scripts loading
	 *
	 * @param  string $dir          scripts search dir.
	 * @param  array  $exclude_dirs exclude dirs from search.
	 */
	public static function load_scripts( $dir = '*', $scriptdeps = '', $exclude_dirs = array() ) {

		/** Load builder files dynamically */
		$directories = glob( DS_LIVE_COMPOSER_ABS . '/js/' . $dir, GLOB_ONLYDIR );

		foreach ( $directories as $dir ) {

			$files = glob( $dir . '/*.js' );

			foreach ( $files as $file ) {

				$filename = basename( $file );

				$filepath = explode( '/', $file );
				array_pop( $filepath );
				$filedir = array_pop( $filepath );

				if ( in_array( $filedir, $exclude_dirs, true ) ) {

					continue;
				}

				$filehandle = 'dslc-' . str_replace( '.', '-', $filename );
				wp_enqueue_script( $filehandle, DS_LIVE_COMPOSER_URL . 'js/' . $filedir . '/' . $filename, $scriptdeps, DS_LIVE_COMPOSER_VER, true );
			}
		}
	}



	/**
	 * Load Google Fonts
	 *
	 * @since 1.0
	 */
	public static function dslc_load_fonts() {

		if ( isset( $_GET['dslc'] ) ) {

			wp_enqueue_style( 'dslc-gf-opensans', '//fonts.googleapis.com/css?family=Open+Sans:400,600' );
			wp_enqueue_style( 'dslc-gf-roboto-condesed', '//fonts.googleapis.com/css?family=Roboto+Condensed:400,900' );
		}
	}

	/**
	 * Inline JS to shorten the plugin title in WP Admin
	 *
	 * @since 1.0.7.2
	 */
	public static function dslc_inline_js_plugin_title() {
		?>

		<script type="text/javascript">
			jQuery(document).ready(function($){
				// Shorten plugin name.
				jQuery('.plugins [data-slug="live-composer-page-builder"] .plugin-title strong').text('Live Composer');

				var target_menu_items = '';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_templates"],';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_hf"],';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_testimonials"].menu-top,';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_staff"].menu-top,';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_projects"].menu-top,';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_galleries"].menu-top,';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_partners"].menu-top,';
				target_menu_items += '#adminmenu a[href="edit.php?post_type=dslc_downloads"].menu-top';

				// Add LC badge to our links in WP Admin sidebar.
				jQuery( target_menu_items ).append(' <attr title="Live Composer" class="dslc-menu-label">LC</attr>');

				// Add LC badge to action link in WP Admin > posts listing.
				jQuery( '.edit-in-live-composer a' ).prepend(' <attr title="Live Composer" class="dslc-action-label">LC</attr>');

			});

		</script>
	<?php
	}
}

DSLC_Scripts::init();
