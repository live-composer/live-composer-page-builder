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
	global $dslc_var_modules;

	$dslc_plugin_options['dslc_plugin_options_performance'] = array(
		'title' => __( 'Performance', 'live-composer-page-builder' ),
		'options' => array(

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
					)
				)
			)
		)
	);

} add_action( 'dslc_hook_register_options', 'dslc_perf_settings_init' );