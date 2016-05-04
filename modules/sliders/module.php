<?php

class DSLC_Sliders extends DSLC_Module {

	var $module_id;
	var $module_title;
	var $module_icon;
	var $module_category;

	function __construct() {

		$this->module_id = 'DSLC_Sliders';
		$this->module_title = __( 'Slider (Revolution)', 'live-composer-page-builder' );
		$this->module_icon = 'picture';
		$this->module_category = 'elements';

	}

	function options() {

		// Get Rev Sliders
		global $wpdb;
		$slider_choices = array();
		$slider_choices[] = array(
			'label' => __( '-- Select --', 'live-composer-page-builder' ),
			'value' => 'not_set',
		);

		$table_name = $wpdb->prefix . 'revslider_sliders';
		if($wpdb->get_var("SHOW TABLES LIKE '$table_name'" == $table_name)){

			$sliders = $wpdb->get_results( "SELECT id, title, alias FROM $table_name" );

			if ( ! empty( $sliders ) ) {

				foreach ( $sliders as $slider ) {
					$slider_choices[] = array(
						'label' => $slider->title,
						'value' => $slider->alias
					);
				}

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
						'value' => 'desktop'
					),
					array(
						'label' => __( 'Tablet', 'live-composer-page-builder' ),
						'value' => 'tablet'
					),
					array(
						'label' => __( 'Phone', 'live-composer-page-builder' ),
						'value' => 'phone'
					),
				),
			),
			array(
				'label' => __( 'Revolution Slider', 'live-composer-page-builder' ),
				'id' => 'slider',
				'std' => 'not_set',
				'type' => 'select',
				'choices' => $slider_choices
			)
		);

		$dslc_options = array_merge( $dslc_options, $this->shared_options( 'animation_options', array( 'hover_opts' => false ) ) );
		$dslc_options = array_merge( $dslc_options, $this->presets_options() );

		return apply_filters( 'dslc_module_options', $dslc_options, $this->module_id );

	}

	function output( $options ) {

		global $dslc_active;

		if ( $dslc_active && is_user_logged_in() && current_user_can( DS_LIVE_COMPOSER_CAPABILITY ) )
			$dslc_is_admin = true;
		else
			$dslc_is_admin = false;

		$this->module_start( $options );

		/* Module output stars here */

			if ( ! isset( $options['slider'] ) || $options['slider'] == 'not_set' ) {

				if ( $dslc_is_admin ) :
					?><div class="dslc-notification dslc-red"><?php _e( 'Click the cog icon on the right of this box to choose which slider to show.', 'live-composer-page-builder' ); ?> <span class="dslca-module-edit-hook dslc-icon dslc-icon-cog"></span></span></div><?php
				endif;

			} else {

				echo do_shortcode( '[rev_slider '. $options['slider'] .']' );

			}

		/* Module output ends here */

		$this->module_end( $options );

	}

}