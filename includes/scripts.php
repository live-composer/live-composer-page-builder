<?php

/**
 * Table of Contents
 *
 * - dslc_load_scripts ( Load CSS and JS files )
 * - dslc_load_admin_scripts ( Load CSS and JS files for the admin )
 * - dslc_load_fonts ( Load Google Fonts )
 */


/**
 * Load CSS and JS files
 *
 * @since 1.0
 */

function dslc_load_scripts() {

	global $dslc_active;

	$translation_array = array( 
		'str_confirm' => __( 'CONFIRM', 'dslc_string' ),
		'str_ok' => __( 'OK', 'dslc_string' ),
		'str_import' => __( 'IMPORT', 'dslc_string' ),
		'str_exit_title' => __( 'You are about to exit Live Composer', 'dslc_string' ),
		'str_exit_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'dslc_string' ),
		'str_area_helper_text' => __( 'MODULES AREA', 'dslc_string' ),
		'str_row_helper_text' => __( 'MODULES ROW', 'dslc_string' ),
		'str_import_row_title' => __( 'Import Row', 'dslc_string' ),
		'str_import_row_descr' => __( 'Copy the row export code bellow.', 'dslc_string' ),
		'str_del_module_title' => __( 'Delete Module', 'dslc_string' ),
		'str_del_module_descr' => __( 'Are you sure you want to delete this module?', 'dslc_string' ),
		'str_del_area_title' => __( 'Delete Area/Column', 'dslc_string' ),
		'str_del_area_descr' => __( 'Are you sure you want to delete this modules area?', 'dslc_string' ),
		'str_del_row_title' => __( 'Delete Row', 'dslc_string' ),
		'str_del_row_descr' => __( 'Are you sure you want to delete this row?', 'dslc_string' ),
		'str_export_row_title' => __( 'Export Row', 'dslc_string' ),
		'str_export_row_descr' => __( 'The code bellow is the importable code for this row.', 'dslc_string' ),
		'str_module_curr_edit_title' => __( 'You are currently editing a module', 'dslc_string' ),
		'str_module_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'dslc_string' ),
		'str_row_curr_edit_title' => __( 'You are currently editing a modules row', 'dslc_string' ),
		'str_row_curr_edit_descr' => __( 'You need to either <strong>confirm</strong> or <strong>cancel</strong> those changes before continuing.', 'dslc_string' ),
		'str_refresh_title' => __( 'You are about to refresh the page', 'dslc_string' ),
		'str_refresh_descr' => __( 'If you have unsaved changed they will be lost.<br>If the "Publish Changes" button is shown in bottom right corner click it to save.', 'dslc_string' ),
		'str_res_tablet' => __( 'tablet', 'dslc_string' ),
		'str_res_phone' => __( 'phone', 'dslc_string' )
	);
	
	/**
	 * CSS
	 */

	if ( DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_style( 'dslc-main-css', DS_LIVE_COMPOSER_URL . 'css/main.min.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome.min.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-modules-css', DS_LIVE_COMPOSER_URL . 'css/modules.min.css', array(), DS_LIVE_COMPOSER_VER);
	} else {
		wp_enqueue_style( 'dslc-main-css', DS_LIVE_COMPOSER_URL . 'css/main.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-font-awesome', DS_LIVE_COMPOSER_URL . 'css/font-awesome.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-modules-css', DS_LIVE_COMPOSER_URL . 'css/modules.css', array(), DS_LIVE_COMPOSER_VER);
	}

	wp_enqueue_style( 'dslc-plugins-css', DS_LIVE_COMPOSER_URL . 'css/plugins.css', array(), DS_LIVE_COMPOSER_VER);

	/**
	 * JavaScript
	 */

	wp_enqueue_script( 'dslc-plugins-js', DS_LIVE_COMPOSER_URL . 'js/plugins.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
	wp_enqueue_script( 'wp-mediaelement' );

	if ( DS_LIVE_COMPOSER_LOAD_MINIFIED )
		wp_enqueue_script( 'dslc-main-js', DS_LIVE_COMPOSER_URL . 'js/main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
	else
		wp_enqueue_script( 'dslc-main-js', DS_LIVE_COMPOSER_URL . 'js/main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

	if ( is_ssl() ) {
		wp_localize_script( 'dslc-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ) ) );
	} else {
		wp_localize_script( 'dslc-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ) ) );
	}
	
	/**
	 * Live Composer Active
	 */

	if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {

		wp_enqueue_media();
		
		/**
		 * CSS
		 */

		wp_enqueue_style( 'jquery-ui-slider' );
		wp_enqueue_style( 'dslc-builder-main-css', DS_LIVE_COMPOSER_URL . 'css/builder.main.css', array(), DS_LIVE_COMPOSER_VER);
		wp_enqueue_style( 'dslc-builder-plugins-css', DS_LIVE_COMPOSER_URL . 'css/builder.plugins.css', array(), DS_LIVE_COMPOSER_VER);

		/**
		 * JavaScript
		 */

		wp_enqueue_script( 'jquery-ui-core' );
		wp_enqueue_script( 'jquery-ui-sortable' );
		wp_enqueue_script( 'jquery-ui-draggable' );
		wp_enqueue_script( 'jquery-ui-droppable' );
		wp_enqueue_script( 'jquery-effects-core' );
		wp_enqueue_script( 'jquery-ui-slider' );
		wp_enqueue_script( 'wp-color-picker' );
		wp_enqueue_script( 'dslc-load-fonts', '//ajax.googleapis.com/ajax/libs/webfont/1/webfont.js' );
		wp_enqueue_script( 'dslc-builder-plugins-js', DS_LIVE_COMPOSER_URL . 'js/builder.plugins.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

		if ( DS_LIVE_COMPOSER_LOAD_MINIFIED )
			wp_enqueue_script( 'dslc-builder-main-js', DS_LIVE_COMPOSER_URL . 'js/builder.main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		else
			wp_enqueue_script( 'dslc-builder-main-js', DS_LIVE_COMPOSER_URL . 'js/builder.main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );

		if ( is_ssl() ) {
			wp_localize_script( 'dslc-builder-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'https' ) ) );
		} else {
			wp_localize_script( 'dslc-builder-main-js', 'DSLCAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php', 'http' ) ) );
		}
		wp_localize_script( 'dslc-builder-main-js', 'DSLCString', $translation_array );

	}

} add_action( 'wp_enqueue_scripts', 'dslc_load_scripts' );


/**
 * Load CSS and JS files for the admin
 *
 * @since 1.0
 */

function dslc_load_admin_scripts( $hook ) {	

	if ( ( $hook == 'post-new.php' || $hook == 'post.php' ) && DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_script( 'dslc-post-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/js/main.min.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'dslc-post-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/css/main.min.css', array(), DS_LIVE_COMPOSER_VER);
	} elseif ( $hook == 'post-new.php' || $hook == 'post.php' ) {
		wp_enqueue_script( 'dslc-post-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/js/main.js', array('jquery', 'jquery-ui-core', 'jquery-ui-datepicker'), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'jquery-ui-datepicker', 'http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.18/themes/smoothness/jquery-ui.css' );
		wp_enqueue_style( 'dslc-post-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/post-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	}

	if ( strpos( $hook,'dslc_plugin_options') !== false && DS_LIVE_COMPOSER_LOAD_MINIFIED ) {
		wp_enqueue_script( 'dslc-plugin-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/js/main.min.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	} elseif ( strpos( $hook,'dslc_plugin_options') !== false ) {
		wp_enqueue_script( 'dslc-plugin-options-js-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/js/main.js', array( 'jquery' ), DS_LIVE_COMPOSER_VER );
		wp_enqueue_style( 'dslc-plugin-options-css-admin', DS_LIVE_COMPOSER_URL . 'includes/plugin-options-framework/css/main.css', array(), DS_LIVE_COMPOSER_VER);
	}

} add_action( 'admin_enqueue_scripts', 'dslc_load_admin_scripts' );


/**
 * Load Google Fonts
 *
 * @since 1.0
 */

function dslc_load_fonts() {

	if ( isset( $_GET['dslc'] ) && $_GET['dslc'] == 'active' ) {

		wp_enqueue_style( 'dslc-gf-oswald', "//fonts.googleapis.com/css?family=Oswald:400,300,700&subset=latin,latin-ext" );
		wp_enqueue_style( 'dslc-gf-opensans', "//fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" );
		wp_enqueue_style( 'dslc-gf-roboto', "//fonts.googleapis.com/css?family=Roboto:400,700" );
		wp_enqueue_style( 'dslc-gf-lato', "//fonts.googleapis.com/css?family=Lato:100,300,400,700,900,100italic,300italic,400italic,700italic,900italic" );

	}

} add_action( 'wp_enqueue_scripts', 'dslc_load_fonts' );