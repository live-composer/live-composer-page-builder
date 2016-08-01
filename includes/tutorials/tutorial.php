<?php

/**
 * Table of Contents
 *
 * dslc_tut_load_scripts ( Load scripts for the tutorial )
 * dslc_tut_modal ( Display modal for the tutorial )
 * dslc_tut_options ( Register settings )
 */

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Load scripts for the tutorial
 *
 * @since 1.0
 */

function dslc_tut_load_scripts() {

	// Load minimized scripts and css resources
	$min_suffix = '';

	if ( SCRIPT_DEBUG ) {
		$min_suffix = '.min';
	}

	$tut_ch_one = dslc_get_option( 'lc_tut_chapter_one', 'dslc_plugin_options_tuts' );
	$tut_ch_two = dslc_get_option( 'lc_tut_chapter_two', 'dslc_plugin_options_tuts' );
	$tut_ch_three = dslc_get_option( 'lc_tut_chapter_three', 'dslc_plugin_options_tuts' );
	$tut_ch_four = dslc_get_option( 'lc_tut_chapter_four', 'dslc_plugin_options_tuts' );

	$tut_ids = array($tut_ch_one, $tut_ch_two, $tut_ch_three, $tut_ch_four);

	if ( is_singular() && isset( $_GET['dslc'] ) && in_array( get_the_ID(), $tut_ids ) ) {
		wp_enqueue_style( 'dslc-tut-css', DS_LIVE_COMPOSER_URL . 'includes/tutorials/tutorial' . $min_suffix . '.css', array(), DS_LIVE_COMPOSER_VER );
		wp_enqueue_script( 'dslc-tut-js', DS_LIVE_COMPOSER_URL . 'includes/tutorials/tutorial' . $min_suffix . '.js', array('jquery'), DS_LIVE_COMPOSER_VER );
	}

} add_action( 'wp_enqueue_scripts', 'dslc_tut_load_scripts' );


/**
 * Display modal for the tutorial
 *
 * @since 1.0
 */

function dslc_tut_modal() {

	$tut_ch_one = dslc_get_option( 'lc_tut_chapter_one', 'dslc_plugin_options_tuts' );
	$tut_ch_two = dslc_get_option( 'lc_tut_chapter_two', 'dslc_plugin_options_tuts' );
	$tut_ch_three = dslc_get_option( 'lc_tut_chapter_three', 'dslc_plugin_options_tuts' );
	$tut_ch_four = dslc_get_option( 'lc_tut_chapter_four', 'dslc_plugin_options_tuts' );

	$tut_ids = array($tut_ch_one, $tut_ch_two, $tut_ch_three, $tut_ch_four);

	if ( is_singular() && isset( $_GET['dslc'] ) && in_array( get_the_ID(), $tut_ids ) ) {

		$tut_ch_two_link = add_query_arg( array('dslc' => 'active'), get_permalink( $tut_ch_two ) );
		$tut_ch_three_link = add_query_arg( array('dslc' => 'active'), get_permalink( $tut_ch_three ) );
		$tut_ch_four_link = add_query_arg( array('dslc' => 'active'), get_permalink( $tut_ch_four ) );

		?>
			<input type="hidden" name="dslc_tut_settings" id="dslc_tut_settings" data-post-id="<?php echo get_the_ID(); ?>" />
			<input type="hidden" name="dslc_tut_ch_one" id="dslc_tut_ch_one" data-post-id="<?php echo $tut_ch_one; ?>" />
			<input type="hidden" name="dslc_tut_ch_two" id="dslc_tut_ch_two" data-post-id="<?php echo $tut_ch_two; ?>" />
			<input type="hidden" name="dslc_tut_ch_three" id="dslc_tut_ch_three" data-post-id="<?php echo $tut_ch_three; ?>" />
			<input type="hidden" name="dslc_tut_ch_four" id="dslc_tut_ch_four" data-post-id="<?php echo $tut_ch_four; ?>" />
			<input type="hidden" name="dslc_tut_ch_two_link" id="dslc_tut_ch_two_link" data-url="<?php echo $tut_ch_two_link; ?>" />
			<input type="hidden" name="dslc_tut_ch_three_link" id="dslc_tut_ch_three_link" data-url="<?php echo $tut_ch_three_link; ?>" />
			<input type="hidden" name="dslc_tut_ch_four_link" id="dslc_tut_ch_four_link" data-url="<?php echo $tut_ch_four_link; ?>" />
		<?php

	}

} add_action( 'wp_footer', 'dslc_tut_modal' );


/**
 * Register Settings
 *
 * @since 1.0
 */

function dslc_tut_options() {

	global $dslc_plugin_options;

	$pages = get_pages();
	$pages_opts = array(
		array(
			'label' => __( '- Select -', 'live-composer-page-builder' ),
			'value' => 'none'
		)
	);
	foreach ( $pages as $page ) {
		$pages_opts[] = array(
			'label' => $page->post_title,
			'value' => $page->ID
		);
	}

	$dslc_plugin_options['dslc_plugin_options_tuts'] = array(
		'title' => __( 'Tutorials', 'live-composer-page-builder' ),
		'options' => array(
			'lc_tut_chapter_one' => array(
				'label' => __( 'Chapter One', 'live-composer-page-builder' ),
				'std' => 'none',
				'type' => 'select',
				'descr' => __( 'Choose the page that will be used for chapter one of the tutorial.', 'live-composer-page-builder' ),
				'choices' => $pages_opts
			),
			'lc_tut_chapter_two' => array(
				'label' => __( 'Chapter Two', 'live-composer-page-builder' ),
				'std' => 'none',
				'type' => 'select',
				'descr' => __( 'Choose the page that will be used for chapter two of the tutorial.', 'live-composer-page-builder' ),
				'choices' => $pages_opts
			),
			'lc_tut_chapter_three' => array(
				'label' => __( 'Chapter Three', 'live-composer-page-builder' ),
				'std' => 'none',
				'type' => 'select',
				'descr' => __( 'Choose the page that will be used for chapter three of the tutorial.', 'live-composer-page-builder' ),
				'choices' => $pages_opts
			),
			'lc_tut_chapter_four' => array(
				'label' => __( 'Chapter Four', 'live-composer-page-builder' ),
				'std' => 'none',
				'type' => 'select',
				'descr' => __( 'Choose the page that will be used for chapter four of the tutorial.', 'live-composer-page-builder' ),
				'choices' => $pages_opts
			),
		)
	);

} add_action( 'dslc_hook_register_options', 'dslc_tut_options' );