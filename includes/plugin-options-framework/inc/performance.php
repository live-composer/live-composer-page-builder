<?php
// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

/**
 * Register options
 *
 * @since 1.0
 */
function dslc_perf_settings_init() {

	global $dslc_plugin_options;

	$dslc_plugin_options['dslc_plugin_options_performance'] = array(
		'title' => __( 'Performance', 'live-composer-page-builder' ),
		'options' => array(
			'lc_caching_engine' => array(

				'section' => 'dslc_plugin_options_performance',
				'label' => __( 'Basic HTML/CSS Caching', 'live-composer-page-builder' ),
				'std' => 'enabled',
				'type' => 'select',
				'descr' => __( 'Basic caching engine reduce page loading times. Rendered HTML and CSS get saved in the database.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Enabled',
						'value' => 'enabled',
					),
					array(
						'label' => 'Disabled',
						'value' => 'disabled',
					),
				),
			),
			'lc_gfont_subsets' => array(

				'section' => 'dslc_plugin_options_performance',
				'label' => __( 'Font Subsets', 'live-composer-page-builder' ),
				'std' => array( 'latin', 'latin-ext', 'cyrillic', 'cyrillic-ext' ),
				'type' => 'checkbox',
				'descr' => __( 'Which font subsets should be loaded.', 'live-composer-page-builder' ),
				'choices' => array(
					array(
						'label' => 'Latin',
						'value' => 'latin',
					),
					array(
						'label' => 'Latin Extended',
						'value' => 'latin-ext',
					),
					array(
						'label' => 'Cyrillic',
						'value' => 'cyrillic',
					),
					array(
						'label' => 'Cyrillic Extended',
						'value' => 'cyrillic-ext',
					),
					array(
						'label' => 'Greek',
						'value' => 'greek',
					),
					array(
						'label' => 'Greek Extended',
						'value' => 'greek-ext',
					),
					array(
						'label' => 'Vietnamese',
						'value' => 'vietnamese',
					),
					array(
						'label' => 'Arabic',
						'value' => 'arabic',
					),
					array(
						'label' => 'Bengali',
						'value' => 'bengali',
					),
					array(
						'label' => 'Devanagari',
						'value' => 'devanagari',
					),
					array(
						'label' => 'Gujarati',
						'value' => 'gujarati',
					),
					array(
						'label' => 'Gurmukhi',
						'value' => 'gurmukhi',
					),
					array(
						'label' => 'Hebrew',
						'value' => 'hebrew',
					),
					array(
						'label' => 'Kannada',
						'value' => 'kannada',
					),
					array(
						'label' => 'Khmer',
						'value' => 'khmer',
					),
					array(
						'label' => 'Malayalam',
						'value' => 'malayalam',
					),
					array(
						'label' => 'Myanmar',
						'value' => 'myanmar',
					),
					array(
						'label' => 'Oriya',
						'value' => 'oriya',
					),
					array(
						'label' => 'Sinhala',
						'value' => 'sinhala',
					),
					array(
						'label' => 'Tamil',
						'value' => 'tamil',
					),
					array(
						'label' => 'Telugu',
						'value' => 'telugu',
					),
					array(
						'label' => 'Thai',
						'value' => 'thai',
					),
				),
			),
			'lc_preset' => array(

				'section' => 'dslc_plugin_options_performance',
				'label' => __( 'Update modules with the same preset', 'live-composer-page-builder' ),
				'std' => 'enabled',
				'type' => 'radio',
				'choices' => array(
					array(
						'label' => 'After styling panel closes',
						'value' => 'enabled',
					),
					array(
						'label' => 'After page reloads',
						'value' => 'disabled',
					),
				),
			),
		),
	);

} add_action( 'dslc_hook_register_options', 'dslc_perf_settings_init' );
