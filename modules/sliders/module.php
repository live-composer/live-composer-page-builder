<?php

// Prevent direct access to the file.
if ( ! defined( 'ABSPATH' ) ) {
	header( 'HTTP/1.0 403 Forbidden' );
	exit;
}

class DSLC_Sliders extends DSLC_Module {

	public $module_id;
	public $module_title;
	public $module_icon;
	public $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Sliders';
		$this->module_title = __( 'Slider (Revolution)', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'General';

	}

	/**
	 * Module options.
	 * Function build array with all the module functionality and styling options.
	 * Based on this array Live Composer builds module settings panel.
	 * – Every array inside $dslc_options means one option = one control.
	 * – Every option should have unique (for this module) id.
	 * – Options divides on "Functionality" and "Styling".
	 * – Styling options start with css_XXXXXXX
	 * – Responsive options start with css_res_t_ (Tablet) or css_res_p_ (Phone)
	 * – Options can be hidden.
	 * – Options can have a default value.
	 * – Options can request refresh from server on change or do live refresh via CSS.
	 *
	 * @return array All the module options in array.
	 */
	function options() {

		// Check if we have this module options already calculated
		// and cached in WP Object Cache.
		$cached_dslc_options = wp_cache_get( 'dslc_options_' . $this->module_id, 'dslc_modules' );
		if ( $cached_dslc_options ) {
			return apply_filters( 'dslc_module_options', $cached_dslc_options, $this->module_id );
		}

		// Get Rev Sliders
		global $wpdb;
		$table_name = $wpdb->prefix . 'revslider_sliders';
		$sliders = $wpdb->get_results( "SELECT id, title, alias FROM $table_name" );
		$slider_choices = array();

		$slider_choices[] = array(
			'label' => __( '-- Select --', 'live-composer-page-builder' ),
			'value' => 'not_set',
		);

		if ( ! empty( $sliders ) ) {

			foreach ( $sliders as $slider ) {
				$slider_choices[] = array(
					'label' => $slider->title,
					'value' => $slider->alias,
				);
			}
		}

		$dslc_options = array(
			array(
				'label' => __( 'Show On', 'live-composer-page-builder' ),
				'id' => 'css_show_on',
				'std' => 'desktop tablet phone',
				'type' => 'checkbox',
				'choices' => array(
					array(
						'label' => __( 'Desktop', 'live-composer-page-builder' ),
						'value' => 'desktop',
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet',
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone',
					),
				),
			),
			array(
				'label' => __( 'Revolution Slider', 'live-composer-page-builder' ),
				'id' => 'slider',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $slider_choices,
			),
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array(
			'hover_opts' => false,
		) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		// Cache calculated array in WP Object Cache.
		wp_cache_add( 'dslc_options_' . $this->module_id, $dslc_options, 'dslc_modules' );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}
	/**
	 * Module HTML output.
	 *
	 * @param  array $options Module options to fill the module template.
	 * @return void
	 */
	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) ) {
			$dslc_is_admin = true;
		} else { $dslc_is_admin = false;
		}

		/* Module output stars here */

		if ( ! isset( $options['slider'] ) || $options['slider'] == 'not_set' ) {

			if ( $dslc_is_admin ) :
				?><div class="dslc-notification dslc-red"><?php _e( 'Click the cog icon on the right of this box to choose which slider to show.', 'live-composer-page-builder' ); ?> <span class="dslca-module-edit-hook dslc-icon dslc-icon-cog"></span></span></div><?php
		endif;

		} else {

			echo '[rev_slider ' . $options['slider'] . ']';

		}

	}

}
