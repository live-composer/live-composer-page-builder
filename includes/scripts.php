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
		// Assets to load in the Gutenberg Block editor.
		add_action( 'enqueue_block_editor_assets',  array( __CLASS__, 'enqueue_gutenberg_assets' ) );
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
		wp_enqueue_style( 'dslc-plugins-css', 	DS_LIVE_COMPOSER_URL . 'css/dist/frontend.plugins.min.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-frontend-css', 	DS_LIVE_COMPOSER_URL . 'css/dist/frontend.min.css', array(), DS_LIVE_COMPOSER_VER );

		/**
		 * JavaScript
		 */
		wp_enqueue_script( 'wp-mediaelement' ); // Used for playing videos.
		wp_enqueue_script( 'imagesloaded' ); // Need this for Masonry.
		wp_enqueue_script( 'jquery-masonry' );

		wp_enqueue_script( 'dslc-plugins-js',	DS_LIVE_COMPOSER_URL . 'js/dist/client_plugins.min.js',		array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_script( 'dslc-main-js',		DS_LIVE_COMPOSER_URL . 'js/dist/client_frontend.min.js',	array( 'jquery' ), DS_LIVE_COMPOSER_VER, $in_footer = true );


		wp_localize_script( 'dslc-main-js', 'DSLCAjax', array(
			'ajaxurl' => admin_url( 'admin-ajax.php' ),
		) );

		/**
		 * Live Composer Editing State
		 */
		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
			ob_start();
			wp_editor( '', 'enqueue_tinymce_scripts' );
			ob_end_clean();

			/**
			 * CSS
			 */
			wp_enqueue_style( 'dslc-builder-main-css', 		DS_LIVE_COMPOSER_URL . 'css/dist/builder.min.css', 			array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-builder-plugins-css',	DS_LIVE_COMPOSER_URL . 'css/dist/builder.plugins.min.css', 	array(), DS_LIVE_COMPOSER_VER );

			/**
			 * JavaScript
			 */
			wp_enqueue_script( 'dslc-load-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js' );
			wp_enqueue_script( 'dslc-editor-frontend-js', DS_LIVE_COMPOSER_URL . 'js/dist/editor_frontend.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

			add_action( 'after_wp_tiny_mce', array( __CLASS__, 'callback_tinymce' ) );
		}
	}

	/**
	 * Fires after tinyMCE included
	 */
	public static function callback_tinymce() {
		?>
		<script type="text/javascript">
			window.parent.previewAreaTinyMCELoaded(window);
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

			wp_enqueue_style( 'dslc-builder-main-css', 		DS_LIVE_COMPOSER_URL . 'css/dist/builder.min.css', 			array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-builder-plugins-css', 	DS_LIVE_COMPOSER_URL . 'css/dist/builder.plugins.min.css', 	array(), DS_LIVE_COMPOSER_VER );
			wp_enqueue_style( 'dslc-font-awesome',			DS_LIVE_COMPOSER_URL . 'css/font-awesome.min.css', 			array(), DS_LIVE_COMPOSER_VER );

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

			global $wp_scripts;

			// if localization doesnt already exist on the color picker, then add it
			if( !array_key_exists("data", $wp_scripts->registered["wp-color-picker"]->extra) ) {
				$wp_scripts->localize('wp-color-picker',
					'wpColorPickerL10n',
					array(
						'clear'            => __( 'Clear' ),
						'clearAriaLabel'   => __( 'Clear color' ),
						'defaultString'    => __( 'Default' ),
						'defaultAriaLabel' => __( 'Select default color' ),
						'pick'             => __( 'Select Color' ),
						'defaultLabel'     => __( 'Color value' ),
					));
			}

			// wp_enqueue_script( 'imagesloaded' ); // Need this for Masonry.
			// wp_enqueue_script( 'jquery-masonry' );
			wp_enqueue_script(
				'dslc-editor-plugins-js',
				DS_LIVE_COMPOSER_URL . 'js/dist/editor_plugins.min.js',
				array( 'jquery', 'wp-color-picker' ),
				filemtime( DS_LIVE_COMPOSER_ABS . '/js/dist/editor_plugins.min.js' ) // Version: filemtime — Gets file modification time.
			);

			wp_enqueue_script(
				'dslc-editor-backend-js',
				DS_LIVE_COMPOSER_URL . 'js/dist/editor_backend.min.js',
				array( 'jquery', 'wp-color-picker' ),
				filemtime( DS_LIVE_COMPOSER_ABS . '/js/dist/editor_backend.min.js' ) // Version: filemtime — Gets file modification time.
			);

			// self::load_scripts( 'builder', 'dslc-editor-backend-js' );

			wp_localize_script( 'dslc-editor-backend-js', 'DSLCAjax', array(
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'_wpnonce' => wp_create_nonce( 'dslc-ajax-wpnonce' ),
			) );
			wp_localize_script( 'dslc-editor-backend-js', 'DSLCSiteData', array(
				'siteurl' => get_option( 'siteurl' ),
				'editorUrl' => DS_LIVE_COMPOSER_URL
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

			wp_localize_script( 'dslc-editor-backend-js', 'DSLCString', $translation_array );
			wp_localize_script( 'dslc-editor-backend-js', 'DSLCFonts', $dslc_available_fonts );

			// Array of icons available to be used.
			global $dslc_var_icons;

			wp_localize_script( 'dslc-editor-backend-js', 'DSLCIcons', $dslc_var_icons );

			$dslc_main_options = array();
			$section_padding_vertical = dslc_get_option( 'lc_section_padding_vertical', 'dslc_plugin_options' );
			$dslc_main_options['section_padding_vertical'] = $section_padding_vertical;

			wp_localize_script( 'dslc-editor-backend-js', 'DSLCMainOptions', $dslc_main_options );
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
				$fileversion = filemtime( DS_LIVE_COMPOSER_ABS . '/js/' . $filedir . '/' . $filename ); // Version: filemtime — Gets file modification time.
				wp_enqueue_script( $filehandle, DS_LIVE_COMPOSER_URL . 'js/' . $filedir . '/' . $filename, $scriptdeps, $fileversion, true );
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

	/**
	 * Assets to load in the Gutenberg Block editor.
	 *
	 * @return void
	 */
	public static function enqueue_gutenberg_assets() {
		$id = get_the_ID();
		$post_type = get_post_type( $id );

		if ( dslc_can_edit_in_lc( $post_type ) &&
				! dslc_cpt_use_templates( $post_type ) &&
				$post_type != 'dslc_testimonials' ) {

			// Get editing URL.
			$url = DSLC_EditorInterface::get_editor_link_url( $id );
			$js_file = 'js/builder.wpadmin/builder.gutenberg.js';
			$editor_content_html = get_post_meta(
				get_the_ID(),
				'dslc_content_for_search',
				true
			);

			$lc_gutenberg_admin_data = [
				'toolbarIconPath' => DS_LIVE_COMPOSER_URL . 'images/icons/lc-admin-icon-dark.svg',
				'editButtonText' => __( 'Open in Live Composer', 'live-composer-page-builder' ),
				'noticeText' => __( 'Edit this page in the front-end page builder → ', 'live-composer-page-builder' ),
				'noticeAction' => __( 'Open in Live Composer', 'live-composer-page-builder' ),
				'editAction' => $url,
				'editorContentHtml' => $editor_content_html,
			];

			wp_enqueue_script(
				'lc-gutenberg-admin',
				DS_LIVE_COMPOSER_URL . $js_file,
				array( 'wp-editor' ),
				filemtime( DS_LIVE_COMPOSER_ABS . '/' . $js_file ), // Version: filemtime — Gets file modification time.
				true
			);

			wp_localize_script( 'lc-gutenberg-admin', 'lcAdminData', $lc_gutenberg_admin_data );
		}
	}
}

DSLC_Scripts::init();
